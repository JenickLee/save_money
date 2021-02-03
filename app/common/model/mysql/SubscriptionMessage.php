<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/8/13
 * Time: 1:49 下午
 */

namespace app\common\model\mysql;


class SubscriptionMessage extends Base
{
    public function __construct(array $data = [])
    {
        //设置当前模型对应的完整数据表名称
        $this->table = config('table.fnd_subscription_message');
        parent::__construct($data);
    }

    /**
     * Notes:根据条件获取数据
     * User: Jenick
     * Date: 2020/8/13
     * Time: 2:49 下午
     */
    public function findAllInfoJoinUserAndTemlate()
    {
        if (empty($this->getOrder())) {
            $this->setOrder('s.id asc');
        }
        try {
            $res = $this->alias('s')
                ->field($this->getField())
                ->where($this->getWhereArr())
                ->limit($this->getOffset(), $this->getLimit())
                ->join(config('table.fnd_user') . ' u', 's.user_id = u.id', 'INNER')
                ->join(config('table.fnd_template') . ' t', 't.code = s.code', 'INNER')
                ->order($this->getOrder())
                ->group($this->getGroup())
                ->select();
            if (is_object($res)) {
                $res = $res->toArray();
            }
            return $res;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Notes:根据条件获取数据
     * User: Jenick
     * Date: 2020/8/13
     * Time: 2:49 下午
     */
    public function findOneInfoJoinUserAndTemlate()
    {
        if (empty($this->getOrder())) {
            $this->setOrder('s.id asc');
        }

        try {
            $res = $this->alias('s')
                ->field($this->getField())
                ->where($this->getWhereArr())
                ->join(config('table.fnd_user') . ' u', 's.user_id = u.id', 'INNER')
                ->join(config('table.fnd_template') . ' t', 't.code = s.code', 'INNER')
                ->order($this->getOrder())
                ->group($this->getGroup())
                ->find();
            if (is_object($res)) {
                $res = $res->toArray();
            }
            return $res;
        } catch (\Exception $e) {
            return [];
        }
    }
}