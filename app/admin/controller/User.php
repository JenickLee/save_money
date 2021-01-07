<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 2:29 下午
 */
namespace app\api\controller;

use think\App;
use think\Validate;
use app\common\lib\Response;
use app\common\service\{User as UserService};
class User extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new UserService();
    }
    
}