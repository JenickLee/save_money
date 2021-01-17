<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 4:30 下午
 */

namespace app\admin\controller;

use app\common\lib\Response;
use app\common\service\PostItUser as PostItUserService;
use think\App;
use think\Validate;

class PostItUser extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new PostItUserService();
    }

    /**
     * Notes:获取贴吧id用户列表
     * User: Jenick
     * Date: 2021/1/7
     * Time: 4:31 下午
     */
    public function getPostItUserList()
    {
        $res = $this->obj->getPostItUserList();
        return Response::success($res);
    }

    /**
     * Notes:新增贴吧id用户
     * User: Jenick
     * Date: 2021/1/7
     * Time: 4:31 下午
     */
    public function addPostItUser()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['username|贴吧ID'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }
        try {
            $this->obj->setUsername($param['username']);
            $res = $this->obj->addPostItUser();
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }


    public function editUsername()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['id|uid'] = 'require';
        $rule['username|贴吧id'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }

        try {
            $this->obj->setId($param['id']);
            $this->obj->setUsername($param['username']);
            $this->obj->editUsername();
            return Response::success();
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }

    /**
     * Notes:获取贴吧ID信息
     * User: Jenick
     * Date: 2021/1/17
     * Time: 3:34 下午
     */
    public function getPostItUserInfo()
    {
        $param = input('get.');
        $validate = new Validate();
        $rule['id|uid'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }

        try {
            $this->obj->setId($param['id']);
            $res = $this->obj->getPostItUserInfo();
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}