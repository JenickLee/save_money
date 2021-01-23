<?php
// 全局中间件定义文件
return [
    \app\api\middleware\AllowCrossDomain::class,
    \app\api\middleware\Check::class
];
