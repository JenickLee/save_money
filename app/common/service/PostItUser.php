<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 4:32 下午
 */

namespace app\common\service;

use app\common\bean\PostItUser as PostItUserBean;
use app\common\model\mysql\{PostItUser as PostItUserModel};

class PostItUser extends PostItUserBean
{
    public function __construct($page = 0, $pageSize = null)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new PostItUserModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:获取贴吧用户列表
     * User: Jenick
     * Date: 2021/1/7
     * Time: 4:34 下午
     */
    public function getPostItUserList()
    {
        $this->model->setOrder('username asc');
        $res = $this->model->findAllInfo();
        return $res;
    }

    /**
     * Notes:新增贴吧id用户
     * User: Jenick
     * Date: 2021/1/7
     * Time: 5:07 下午
     */
    public function addPostItUser()
    {
        $username = $this->getUsername();
        $this->model->setWhereArr(['username' => $username]);
        $res = $this->model->findOneInfo();
        if ($res) {
            throw new \Exception('贴吧ID已存在');
        }
        $data = [
            'username' => $username,
            'create_time' => $this->getCreateTime()
        ];
        $res = $this->model->insertGetId($data);
        if (!$res) {
            throw new \Exception('新增贴吧ID失败');
        }
        return $res;
    }
}