<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 9:19
 */

namespace app\api\middleware;
use \Closure;

class Check
{
    public function handle($request, Closure $next)
    {
        $header = $request->header();
        $userId =  $header['user-id'] ?? null;
        $request->userId =$userId;
        $response = $next($request);
        return $response;
    }
}