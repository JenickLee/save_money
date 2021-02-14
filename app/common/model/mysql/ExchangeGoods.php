<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 6:59 下午
 */

namespace app\common\model\mysql;


class ExchangeGoods extends Base
{
    public function __construct(array $data = [])
    {
        $this->table = config('table.fnd_exchange_goods');
        parent::__construct($data);
    }
}