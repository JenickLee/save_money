<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 2:20 下午
 */

namespace app\common\model\mysql;


class User extends Base
{
    public function __construct(array $data = [])
    {
        //设置当前模型对应的完整数据表名称
        $this->table = config('table.fnd_user');
        parent::__construct($data);
    }
}