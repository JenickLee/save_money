<?php
/**
 * 数据库表名
 * User: Jenick
 * Date: 2020/01/04
 * Time: 13:20
 */
return [
    //奥特曼表
    'biz_ultraman' => env('table.biz_ultraman', 'biz_ultraman'),
    //奥特曼日志表
    'biz_ultraman_log' => env('table.biz_ultraman_log', 'biz_ultraman_log'),
    //贴吧用户表
    'biz_post_it_user' => env('table.biz_post_it_user', 'biz_post_it_user'),
    //绑定百度ID表
    'biz_binding' => env('table.biz_binding', 'biz_binding'),
    //用户表
    'fnd_user' => env('table.fnd_user', 'fnd_user'),
    //系统图片设置
    'fnd_sys_image' => env('table.fnd_sys_image', 'fnd_sys_image'),
    //系统操作日志表
    'fnd_sys_log' => env('table.fnd_sys_log', 'fnd_sys_log'),
    //订阅消息
    'fnd_subscription_message' => env('table.fnd_subscription_message', 'fnd_subscription_message'),
    //订阅消息模板
    'fnd_template' => env('table.fnd_template', 'fnd_template'),
    //积分任务表
    'fnd_points_task' => env('table.fnd_points_task', 'fnd_points_task'),
];