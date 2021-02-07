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
Route::post("/addBindingInfo", 'Binding/addBindingInfo');//提交绑定信息
Route::get("/getBindingInfo", 'Binding/getBindingInfo');//获取绑定信息

//---------------------------------------数据分析-------------------------------------------------
Route::get("/getUltramanDataAnalysis", 'DataAnalysis/getUltramanDataAnalysis');//获取奥特曼数据统计
Route::get("/getParticipateDataAnalysis", 'DataAnalysis/getParticipateDataAnalysis');//统计月份奥特曼参加人数
Route::post("/getUserDepositBaseDataAnalysis", 'DataAnalysis/getUserDepositBaseDataAnalysis');//获取用户当前存款数据

//---------------------------------------Banner-------------------------------------------------
Route::get("/getUltramanBanner", 'SysImage/getUltramanBanner');//获取奥特曼Banner图

//---------------------------------------订阅消息-------------------------------------------------
Route::post("/addSubscribeMessage", 'SubscriptionMessage/addSubscribeMessage');//新增订阅消息

//---------------------------------------积分任务-------------------------------------------------
Route::get("/getPointsTaskList", 'PointsTask/getPointsTaskList');//获取积分任务
Route::get("/getMyTotalPoints", 'PointsList/getMyTotalPoints');//获取我的积分总数
Route::get("/getPointsList", 'PointsList/getPointsList');//获取积分明细