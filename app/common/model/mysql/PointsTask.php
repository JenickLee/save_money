<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 17:32
 */

namespace app\common\model\mysql;


class PointsTask extends Base
{
    public function __construct(array $data = [])
    {
        $this->table = config('table.fnd_points_task');
        parent::__construct($data);
    }
}