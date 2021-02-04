<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/8/13
 * Time: 1:51 下午
 */

namespace app\admin\controller;


use app\common\lib\Response;
use app\common\service\SubscriptionMessage as SubscriptionMessageService;
use think\App;
use think\Validate;

class SubscriptionMessage extends Base
{

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new SubscriptionMessageService();
    }

    /**
     * Notes:新增订阅消息
     * User: Jenick
     * Date: 2020/8/13
     * Time: 1:52 下午
     */
    public function addSubscribeMessage()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['code'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.error'), $validate->getError());
        }

        try {
            $this->obj->setUserId($this->adminUserId);
            $this->obj->setCode(explode(',', $param['code']));
            $this->obj->addSubscribeMessage();
            return Response::success();
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }

    /**
     * Notes:获取有效订阅消息数
     * User: Jenick
     * Date: 2021/2/4
     * Time: 11:26 下午
     */
    public function getSubscribeMessageCount()
    {
        $param = input('get.');
        $validate = new Validate();
        $rule['code'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.error'), $validate->getError());
        }

        try {
            $this->obj->setUserId($this->adminUserId);
            $this->obj->setCode(explode(',', $param['code']));
            $res = $this->obj->getSubscribeMessageCountByCode();
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }

    }
}