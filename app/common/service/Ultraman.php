<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/6
 * Time: 5:05 下午
 */

namespace app\common\service;

use app\common\bean\Ultraman as UltramanBean;
use app\common\model\mysql\{Ultraman as UltramanModel, UltramanLog as UltramanLogModel};
use think\facade\Db;

class Ultraman extends UltramanBean
{
    public function __construct($page = 0, $pageSize = null)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new UltramanModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:获取奥特曼列表
     * User: Jenick
     * Date: 2021/1/7
     * Time: 12:45 上午
     */
    public function getList()
    {
        $field = "u.id uid, 
                   user.username, 
                   u.deposit_base, 
                   u.aims,
                   DATE_FORMAT(u.end_time, '%Y-%m-%d') as end_time, 
                   (u.aims - u.deposit_base) as difference, 
                   if((truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 0),truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2),0.00) as schedule";
        $startTime = date('Y-01-01 00:00:00');
        $endTime = date('Y-12-31 23:59:59');
        $where = [
            ['u.start_time', '<=', $startTime],
            ['u.end_time', '>=', $endTime]
        ];
        $this->model->setField($field);
        $this->model->setWhereArr($where);
        $res = $this->model->findAllInfoJoinUser();
        return $res;
    }

    /**
     * Notes:新增数据
     * User: Jenick
     * Date: 2021/1/7
     * Time: 12:45 上午
     * @throws \Exception
     */
    public function addUltraman()
    {
        Db::startTrans();
        try {

            $where = [
                ['u.start_time', '<=', $this->getStartTime()],
                ['u.end_time', '>=', $this->getEndTime()],
                ['u.p_user_id', '=', $this->getPUserId()]
            ];
            $this->model->setWhereArr($where);
            $res = $this->model->findOneInfoJoinUser();
            if ($res) {
                throw new \Exception('该贴吧用户已参加本次奥特曼活动');
            }
            $ultramanData = [
                'p_user_id' => $this->getPUserId(),
                'deposit_base' => $this->getDepositBase(),
                'aims' => $this->getAims(),
                'start_time' => $this->getStartTime(),
                'end_time' => $this->getEndTime(),
                'create_time' => $this->getCreateTime(),
                'update_time' => $this->getUpdateTime()
            ];
            $uid = $this->model->insertGetId($ultramanData);
            if (!$uid) {
                throw new \Exception('新增失败');
            }
            $logData = [
                'type' => 1,
                'uid' => $uid,
                'deposit_base' => $this->getDepositBase(),
                'aims' => $this->getAims(),
                'create_time' => $this->getCreateTime()
            ];
            $logModel = new UltramanLogModel();
            $lid = $logModel->insertGetId($logData);
            if (!$lid) {
                throw new \Exception('日志记录失败');
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            throw new \Exception($e->getMessage());
        }
        return true;
    }

    /**
     * Notes:获取贴吧ID奥特曼信息
     * User: Jenick
     * Date: 2021/1/7
     * Time: 6:15 下午
     */
    public function getPostItUserUltramanInfo()
    {
        $field = "u.id uid, 
                   user.username, 
                   u.deposit_base, 
                   u.aims,
                   DATE_FORMAT(u.end_time, '%Y-%m-%d') as end_time, 
                   (u.aims - u.deposit_base) as difference, 
                   if((truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 0),truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2),0.00) as schedule";


        $startTime = date('Y-01-01 00:00:00');
        $endTime = date('Y-12-31 23:59:59');
        $where = [
            ['u.start_time', '<=', $startTime],
            ['u.end_time', '>=', $endTime],
            ['u.p_user_id', '=', $this->getPUserId()]
        ];
        $this->model->setField($field);
        $this->model->setWhereArr($where);
        $res = $this->model->findOneInfoJoinUser();
        return $res;
    }
}