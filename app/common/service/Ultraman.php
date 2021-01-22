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
    public function getList($orderBy = 1)
    {
        switch ($orderBy) {
            case 1://当前基数
                $order = 'u.deposit_base desc, u.aims desc, u.id desc';
                break;
            case 2://目标
                $order = 'u.aims desc, u.deposit_base desc,u.id desc';
                break;
            case 3://完成率
                $order = "schedule desc, u.deposit_base desc,u.id desc";
                break;
            default:
                $order = 'u.deposit_base desc, u.aims desc, u.id desc';
                break;
        }
        $field = "u.id uid, 
                   user.username, 
                   u.deposit_base, 
                   u.aims,
                   DATE_FORMAT(u.end_time, '%Y-%m-%d') as end_time, 
                   DATE_FORMAT(u.update_time, '%Y-%m-%d') as update_time, 
                   if( ((u.aims - u.deposit_base) < 0), 0.00, (u.aims - u.deposit_base))  as difference,
                   if( truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 0, if(truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 100, 100.00, truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2)), 0.00) as schedule";
        $startTime = date('Y-01-01 00:00:00');
        $endTime = date('Y-12-31 23:59:59');
        $where = [
            ['u.start_time', '<=', $startTime],
            ['u.end_time', '>=', $endTime]
        ];
        $this->model->setField($field);
        $this->model->setWhereArr($where);
        $this->model->setOrder($order);
        $res = $this->model->findAllInfoJoinUser();
        return $res;
    }

    /**
     * Notes:获取奥特曼列表
     * User: Jenick
     * Date: 2021/1/7
     * Time: 12:45 上午
     */
    public function getUltramanCount()
    {
        $startTime = date('Y-01-01 00:00:00');
        $endTime = date('Y-12-31 23:59:59');
        $where = [
            ['start_time', '<=', $startTime],
            ['end_time', '>=', $endTime]
        ];
        $this->model->setWhereArr($where);
        $res = $this->model->getCount();
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
                'cby' => $this->getCby(),
                'create_time' => $this->getCreateTime(),
                'uby' => $this->getUby(),
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
                'cby' => $this->getCby(),
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

    /**
     * Notes:更新数据
     * User: Jenick
     * Date: 2021/1/7
     * Time: 12:45 上午
     * @throws \Exception
     */
    public function editUltraman($type, $calculation)
    {
        $id = $this->getId();
        $this->model->setWhereArr(['id' => $id]);
        $info = $this->model->findOneInfo();
        if (!$info) {
            throw new \Exception('用户未参加奥特曼');
        }
        Db::startTrans();
        try {
            $logData = [
                'uid' => $id,
                'cby' => $this->getUby(),
                'create_time' => $this->getUpdateTime()
            ];
            $ultramanData['uby'] = $this->getUby();
            $ultramanData['update_time'] = $this->getUpdateTime();
            switch ($type) {
                case 1:
                    $logData['type'] = 2;
                    switch ($calculation) {
                        case 1://最终
                            $ultramanData['deposit_base'] = $this->getDepositBase();
                            $logData['deposit_base'] = $this->getDepositBase();
                            break;
                        case 2://增加
                            $ultramanData['deposit_base'] = $info['deposit_base'] + $this->getDepositBase();
                            $logData['deposit_base'] = $info['deposit_base'] + $this->getDepositBase();
                            break;
                        case 3://减少
                            $ultramanData['deposit_base'] = $info['deposit_base'] - $this->getDepositBase();
                            $logData['deposit_base'] = $info['deposit_base'] - $this->getDepositBase();
                            break;
                    }
                    break;
                case 2:
                    $logData['type'] = 3;
                    switch ($calculation) {
                        case 1://最终
                            $ultramanData['aims'] = $this->getAims();
                            $logData['aims'] = $this->getAims();
                            break;
                        case 2://增加
                            $ultramanData['aims'] = $info['aims'] + $this->getAims();
                            $logData['aims'] = $info['aims'] + $this->getAims();
                            break;
                        case 3://减少
                            $ultramanData['aims'] = $info['aims'] - $this->getAims();
                            $logData['aims'] = $info['aims'] - $this->getAims();
                            break;
                    }
                    break;
            }
            $this->model->setId($id);
            $this->model->setArr($ultramanData);
            $res = $this->model->useIdUpdateData();
            if (!$res) {
                throw new \Exception('修改失败');
            }
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
     * Notes:根据id获取奥特曼信息
     * User: Jenick
     * Date: 2021/1/7
     * Time: 6:15 下午
     */
    public function getPostItUserUltramanInfoById()
    {
        $field = "u.id uid, 
                   user.username, 
                   u.deposit_base, 
                   u.aims,
                   DATE_FORMAT(u.end_time, '%Y-%m-%d') as end_time, 
                   (u.aims - u.deposit_base) as difference, 
                   if((truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 0),truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2),0.00) as schedule";
        $where['u.id'] = $this->getId();
        $this->model->setField($field);
        $this->model->setWhereArr($where);
        $res = $this->model->findOneInfoJoinUser();
        return $res;
    }

    /**
     * Notes:根据当前基数分析数据
     * User: Jenick
     * Date: 2021/1/23
     * Time: 1:00 上午
     */
    public function getDataAnalysisByDepositBase()
    {
        $response['data'] = [];
        $response['color'] = [];
        $startTime = date('Y-01-01 00:00:00');
        $endTime = date('Y-12-31 23:59:59');

        //0及0以下
        $where = [
            ['start_time', '<=', $startTime],
            ['end_time', '>=', $endTime],
            ['deposit_base', '<=', 0]
        ];
        $this->model->setWhereArr($where);
        $res = $this->model->getCount();
        if ($res) {
            $response['data'][] = [
                'const' => 'const',
                'type' => '0及0以下',
                'num' => $res
            ];
            $response['color'][] = '#223273';
        }
        //0-200k
        $where = [
            ['start_time', '<=', $startTime],
            ['end_time', '>=', $endTime],
            ['deposit_base', '>', 0],
            ['deposit_base', '<=', 200000]
        ];
        $this->model->setWhereArr($where);
        $res = $this->model->getCount();
        if ($res) {
            $response['data'][] = [
                'const' => 'const',
                'type' => '0-200k',
                'num' => $res
            ];
            $response['color'][] = '#13C2C2';
        }

        //200k-400k
        $where = [
            ['start_time', '<=', $startTime],
            ['end_time', '>=', $endTime],
            ['deposit_base', '>', 200000],
            ['deposit_base', '<=', 400000]
        ];
        $this->model->setWhereArr($where);
        $res = $this->model->getCount();
        if ($res) {
            $response['data'][] = [
                'const' => 'const',
                'type' => '200k-400k',
                'num' => $res
            ];
            $response['color'][] = '#FACC14';
        }

        //400k-600k
        $where = [
            ['start_time', '<=', $startTime],
            ['end_time', '>=', $endTime],
            ['deposit_base', '>', 400000],
            ['deposit_base', '<=', 600000]
        ];
        $this->model->setWhereArr($where);
        $res = $this->model->getCount();
        if ($res) {
            $response['data'][] = [
                'const' => 'const',
                'type' => '400k-600k',
                'num' => $res
            ];
            $response['color'][] = '#1890FF';
        }

        //600k以上
        $where = [
            ['start_time', '<=', $startTime],
            ['end_time', '>=', $endTime],
            ['deposit_base', '>', 400000],
            ['deposit_base', '<=', 600000]
        ];
        $this->model->setWhereArr($where);
        $res = $this->model->getCount();
        if ($res) {
            $response['data'][] = [
                'const' => 'const',
                'type' => '600k以上',
                'num' => $res
            ];
            $response['color'][] = '#2FC25B';
        }
        return $response;
    }

    /**
     * Notes:根据目标分析数据
     * User: Jenick
     * Date: 2021/1/23
     * Time: 1:02 上午
     */
    public function getDataAnalysisByAims()
    {

    }

    /**
     * Notes:根据完成率分析数据
     * User: Jenick
     * Date: 2021/1/23
     * Time: 1:03 上午
     */
    public function getDataAnalysisBySchedule()
    {

    }
}