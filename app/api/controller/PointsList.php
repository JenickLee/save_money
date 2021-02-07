<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 12:17 上午
 */

namespace app\api\controller;


use app\common\lib\Response;
use app\common\service\PointsList as PointsListService;
use think\App;

class PointsList extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new PointsListService($this->page, $this->pageSize);
    }

    /**
     * Notes:获取我的积分总数
     * User: Jenick
     * Date: 2021/2/7
     * Time: 12:21 上午
     */
    public function getMyTotalPoints()
    {
        $this->obj->setUserId($this->userId);
        return Response::success($this->obj->getMyTotalPoints());
    }
}