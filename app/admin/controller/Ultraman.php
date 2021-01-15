<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 5:56 下午
 */
namespace app\admin\controller;

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

    /***
     * Notes:新增数据
     * User: Jenick
     * Date: 2021/1/7
     * Time: 12:31 上午
     */
    public function addUltraman()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['p_user_id|贴吧id'] = 'require';
        $rule['deposit_base|当前存款基数'] = 'require';
        $rule['aims|目标'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }
        $this->obj->setPUserId($param['p_user_id']);
        $this->obj->setAims($param['aims']);
        $this->obj->setDepositBase($param['deposit_base']);
        $this->obj->setStartTime($param['start_time']?? date('Y-01-01 00:00:00'));
        $this->obj->setEndTime($param['end_time']?? date('Y-12-31 23:59:59'));
        try {
            $res = $this->obj->addUltraman();
            return Response::success();
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
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

    /***
     * Notes:新增数据
     * User: Jenick
     * Date: 2021/1/7
     * Time: 12:31 上午
     */
    public function editUltraman()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['id'] = 'require';
        $rule['type'] = 'require';//1-当前基数 2-目标
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }

        $this->obj->setId($param['id']);
        $this->obj->setAims($param['aims']??null);
        $this->obj->setDepositBase($param['deposit_base']??null);
        try {
            $res = $this->obj->editUltraman($param['type']);
            return Response::success();
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}