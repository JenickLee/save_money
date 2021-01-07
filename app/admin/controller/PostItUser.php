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
}