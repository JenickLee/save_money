<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 9:19
 */

namespace app\api\middleware;

use app\common\service\User;
use \Closure;

class Check
{
    public function handle($request, Closure $next)
    {
        $header = $request->header();
        $userId = $header['user-id'] ?? null;
        $request->userId = $userId;
        $request->userInfo = $this->_getUserInfo($userId);
        $response = $next($request);
        return $response;
    }

    public function _getUserInfo($userId)
    {
        if (empty($userId)) return [];
        $userService = new User();
        $userService->setId($userId);
        return $userService->getUserInfo() ;
    }
}