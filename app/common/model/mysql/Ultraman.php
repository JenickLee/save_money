<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/6
 * Time: 5:03 下午
 */

namespace app\common\model\mysql;


class Ultraman extends Base
{
    public function __construct(array $data = [])
    {
        //设置当前模型对应的完整数据表名称
        $this->table = config('table.biz_ultraman');
        parent::__construct($data);
    }

    public function findAllInfoJoinUser()
    {
        if (empty($this->getOrder())) {
            $this->setOrder('u.deposit_base desc, u.create_time desc, u.id desc');
        }

        try {
            $res = $this->alias('u')
                ->join(config('table.biz_user') . ' user', 'user.id = u.user_id', 'INNER')
                ->join(config('table.biz_year_ultraman') . ' y', 'y.id = u.y_id', 'INNER')
                ->field($this->getField())
                ->where($this->getWhereArr())
                ->limit($this->getOffset(), $this->getLimit())
                ->order($this->getOrder())
                ->group($this->getGroup())
                ->select();
            if (is_object($res)) $res = $res->toArray();
            return $res;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
}