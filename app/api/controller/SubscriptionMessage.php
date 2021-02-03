<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/8/13
 * Time: 1:51 下午
 */

namespace app\api\controller;


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
        $params = input('post.');
        $validate = new Validate();
        $rule['userId'] = 'require';
        $rule['codes'] = 'require';
        if (!$validate->check($params, $rule)) {
            return Response::error(config('code.error'), $validate->getError());
        }

        try {
            $this->obj->setUserId($params['userId']);
            $this->obj->setCode(explode(',', $params['codes']));
            $res = $this->obj->addSubscribeMessage();
            if ($res) {
                return Response::success();
            }
            return Response::error(config('code.error'), '新增失败');
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}