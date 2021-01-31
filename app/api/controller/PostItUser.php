<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/17
 * Time: 5:36 下午
 */

namespace app\api\controller;


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
     * Notes:获取用户贴吧ID信息
     * User: Jenick
     * Date: 2021/1/17
     * Time: 5:39 下午
     */
    public function getPostItUserInfo()
    {
        $this->obj->setUserId($this->userId);
        $res = $this->obj->getPostItUserInfoByUserId();
        return Response::success($res);
    }
}