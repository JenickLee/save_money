<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 9:19
 */

namespace app\api\middleware;

use app\common\lib\Response;
use app\common\service\User;
use \Closure;

class Check
{
    private $checkPathInfo = [
        'v1.1/getUltramanList',//获取奥特曼列表
        'userRegistered',//小程序授权登录
        'getUltramanDataAnalysis',//获取奥特曼数据统计
        'getParticipateDataAnalysis',//统计月份奥特曼参加人数
        'getUltramanBanner',//获取奥特曼Banner图
    ];

    public function handle($request, Closure $next)
    {
        if (!in_array($request->pathinfo(), $this->checkPathInfo)) {
            $header = $request->header();
            $userId = $header['user-id'] ?? null;
            if (empty($userId)) {
                return Response::error(config('code.api_check_error'));
            }
            $request->userId = $userId;
            $request->userInfo = $this->_getUserInfo($userId);
        }

        $response = $next($request);
        return $response;
    }

    public function _getUserInfo($userId)
    {
        if (empty($userId)) return [];
        $userService = new User();
        $userService->setId($userId);
        return $userService->getUserInfo();
    }
}