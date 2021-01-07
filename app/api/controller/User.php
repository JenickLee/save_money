<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 2:29 下午
 */
namespace app\api\controller;

use think\App;
use think\Validate;
use app\common\lib\Response;
use app\common\service\{User as UserService};
class User extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new UserService();
    }

    /**
     * Notes:小程序授权登录
     * User: Jenick
     * Date: 2020/01/05
     * Time: 09:36
     */
    public function registered()
    {
        $params = input('get.');
        $validate = new Validate();
        $rule['code|code'] = 'require';
        if (!$validate->check($params, $rule)) {
            return Response::error(config('code.error'), $validate->getError());
        }
        $code = $params['code'];
        try {
            $this->obj->setNickname($params['nickName'] ?? '');
            $this->obj->setAvatar($params['avatarUrl'] ?? '');
            $res = $this->obj->userRegistered((String)$code);
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}