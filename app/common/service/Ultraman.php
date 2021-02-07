<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/6
 * Time: 5:05 下午
 */

namespace app\common\service;

use app\common\bean\Ultraman as UltramanBean;
use app\common\lib\Date;
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
        switch (intval($orderBy)) {
            case 1://当前存款
                $order = 'u.deposit_base desc';
                break;
            case 2://目标
                $order = 'u.aims desc';
                break;
            case 3://完成率
                $order = "schedule desc";
                break;
            default:
                $order = 'u.deposit_base desc, u.aims desc, u.id desc';
                break;
        }
        $field = "u.id uid, 
                   u.p_user_id,
                   user.username, 
                   u.deposit_base, 
                   u.aims,
                   DATE_FORMAT(u.end_time, '%Y-%m-%d') as end_time, 
                   DATE_FORMAT(u.update_time, '%Y-%m-%d') as update_time, 
                   if( ((u.aims - u.deposit_base) < 0), 0.00, (u.aims - u.deposit_base))  as difference,
                   if( truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 0, if(truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 100, 100.00, truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2)), 0.00) as schedule";

        $where = [
            ['u.end_time', '>=', date('Y-m-d H:i:s')]
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
        $where = [
            ['end_time', '>=', date('Y-m-d H:i:s')]
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
                ['u.end_time', '>=', date('Y-m-d H:i:s')],
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
        return $uid;
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
                   if( ((u.aims - u.deposit_base) < 0), 0.00, (u.aims - u.deposit_base))  as difference,
                   if( truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 0, if(truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 100, 100.00, truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2)), 0.00) as schedule,
                   u.update_time";

        $where = [
            ['u.end_time', '>=', date('Y-m-d H:i:s')],
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
        $this->model->setField('u.*, user.username');
        $this->model->setWhereArr(['u.id' => $id]);
        $info = $this->model->findOneInfoJoinUser();
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

            //更新奥特曼
            $this->model->setId($id);
            $this->model->setArr($ultramanData);
            $res = $this->model->useIdUpdateData();
            if (!$res) {
                throw new \Exception('修改失败');
            }
            //记录日志
            $logModel = new UltramanLogModel();
            $lid = $logModel->insertGetId($logData);
            if (!$lid) {
                throw new \Exception('日志记录失败');
            }

            //获得积分
            $pointsTaskService = new PointsTask();
            $pointsTaskService->setTaskType(3);
            $pointsTaskInfo = $pointsTaskService->getPointsTaskInfoByTaskType();
            if ($pointsTaskInfo) {
                $pointsListService = new PointsList();
                $pointsListService->setPid($pointsTaskInfo['id']);
                $pointsListId = $pointsListService->addPoints();
                if(!$pointsListId){
                    throw new \Exception('新增积分失败');
                }
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            throw new \Exception($e->getMessage());
        }
        return [
            'username' => $info['username'],
            'aims' => $ultramanData['aims'] ?? null,
            'deposit_base' => $ultramanData['deposit_base'] ?? null
        ];
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
                   if( ((u.aims - u.deposit_base) < 0), 0.00, (u.aims - u.deposit_base))  as difference,
                   if( truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 0, if(truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 100, 100.00, truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2)), 0.00) as schedule";
        $where['u.id'] = $this->getId();
        $this->model->setField($field);
        $this->model->setWhereArr($where);
        $res = $this->model->findOneInfoJoinUser();
        return $res;
    }

    /**
     * Notes:根据当前存款分析数据
     * User: Jenick
     * Date: 2021/1/23
     * Time: 1:00 上午
     */
    public function getDataAnalysisByDepositBase()
    {
        $response['data'] = $response['color'] = [];
        $endTime = date('Y-m-d H:i:s');

        $condition = [
            ['where' => ['<' => 0], 'color' => '#223273', 'type' => '0以下'],
            ['where' => ['>=' => 0, '<' => 5000], 'color' => '#2FC25B', 'type' => '0-5k'],
            ['where' => ['>=' => 5000, '<' => 10000], 'color' => '#13C2C2', 'type' => '5k-10k'],
            ['where' => ['>=' => 10000, '<' => 50000], 'color' => '#FACC14', 'type' => '10k-50k'],
            ['where' => ['>=' => 50000, '<' => 100000], 'color' => '#1890FF', 'type' => '50k-100k'],
            ['where' => ['>=' => 100000, '<' => 150000], 'color' => '#2FC25B', 'type' => '100k-150k'],
            ['where' => ['>=' => 150000, '<' => 200000], 'color' => '#F04864', 'type' => '150k-200k'],
            ['where' => ['>=' => 200000, '<' => 250000], 'color' => '#8543E0', 'type' => '200k-250k'],
            ['where' => ['>=' => 250000, '<' => 300000], 'color' => '#3436C7', 'type' => '250k-300k'],
            ['where' => ['>=' => 300000], 'color' => '#F47983', 'type' => '300k及以上'],
        ];

        for ($i = 0; $i < count($condition); $i++) {
            $where = [
                ['end_time', '>=', $endTime]
            ];
            foreach ($condition[$i]['where'] as $key => $value) {
                array_push($where, ['deposit_base', $key, $value]);
            }
            $this->model->setWhereArr($where);
            $res = $this->model->getCount();
            if ($res) {
                array_push($response['data'], [
                    'const' => 'const',
                    'type' => $condition[$i]['type'],
                    'num' => $res
                ]);
                array_push($response['color'], $condition[$i]['color']);
            }
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
        $response['data'] = $response['color'] = [];
        $endTime = date('Y-m-d H:i:s');
        $condition = [
            ['where' => ['>=' => 0, '<' => 50000], 'color' => '#223273', 'type' => '0-50k'],
            ['where' => ['>=' => 50000, '<' => 100000], 'color' => '#2FC25B', 'type' => '50-100k'],
            ['where' => ['>=' => 100000, '<' => 150000], 'color' => '#13C2C2', 'type' => '100k-150k'],
            ['where' => ['>=' => 150000, '<' => 200000], 'color' => '#FACC14', 'type' => '150k-200k'],
            ['where' => ['>=' => 200000, '<' => 250000], 'color' => '#1890FF', 'type' => '200k-250k'],
            ['where' => ['>=' => 250000, '<' => 300000], 'color' => '#2FC25B', 'type' => '250k-300k'],
            ['where' => ['>=' => 300000, '<' => 350000], 'color' => '#F04864', 'type' => '300k-350k'],
            ['where' => ['>=' => 350000, '<' => 400000], 'color' => '#8543E0', 'type' => '350k-400k'],
            ['where' => ['>=' => 400000, '<' => 450000], 'color' => '#3436C7', 'type' => '400k-450k'],
            ['where' => ['>=' => 450000], 'color' => '#F47983', 'type' => '450k及以上'],
        ];
        for ($i = 0; $i < count($condition); $i++) {
            $where = [
                ['end_time', '>=', $endTime]
            ];
            foreach ($condition[$i]['where'] as $key => $value) {
                array_push($where, ['aims', $key, $value]);
            }
            $this->model->setWhereArr($where);
            $res = $this->model->getCount();
            if ($res) {
                array_push($response['data'], [
                    'const' => 'const',
                    'type' => $condition[$i]['type'],
                    'num' => $res
                ]);
                array_push($response['color'], $condition[$i]['color']);
            }
        }
        return $response;
    }

    /**
     * Notes:根据完成率分析数据
     * User: Jenick
     * Date: 2021/1/23
     * Time: 1:03 上午
     */
    public function getDataAnalysisBySchedule()
    {
        $response['data'] = $response['color'] = [];
        $formula = "( (deposit_base / aims) * 100)";
        $endTime = date('Y-m-d H:i:s');
        $condition = [
            ['where' => ['>=' => 0, '<' => 10], 'color' => '#223273', 'type' => '0-10%'],
            ['where' => ['>=' => 10, '<' => 20], 'color' => '#2FC25B', 'type' => '10-20%'],
            ['where' => ['>=' => 20, '<' => 30], 'color' => '#13C2C2', 'type' => '20-30%'],
            ['where' => ['>=' => 30, '<' => 40], 'color' => '#FACC14', 'type' => '30-40%'],
            ['where' => ['>=' => 40, '<' => 50], 'color' => '#1890FF', 'type' => '40-50%'],
            ['where' => ['>=' => 50, '<' => 60], 'color' => '#2FC25B', 'type' => '50-60%'],
            ['where' => ['>=' => 60, '<' => 70], 'color' => '#F04864', 'type' => '60-70%'],
            ['where' => ['>=' => 70, '<' => 80], 'color' => '#8543E0', 'type' => '70-80%'],
            ['where' => ['>=' => 80, '<' => 90], 'color' => '#3436C7', 'type' => '80-90%'],
            ['where' => ['>=' => 90, '<' => 100], 'color' => '#223273', 'type' => '90-100%'],
            ['where' => ['=' => 100], 'color' => '#F47983', 'type' => '100%'],
        ];

        for ($i = 0; $i < count($condition); $i++) {
            $schedule = "";
            foreach ($condition[$i]['where'] as $key => $value) {
                if (!empty($schedule)) $schedule .= " and ";
                $schedule .= "IF(TRUNCATE ( {$formula}, 2 ) > 0, if(TRUNCATE ({$formula}, 2 ) > 100.00, 100.00, TRUNCATE ({$formula}, 2 )), 0.00 ) {$key} {$value}";
            }

            $this->model->setWhereArr("end_time >= '{$endTime}' and {$schedule}");
            $res = $this->model->getCount();
            if ($res) {
                array_push($response['data'], [
                    'const' => 'const',
                    'type' => $condition[$i]['type'],
                    'num' => $res
                ]);
                array_push($response['color'], $condition[$i]['color']);
            }
        }
        return $response;
    }

    /**
     * Notes:统计月份奥特曼参加人数
     * User: Jenick
     * Date: 2021/1/23
     * Time: 2:09 下午
     */
    public function getParticipateDataAnalysis()
    {
        $startDate = date("Y-m-d", mktime(0, 0, 0, date("m") - 11, 1, date("Y")));
        $endDate = date("Y-m-d");
        $date = Date::getDateByInterval($startDate, $endDate, 'month');
        $response = [];
        foreach ($date as $value) {
            $where = [
                ['create_time', '>=', "{$value['startDate']} 00:00:00"],
                ['create_time', '<=', "{$value['endDate']} 23:59:59"]
            ];
            $this->model->setWhereArr($where);
            $response[] = [
                'year' => date('M', strtotime($value['startDate'])),
                'sales' => $this->model->getCount()
            ];
        }
        return $response;
    }
}