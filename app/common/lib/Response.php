<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * DateTime: 2020/4/15 15:52
 */

namespace app\common\lib;


class Response
{
    /**
     * Notes:接口成功返回数据公共方法
     * User: Jenick
     * Version: 3.0
     * DateTime: 2020/4/15 15:54
     * @param array $data
     * @param String|null $msg
     * @param int|null $code
     * @param int $statusCode
     * @return \think\response\Json
     */
    public static function success($data = [], String $msg = null, int $statusCode = 200)
    {
        if(!isset($msg)) {
            $msg = "正常走完接口无特殊说明";
        }
        $result = [
            'code' => config('code.success'),
            'msg' => $msg,
            'data' => $data,
            'status' => true
        ];
        return json($result, $statusCode);
    }

    /**
     * Notes:接口错误返回数据公共方法
     * User: Jenick
     * Version: 3.0
     * DateTime: 2020/4/15 15:56
     * @param int|null $code
     * @param String|null $msg
     * @param null $data
     * @param int $statusCode
     * @return \think\response\Json
     */
    public static function error(int $code = null, String $msg = null, $data = null, int $statusCode = 200)
    {
        if (!isset($msg)) {
            switch ($code) {
                case config('code.params_invalid'):
                    $msg = "请求参数有误或接收出错";
                    break;
                case config('code.api_check_error'):
                    $msg = "接口验签不通过";
                    break;
                case config('code.not_found'):
                    $msg = "找不到相关数据";
                    break;
                case config('code.not_claim'):
                    $msg = "请求数据不匹配";
                    break;
                case config('code.server_error'):
                    $msg = "服务端错误!";
                    break;
                case config('code.file_upload_error'):
                    $msg = "文件上传相关错误!";
                    break;
                case config('code.not_login'):
                    $msg = "尚未登录或登录超时！";
                    break;
                case config('code.not_inoperable'):
                    $msg = "不可操作!";
                    break;
                default:
                    $msg = "请求失败";
                    break;
            }
        }
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'status' => false
        ];
        return json($result, $statusCode);
    }
}