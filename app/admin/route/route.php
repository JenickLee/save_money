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
Route::get("/getPostItUserList", 'PostItUser/getPostItUserList');//获取用户信息
Route::post("/addPostItUser", 'PostItUser/addPostItUser');//新增贴吧id用户

//-------------------------------------奥特曼-------------------------------------------------
Route::post("/addUltraman", 'Ultraman/addUltraman');//新增奥特曼
Route::get("/getPostItUserUltramanInfo", 'Ultraman/getPostItUserUltramanInfo');//获取贴吧ID奥特曼信息