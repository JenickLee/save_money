<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/6
 * Time: 5:03 下午
 */

namespace app\api\controller;

use app\common\bean\PostItUser;
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

    /***
     * Notes:新增数据
     * User: Jenick
     * Date: 2021/1/7
     * Time: 12:31 上午
     */
    public function add()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['username|贴吧ID'] = 'require';
        $rule['deposit_base|当前存款基数'] = 'require';
        $rule['aims|目标'] = 'require';
        $rule['start_time|起始时间'] = 'require';
        $rule['end_time|结束时间'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }
        $postItUser = new PostItUser();
        $postItUser->setUsername($param['username']);

        $this->obj->setPostItUser($postItUser);
        $this->obj->setAims($param['aims']);
        $this->obj->setDepositBase($param['deposit_base']);
        $this->obj->setStartTime($param['start_time']);
        $this->obj->setEndTime($param['end_time']);
        $res = $this->obj->addUltraman();
        if ($res) {
            return Response::success();
        }
        return Response::error(config('code.error'), '新增失败');
    }
}