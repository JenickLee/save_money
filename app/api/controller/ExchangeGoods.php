<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 7:05 下午
 */

namespace app\api\controller;


use app\common\lib\Response;
use app\common\service\ExchangeGoods as ExchangeGoodsService;
use think\App;

class ExchangeGoods extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new ExchangeGoodsService($this->page, $this->pageSize);
    }

    /**
     * Notes:获取积分兑换列表
     * User: Jenick
     * Date: 2021/2/7
     * Time: 12:21 上午
     */
    public function getExchangeGoodsList()
    {
        return Response::success($this->obj->getExchangeGoodsList());
    }
}