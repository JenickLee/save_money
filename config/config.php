<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/3
 * Time: 15:20
 */
return [
    //api key
    'api_key' => env('config.api_key', ''),
    //cos appid
    'cos_appid' => env('config.cos_appid', ''),
    //cos key
    'cos_key' => env('config.cos_key', ''),
    //cos 拼接符
    'cos_stitching_symbol' => env('config.cos_stitching_symbol', '-'),
    //产品名称
    'blog_app_name' => env('config.blog_app_name', ''),
    //sys_image 是否显示值
    'sys_image_show' => 1,
    //奥特曼Banner
    'ultraman_banner_type' => 1,
    //订阅消息
    'template' => [
        'baidu_id_review_reminder' => '9JnM4q68DCY8d_CHEIrPqWx2cQw_XU5bQoi-eHNCVGM'
    ]
];