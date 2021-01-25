<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/25
 * Time: 8:00 下午
 */

namespace app\common\model\mysql;


class SysImage extends Base
{
    public function __construct(array $data = [])
    {
        //设置当前模型对应的完整数据表名称
        $this->table = config('table.fnd_sys_image');
        parent::__construct($data);
    }
}