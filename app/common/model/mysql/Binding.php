<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/29
 * Time: 10:22 下午
 */

namespace app\common\model\mysql;


class Binding extends Base
{
    public function __construct(array $data = [])
    {
        //设置当前模型对应的完整数据表名称
        $this->table = config('table.biz_binding');
        parent::__construct($data);
    }
}