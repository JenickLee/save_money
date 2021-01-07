<?php
/**
 * 异常处理
 * User: Jenick
 * Date: 2020/01/05
 * Time: 13:34
 */
namespace app\api\exception;

use think\exception\Handle;
use think\Response;
use Throwable;

class Http extends Handle
{
    private $statusCode = 500;
    public function render($request, Throwable $e): Response
    {
        if(method_exists($e, 'getStatusCode')) {
            $statusCode = $e->getStatusCode();
        } else {
            $statusCode = $this->statusCode;
        }
        return \app\common\lib\Response::error(config('code.server_error'), $e->getMessage(), null,$statusCode);
    }
}