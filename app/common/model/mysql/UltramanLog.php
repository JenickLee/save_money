<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/15
 * Time: 7:20 下午
 */

namespace app\common\model\mysql;


class UltramanLog extends Base
{
    public function __construct(array $data = [])
    {
        //设置当前模型对应的完整数据表名称
        $this->table = config('table.biz_ultraman_log');
        parent::__construct($data);
    }
}