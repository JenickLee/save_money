<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 12:49 上午
 */

namespace app\common\model\mysql;


use think\facade\Db;

class PostItUser extends Base
{
    public function __construct(array $data = [])
    {
        //设置当前模型对应的完整数据表名称
        $this->table = config('table.biz_post_it_user');
        parent::__construct($data);
    }

    public function findAllInfoAndUser()
    {
        if (empty($this->getOrder())) {
            $this->setOrder('p.username asc, p.id asc');
        }

        try {
            $res = $this->alias('p')
                ->join(config('table.fnd_user') . ' user', 'user.id = p.user_id', 'LEFT')
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

    public function findOneInfoAndUser()
    {
        try {
            $res = $this->alias('p')
                ->join(config('table.fnd_user') . ' user', 'user.id = p.user_id', 'LEFT')
                ->field($this->getField())
                ->where($this->getWhereArr())
                ->find();
            if (is_object($res)) $res = $res->toArray();
            return $res;
        } catch (\Exception $e) {
            return [];
        }
    }
}