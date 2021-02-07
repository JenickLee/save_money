<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 17:32
 */

namespace app\common\model\mysql;


use think\facade\Db;

class PointsList extends Base
{
    public function __construct(array $data = [])
    {
        $this->table = config('table.biz_points_list');
        parent::__construct($data);
    }

    public function getMyTotalPoints($userId)
    {
        try {
            $currentTime = date('Y-m-d H:i:s');
            $where = [
                ['p.user_id', '=', $userId],
                ['p.type', '=', 1],
                Db::raw("p.exp_time is NULL OR p.exp_time > '{$currentTime}'")
            ];
            $subQuery = $this->alias('pl')
                ->join(config('table.biz_points_deduction_details') . ' pdd', 'pdd.cid = pl.id', 'INNER')
                ->field("pdd.integral")
                ->where("pdd.uid = p.id")
                ->buildSql();

            $field = "SUM(p.integral - IFNULL({$subQuery}, 0)) as num";
            $res = $this->alias('p')
                ->field($field)
                ->where($where)
                ->find();
            return $res['num'] ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}