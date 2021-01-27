<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 17:32
 */

namespace app\common\model\mysql;


class SysLog extends Base
{
    public function __construct(array $data = [])
    {
        $this->table = config('table.fnd_sys_log');
        parent::__construct($data);
    }
}