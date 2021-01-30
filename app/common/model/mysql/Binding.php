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

    public function findAllInfoAndUser()
    {
        try {
            $res = $this->alias('b')
                ->join(config('table.fnd_user') . ' user', 'user.id = b.cby', 'INNER')
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

    public function findOneInfoAndUser()
    {
        try {
            $res = $this->alias('b')
                ->join(config('table.fnd_user') . ' user', 'user.id = b.cby', 'INNER')
                ->field($this->getField())
                ->where($this->getWhereArr())
                ->order($this->getOrder())
                ->find();
            if (is_object($res)) $res = $res->toArray();
            return $res;
        } catch (\Exception $e) {
            return [];
        }
    }
}