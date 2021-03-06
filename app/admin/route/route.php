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
//-------------------------------------贴吧用户-------------------------------------------------
Route::get("/3.0/getPostItUserList", 'PostItUser/getPostItUserList');//获取贴吧ID列表
Route::post("/addPostItUser", 'PostItUser/addPostItUser');//新增贴吧id用户
Route::post("/editUsername", 'PostItUser/editUsername');//更新贴吧id
Route::get("/getPostItUserInfo", 'PostItUser/getPostItUserInfo');//获取贴吧ID信息

//---------------------------------------绑定百度ID-------------------------------------------------
Route::get("/getBindingList", 'Binding/getBindingList');//获取绑定信息列表
Route::get("/getBindingDetail", 'Binding/getBindingDetail');//获取绑定信息详情
Route::post("/refuseBinding", 'Binding/refuseBinding');//拒绝绑定
Route::post("/accountBinding", 'Binding/accountBinding');//绑定账号

//-------------------------------------奥特曼-------------------------------------------------
Route::post("/addUltraman", 'Ultraman/addUltraman');//新增奥特曼
Route::get("/getPostItUserUltramanInfo", 'Ultraman/getPostItUserUltramanInfo');//获取贴吧ID奥特曼信息
Route::post("/editUltraman", 'Ultraman/editUltraman');//更新奥特曼

//---------------------------------------数据分析-------------------------------------------------
Route::get("/getAddUserDataAnalysis", 'DataAnalysis/getAddUserDataAnalysis');//用户新增人数统计
Route::get("/getAddPostItUserDataAnalysis", 'DataAnalysis/getAddPostItUserDataAnalysis');//贴吧ID新增人数统计
Route::post("/getUserDepositBaseDataAnalysis", 'DataAnalysis/getUserDepositBaseDataAnalysis');//获取用户当前存款数据

//---------------------------------------订阅消息-------------------------------------------------
Route::post("/addSubscribeMessage", 'SubscriptionMessage/addSubscribeMessage');//新增订阅消息
Route::get("/getSubscribeMessageCount", 'SubscriptionMessage/getSubscribeMessageCount');//获取有效订阅消息数