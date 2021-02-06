<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 12:17 上午
 */

namespace app\api\controller;


use app\common\lib\Response;
use app\common\service\PointsTask as PointsTaskService;
use think\App;

class PointsTask extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new PointsTaskService($this->page, $this->pageSize);
    }

    /**
     * Notes:获取积分任务
     * User: Jenick
     * Date: 2021/2/7
     * Time: 12:21 上午
     */
    public function getPointsTaskList()
    {
        return Response::success($this->obj->getPointsTaskList());
    }
}