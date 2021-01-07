<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;
Route::get("/", 'Index/index');//首页
//---------------------------------------奥特曼-----------------------------------------------
Route::get("/getUltramanList", 'Ultraman/getList');//获取奥特曼列表
Route::post("/addUltraman", 'Ultraman/add');//新增贴吧ID奥特曼数据

//---------------------------------------用户-------------------------------------------------
Route::post("/userRegistered", 'User/registered');//小程序授权登录
Route::get("/getUserInfo", 'User/getUserInfo');//获取用户信息