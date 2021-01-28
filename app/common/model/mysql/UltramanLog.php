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

    public function findAllInfoJoinUltraman()
    {
        if (empty($this->getOrder())) {
            $this->setOrder('log.create_time asc, log.id asc');
        }

        try {
            $res = $this->alias('log')
                ->join(config('table.biz_ultraman') . ' u', 'u.id = log.uid', 'INNER')
                ->field($this->getField())
                ->where($this->getWhereArr())
                ->limit($this->getOffset(), $this->getLimit())
                ->order($this->getOrder())
                ->group($this->getGroup())
                ->select();
            if (is_object($res)) $res = $res->toArray();
            return $res;
        } catch (\Exception $e) {
            return [];
        }
    }
}