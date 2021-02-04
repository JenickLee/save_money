<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/29
 * Time: 10:27 下午
 */

namespace app\common\service;

use app\common\bean\Binding as BindingBean;
use app\common\lib\Cos;
use app\common\model\mysql\{Binding as BindingModel, PostItUser as PostItUserModel};
use think\facade\Db;

class Binding extends BindingBean
{
    public function __construct($page = 0, $pageSize = null)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new BindingModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:提交绑定信息
     * User: Jenick
     * Date: 2021/1/29
     * Time: 10:33 下午
     * @throws \Exception
     */
    public function addBindingInfo()
    {
        try {
            $data = [
                'img' => $this->getImg(),
                'cby' => $this->getCby(),
                'create_time' => $this->getCreateTime()
            ];
            $res = $this->model->insertGetId($data);
            if (!$res) {
                throw new \Exception('提交失败');
            }

            $userService = new User();
            $userService->setRoot(1);
            $adminUser = $userService->getUserByRoot();
            $subscriptionMessageService = new SubscriptionMessage();
            foreach ($adminUser as $vo){
                $subscriptionMessageService->setUserId($vo['id']);
                $subscriptionMessageService->sendBaiduIdReviewReminder($res, '百度ID审核提醒');
            }

            return $res;
        } catch (\Exception $e) {
            throw new \Exception('提交失败');
        }
    }

    /**
     * Notes:根据提交人获取最新的绑定信息
     * User: Jenick
     * Date: 2021/1/29
     * Time: 11:04 下午
     */
    public function getBindingInfoByCby()
    {
        $this->model->setWhereArr(['cby' => $this->getCby()]);
        $this->model->setOrder("create_time desc, id desc");
        return $this->model->findOneInfo();
    }

    /**
     * Notes:获取绑定列表
     * User: Jenick
     * Date: 2021/1/30
     * Time: 10:32 上午
     */
    public function getBindingList()
    {
        $this->model->setOrder("b.schedule asc, b.create_time desc, b.id desc");
        $this->model->setField("b.*, user.nickname");
        return $this->model->findAllInfoAndUser();
    }

    /**
     * Notes:获取绑定数量
     * User: Jenick
     * Date: 2021/1/30
     * Time: 10:33 上午
     */
    public function getBindingCount()
    {
        return $this->model->getCount();
    }

    /**
     * Notes:根据id获取绑定信息详情
     * User: Jenick
     * Date: 2021/1/30
     * Time: 11:28 上午
     */
    public function getBindingDetailById()
    {
        $this->model->setWhereArr(['b.id' => $this->getId()]);
        $this->model->setField("b.*, user.nickname");
        $res = $this->model->findOneInfoAndUser();
        (new Cos())->getImgUrl($res, 'img');
        return $res;
    }

    /**
     * Notes:拒绝绑定
     * User: Jenick
     * Date: 2021/1/30
     * Time: 11:56 上午
     * @throws \Exception
     */
    public function refuseBinding()
    {
        $this->model->setWhereArr(['id' => $this->getId()]);
        $res = $this->model->findOneInfo();
        if (!$res) {
            throw new \Exception('绑定信息不存在');
        }
        $this->model->setId($this->getId());
        $this->model->setArr([
            'schedule' => 1,
            'uby' => $this->getUby(),
            'process_result' => $this->getProcessResult(),
            'update_time' => $this->getUpdateTime()
        ]);
        $res = $this->model->useIdUpdateData();
        if (!$res) {
            throw new \Exception('操作错误');
        }
        return true;
    }

    /**
     * Notes:账号绑定
     * User: Jenick
     * Date: 2021/1/18
     * Time: 9:40 下午
     * @throws \Exception
     */
    public function accountBinding($p_user_id)
    {
        Db::startTrans();

        try {
            //判断该处理任务是否已处理
            $this->model->setWhereArr(['id' => $this->getId()]);
            $bindingInfo = $this->model->findOneInfo();
            if (!$bindingInfo) {
                throw new \Exception('绑定信息不存在！');
            }
            if ($bindingInfo['schedule'] == 1) {
                throw new \Exception('绑定信息已处理不能重复处理！');
            }

            //判断该百度id是否存在
            $postUserItModel = new PostItUserModel();
            $postUserItModel->setWhereArr([
                ['user_id', '=', null],
                ['id', '=', $p_user_id]
            ]);
            $postUserItInfo = $postUserItModel->findOneInfo();
            if (!$postUserItInfo) {
                throw new \Exception('该百度ID不存在或已被绑定！');
            }

            //判断该处理任务更新为已处理
            $this->model->setId($this->getId());
            $this->model->setArr(['schedule' => 1, 'process_result' => '已绑定', 'uby' => $this->getUby(), 'update_time' => $this->getUpdateTime()]);
            $res = $this->model->useIdUpdateData();
            if (!$res) {
                throw new \Exception('操作失败');
            }

            //对百度id进行绑定操作
            $postUserItModel->setId($postUserItInfo['id']);
            $postUserItModel->setArr(['user_id' => $bindingInfo['cby'], 'uby' => $this->getUby(), 'update_time' => $this->getUpdateTime()]);
            $res = $postUserItModel->useIdUpdateData();
            if (!$res) {
                throw new \Exception('操作失败');
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            throw new \Exception($e->getMessage());
        }
        return [
            'postUserItInfo' => $postUserItInfo,
            'user_id' => $bindingInfo['cby']
        ];
    }

}