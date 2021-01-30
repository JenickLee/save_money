<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/29
 * Time: 10:28 下午
 */

namespace app\admin\controller;

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
     * Notes:获取绑定信息列表
     * User: Jenick
     * Date: 2021/1/29
     * Time: 11:03 下午
     */
    public function getBindingList()
    {
        try {
            $this->response['list'] = $this->obj->getBindingList();
            $this->response['count'] =$this->obj->getBindingCount();
            return Response::success($this->response);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}