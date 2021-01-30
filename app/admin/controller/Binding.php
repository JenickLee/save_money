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

    /**
     * Notes:获取绑定信息详情
     * User: Jenick
     * Date: 2021/1/30
     * Time: 11:27 上午
     */
    public function getBindingDetail()
    {
        $param = input('get.');
        $validate = new Validate();
        $rule['id|id'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }

        try {
            $this->obj->setId($param['id']);
            $res = $this->obj->getBindingDetailById();
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }

    /**
     * Notes:拒绝绑定
     * User: Jenick
     * Date: 2021/1/30
     * Time: 11:27 上午
     */
    public function refuseBinding()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['id'] = 'require';
        $rule['process_result|拒绝理由'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }

        try {
            $this->obj->setId($param['id']);
            $this->obj->setUby($this->adminUserId);
            $this->obj->setProcessResult($param['process_result']);
            $this->obj->refuseBinding();
            $this->saveSysLog("管理员[{$this->adminUserInfo['nickname']}]，审核申请号[{$param['id']}]，拒绝了该用户的申请，理由为：{$param['process_result']}");
            return Response::success();
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }

    /**
     * Notes:绑定账号
     * User: Jenick
     * Date: 2021/1/30
     * Time: 2:15 下午
     */
    public function accountBinding()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['id'] = 'require';
        $rule['p_user_id'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }

        try {
            $this->obj->setId($param['id']);
            $this->obj->setUby($this->adminUserId);
            $res = $this->obj->accountBinding($param['p_user_id']);
            $this->saveSysLog("管理员[{$this->adminUserInfo['nickname']}]，审核申请号[{$param['id']}]，同意了该申请，并将百度ID：[{$res['postUserItInfo']['username']}]和用户ID：[{$res['user_id']}]账号进行了绑定操作！");
            return Response::success();
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}