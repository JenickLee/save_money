<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/01/04
 * Time: 13:01
 */

namespace app\common\service;


class Base
{
    //开始
    public $offset = 0;
    //数量
    public $limit = 10;
    //排序
    public $order = null;

    public $model = null;
}