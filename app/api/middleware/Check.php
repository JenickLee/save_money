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
        'getPointsTaskList',//获取积分任务
    ];

    public function handle($request, Closure $next)
    {
        if (!in_array($request->pathinfo(), $this->checkPathInfo)) {
            $header = $request->header();
            $userId = $header['user-id'] ?? null;
            if (empty($userId)) {
                return Response::error(config('code.api_check_error'));
            }

            //API校验
            $res = $this->_checkApi($userId, $header['timestamp'] ?? null, $header['token'] ?? null);
            if (!$res) {
                return Response::error(config('code.api_check_error'));
            }
            $request->userId = $userId;
            $request->userInfo = $this->_getUserInfo($userId);
        }

        $response = $next($request);
        return $response;
    }

    /**
     * Notes:校验Api安全
     * User: Jenick
     * Date: 2021/1/31
     * Time: 6:50 下午
     * @param $userId
     * @param $timestamp
     * @param $token
     * @return bool
     */
    private function _checkApi($userId, $timestamp, $token)
    {
        if (empty($userId) || empty($timestamp) || empty($token)) return false;
        $apiKey = config('config.api_key');
        $str = "{$userId}&&{$timestamp}&&{$apiKey}";
        return $token == md5($str);
    }

    /**
     * Notes:获取用户信息
     * User: Jenick
     * Date: 2021/1/31
     * Time: 6:55 下午
     * @param $userId
     * @return array|\think\Model|null
     */
    private function _getUserInfo($userId)
    {
        if (empty($userId)) return [];
        $userService = new User();
        $userService->setId($userId);
        return $userService->getUserInfo();
    }
}