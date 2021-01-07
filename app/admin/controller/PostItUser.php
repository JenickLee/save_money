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
}