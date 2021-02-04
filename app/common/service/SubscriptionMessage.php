<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/8/13
 * Time: 1:50 下午
 */

namespace app\common\service;

use app\common\model\mysql\SubscriptionMessage as SubscriptionMessageModel;
use app\common\bean\SubscriptionMessage as SubscriptionMessageBean;

class SubscriptionMessage extends SubscriptionMessageBean
{
    public function __construct($page = 0, $pageSize = 10)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new SubscriptionMessageModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:新增订阅消息
     * User: Jenick
     * Date: 2020/8/13
     * Time: 1:56 下午
     * @return int
     * @throws \Exception
     */
    public function addSubscribeMessage()
    {
        $i = 0;
        foreach ($this->getCode() as $vo) {
            $data[$i]['user_id'] = $this->getUserId();
            $data[$i]['code'] = $vo;
            $data[$i]['create_time'] = date('Y-m-d H:i:s');
            $i++;
        }
        $res = $this->model->insertAll($data);
        if(!$res) {
            throw new \Exception('新增失败');
        }
        return $res;
    }

    /**
     * Notes:获取有效订阅消息数
     * User: Jenick
     * Date: 2020/8/13
     * Time: 4:46 下午
     * @return int
     */
    public function getSubscribeMessageCountByCode()
    {
        $where['sent_content'] = null;
        $where['code'] = $this->getCode();
        $where['user_id'] = $this->getUserId();
        $this->model->setWhereArr($where);
        return $this->model->getCount();
    }
}