<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/04/12
 * Time: 17:34
 */

namespace app\common\lib;


class Curl
{
    /**
     * Notes:CURL Get请求
     * User: Jenick
     * Date: 2020/01/04
     * Time: 23:07
     * @param $url
     * @return bool|string
     */
    public static function curlGetContents($url){
        // 初始化
        $curl = curl_init();
        // 设置url路径
        curl_setopt($curl, CURLOPT_URL, $url);
        // 将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
        // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
        // CURLINFO_HEADER_OUT选项可以拿到请求头信息
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        // 不验证SSL
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 执行
        $data = curl_exec($curl);
        // 关闭连接
        curl_close($curl);
        // 返回数据
        return $data;
    }

    /**
     * Notes:CURL POSTS请求
     * User: Jenick
     * Date: 2020/04/12
     * Time: 17:36
     * @param $url
     * @param array $data
     * @return bool|string
     */
    public static function curlPostContents($url , $data = []){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        // POST数据
        curl_setopt($curl, CURLOPT_POST, TRUE);
        // 把post的变量加上
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}