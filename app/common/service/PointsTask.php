<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/8/13
 * Time: 2:41 下午
 */

namespace app\common\service;

use app\common\model\mysql\PointsTask as PointsTaskModel;
use app\common\bean\PointsTask as PointsTaskBean;


class PointsTask extends PointsTaskBean
{
    public function __construct($page = 0, $pageSize = null)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new PointsTaskModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:获取积分任务
     * User: Jenick
     * Date: 2021/2/7
     * Time: 12:25 上午
     */
    public function getPointsTaskList()
    {
        $where = [
            ['exp_time', '=', null],
            ['eff_time', '<', $this->getEffTime()]
        ];
        $this->model->setWhereArr($where);
        return $this->model->findAllInfo();
    }
}