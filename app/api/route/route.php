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
Route::get("/v1.1/getUltramanList", 'Ultraman/getUltramanList');//获取奥特曼列表
Route::get("/getPostItUserUltramanInfo", 'Ultraman/getPostItUserUltramanInfo');//获取贴吧ID奥特曼信息
Route::post("/addUltraman", 'Ultraman/addUltraman');//新增奥特曼
Route::post("/editUltraman", 'Ultraman/editUltraman');//更新奥特曼

//---------------------------------------用户-------------------------------------------------
Route::post("/userRegistered", 'User/registered');//小程序授权登录
Route::get("/getUserInfo", 'User/getUserInfo');//获取用户信息

//---------------------------------------贴吧ID------------------------------------------------
Route::get("/getPostItUserInfo", 'PostItUser/getPostItUserInfo');//获取用户贴吧ID信息
Route::post("/accountBinding", 'PostItUser/accountBinding');//绑定贴吧ID

//---------------------------------------数据分析-------------------------------------------------
Route::get("/getUltramanDataAnalysis", 'DataAnalysis/getUltramanDataAnalysis');//获取奥特曼数据统计