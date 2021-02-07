<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 3:08 下午
 */

namespace app\common\service;

use app\common\bean\PointsList as PointsListBean;
use app\common\model\mysql\PointsList as PointsListModel;

class PointsList extends PointsListBean
{
    public function __construct($page = 0, $pageSize = null)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new PointsListModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:添加积分
     * User: Jenick
     * Date: 2021/2/7
     * Time: 3:20 下午
     * @return int|string
     * @throws \Exception
     */
    public function addPoints()
    {
        $pointsTaskService = new PointsTask();
        $pointsTaskService->setId($this->getPid());
        $pointsTaskInfo = $pointsTaskService->getPointsTaskInfoById();
        if (!$pointsTaskInfo || !empty($pointsTaskInfo['exp_time'])) {
            throw new \Exception('积分任务不存在或者已结束！');
        }

        if ($pointsTaskInfo['eff_time'] > date('Y-m-d H:i:s')) {
            throw new \Exception('积分任务暂未开始！');
        }

        $data = [
            'user_id' => $this->getUserId(),
            'type' => 1,
            'pid' => $pointsTaskInfo['id'],
            'integral' => $pointsTaskInfo['integral'],
            'create_time' => $this->getCreateTime()
        ];
        return $this->model->insertGetId($data);
    }
}