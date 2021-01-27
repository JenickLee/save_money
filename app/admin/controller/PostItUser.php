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
        $this->obj = new PostItUserService($this->page, $this->pageSize);
    }

    /**
     * Notes:获取贴吧id用户列表
     * User: Jenick
     * Date: 2021/1/7
     * Time: 4:31 下午
     */
    public function getPostItUserList()
    {
        $this->obj = new PostItUserService(0, null);
        $response = $this->obj->getListAndGetFirstCharters();
        return Response::success($response);
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
            $this->obj->setCby($this->adminUserId);
            $this->obj->setUby($this->adminUserId);
            $this->obj->setUsername($param['username']);
            $res = $this->obj->addPostItUser();
            $this->saveSysLog("管理员[{$this->adminUserInfo['nickname']}]，新增了贴吧ID[{$param['username']}]");
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
            $this->obj->setUby($this->adminUserId);
            $this->obj->setId($param['id']);
            $this->obj->setUsername($param['username']);
            $res = $this->obj->editUsername();
            $this->saveSysLog("管理员[{$this->adminUserInfo['nickname']}]，将贴吧ID[{$res['old_username']}]，修改为[{$res['new_username']}]");
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
            $res = $this->obj->getPostItUserInfoById();
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }

    /**
     * Notes:生成绑定码
     * User: Jenick
     * Date: 2021/1/18
     * Time: 3:00 下午
     */
    public function generateBindingCode()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['id|uid'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }
        try {
            $this->obj->setId($param['id']);
            $res = $this->obj->generateBindingCode();
            $this->saveSysLog("管理员[{$this->adminUserInfo['nickname']}]，生成贴吧ID[{$res['username']}][绑定码：{$res['binding_info']['binding_code']}，失效日期：{$res['binding_info']['exp_time']}]");
            return Response::success($res['binding_info']);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }

}