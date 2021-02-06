<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 9:19
 */

namespace app\admin\middleware;

use app\common\lib\Response;
use app\common\service\User;
use \Closure;

class Check
{
    public function handle($request, Closure $next)
    {
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
        $request->adminUserInfo = $this->_getUserInfo($userId);
        $request->adminUserId = $userId;
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
     * Notes:获取管理员信息
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