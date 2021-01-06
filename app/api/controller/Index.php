<?php
/**
 * 首页
 * User: Jenick
 * Date: 2020/01/04
 * Time: 12:53
 */
namespace app\api\controller;

use app\common\lib\Response;

class Index extends Base
{
    public function index()
    {
        return Response::error(config('code.error'), '请不要访问API接口！');
    }
}