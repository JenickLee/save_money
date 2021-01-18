<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 13:51
 */
declare (strict_types = 1);
namespace app\api\middleware;

use Closure;
use think\Config;
use think\Request;
use think\Response;

class AllowCrossDomain
{
    public function handle($request, Closure $next)
    {
        $header = [
            'Content-type' => 'application/json;charset=utf-8',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers'     => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, user_id, x-forwarded-for, Origin',
        ];
        return $next($request)->header($header);
    }
}
