<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/3
 * Time: 15:20
 */
return [
    //cos appid
    'cos_appid' => env('config.cos_appid', ''),
    //cos key
    'cos_key' => env('config.cos_key', ''),
    //cos 拼接符
    'cos_stitching_symbol' =>  env('config.cos_stitching_symbol', '-'),
    //产品名称
    'blog_app_name' => env('config.blog_app_name', ''),
    //sys_image 是否显示值
    'sys_image_show' => 1,
    //奥特曼Banner
    'ultraman_banner_type' => 1
];