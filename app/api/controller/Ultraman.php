<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/6
 * Time: 5:03 下午
 */

namespace app\api\controller;

use app\common\lib\Response;
use think\App;
use app\common\service\Ultraman as UltramanService;
use think\Validate;

class Ultraman extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new UltramanService($this->page, $this->pageSize);
    }

    /**
     * Notes:获取奥特曼列表
     * User: Jenick
     * Date: 2021/1/6
     * Time: 5:42 下午
     */
    public function getList()
    {
        $res = $this->obj->getList();
        return Response::success($res);
    }

    /**
     * Notes:获取奥特曼列表
     * User: Jenick
     * Date: 2021/1/6
     * Time: 5:42 下午
     */
    public function getUltramanList()
    {
        $this->response['list'] = $this->obj->getList();
        $this->response['count'] = $this->obj->getUltramanCount();
        return Response::success($this->response);
    }

    /**
     * Notes:获取贴吧ID奥特曼信息
     * User: Jenick
     * Date: 2021/1/7
     * Time: 6:17 下午
     */
    public function getPostItUserUltramanInfo()
    {
        $param = input('get.');
        $validate = new Validate();
        $rule['p_user_id|贴吧id'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }
        $this->obj->setPUserId($param['p_user_id']);
        $res = $this->obj->getPostItUserUltramanInfo();
        return Response::success($res);
    }
}