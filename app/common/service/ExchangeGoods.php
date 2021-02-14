<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 7:04 下午
 */

namespace app\common\service;


use app\common\bean\ExchangeGoods as ExchangeGoodsBean;
use app\common\model\mysql\ExchangeGoods as ExchangeGoodsModel;
use think\facade\Db;

class ExchangeGoods extends ExchangeGoodsBean
{
    public function __construct($page = 0, $pageSize = null)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new ExchangeGoodsModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:获取积分兑换列表
     * User: Jenick
     * Date: 2021/2/7
     * Time: 7:07 下午
     */
    public function getExchangeGoodsList()
    {
        $currentTime = date("Y-m-d H:i:s");
        $where = Db::raw("end_time IS NULL OR end_time > '{$currentTime}' ");
        $this->model->setWhereRaw($where);
        return $this->model->findAllInfo();
    }
}