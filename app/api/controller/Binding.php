<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/29
 * Time: 10:28 下午
 */

namespace app\api\controller;

use app\common\lib\Response;
use app\common\service\Binding as BindingService;
use think\App;
use think\Validate;

class Binding extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new BindingService($this->page, $this->pageSize);
    }

    /**
     * Notes:提交绑定信息
     * User: Jenick
     * Date: 2021/1/29
     * Time: 10:37 下午
     */
    public function addBindingInfo()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['img|图片id'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }

        try {
            $this->obj->setImg($param['img']);
            $this->obj->setCby($this->userId);
            $this->obj->addBindingInfo();
            return Response::success();
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}