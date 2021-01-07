<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/6
 * Time: 5:05 下午
 */

namespace app\common\service;

use app\common\bean\Ultraman as UltramanBean;
use app\common\model\mysql\PostItUser;
use app\common\model\mysql\Ultraman as UltramanModel;
use think\facade\Db;

class Ultraman extends UltramanBean
{
    public function __construct($page = 0, $pageSize = 10)
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
     */
    public function addUltraman()
    {
        Db::startTrans();
        try {
            $postItUserData = [
                'username' => $this->getPostItUser()->getUsername(),
                'create_time' => $this->getPostItUser()->getCreateTime()
            ];
            $postItUserModel = new PostItUser();
            $pUserId = $postItUserModel->insertGetId($postItUserData);
            if (!$pUserId) {
                throw new \Exception('新增贴吧用户失败');
            }
            $ultramanData = [
                'p_user_id' => $pUserId,
                'deposit_base' => $this->getDepositBase(),
                'aims' => $this->getAims(),
                'start_time' => $this->getStartTime(),
                'end_time' => $this->getEndTime(),
                'create_time' => $this->getCreateTime()
            ];
            $uid = $this->model->insertGetId($ultramanData);
            if (!$uid) {
                throw new \Exception('新增失败');
            }
            Db::commit();
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            Db::rollback();
        }
        return false;
    }
}