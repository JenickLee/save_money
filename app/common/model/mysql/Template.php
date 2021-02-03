<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/8/13
 * Time: 2:40 下午
 */

namespace app\common\model\mysql;


class Template extends Base
{
    public function __construct(array $data = [])
    {
        //设置当前模型对应的完整数据表名称
        $this->table = config('table.fnd_template');
        parent::__construct($data);
    }
}