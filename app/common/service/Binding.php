<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/29
 * Time: 10:27 下午
 */

namespace app\common\service;

use app\common\bean\Binding as BindingBean;
use app\common\model\mysql\{Binding as BindingModel};

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

}