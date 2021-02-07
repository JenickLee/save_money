<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 17:32
 */

namespace app\common\model\mysql;


class PointsList extends Base
{
    public function __construct(array $data = [])
    {
        $this->table = config('table.biz_points_list');
        parent::__construct($data);
    }
}