<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 4:32 下午
 */

namespace app\common\service;

use app\common\bean\PostItUser as PostItUserBean;
use app\common\lib\BuildId;
use app\common\lib\Date;
use app\common\lib\Str;
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
     * Notes:获取贴吧用户列表
     * User: Jenick
     * Date: 2021/1/7
     * Time: 4:34 下午
     */
    public function getListAndGetFirstCharters()
    {
        $this->model->setOrder('p.username asc');
        $this->model->setField("p.*, user.avatar");
        $res = $this->model->findAllInfoAndUser();
        if (!$res) {
            return [];
        }
        $arr = [];
        foreach ($res as $vo) {
            $firstCharters = Str::getFirstCharters($vo['username']);
            if (!empty($firstCharters)) {
                $arr[Str::getFirstCharters($vo['username'])][] = $vo;
            } else {
                $arr['#'][] = $vo;
            }
        }
        $letter = array_keys($arr);
        $index = array_search('#', $letter);
        if ($index) {
            unset($letter[$index]);
        }
        array_multisort($letter);
        if ($index) {
            array_push($letter, '#');
        }

        $response = [];
        foreach ($letter as $item) {
            $response[] = [
                'letter' => $item,
                'data' => $arr[$item]
            ];
        }
        return $response;
    }

    /**
     * Notes:获取贴吧用户列表
     * User: Jenick
     * Date: 2021/1/7
     * Time: 4:34 下午
     */
    public function getListAndGetFirstChartersNew()
    {
        $this->model->setOrder('p.username asc');
        $this->model->setField("p.*, user.avatar");
        $res = $this->model->findAllInfoAndUser();
        if (!$res) {
            return [];
        }
        $arr = [];
        foreach ($res as $vo) {
            $firstCharters = Str::getFirstCharters($vo['username']);
            if (!empty($firstCharters)) {
                $arr[Str::getFirstCharters($vo['username'])][] = $vo;
            } else {
                $arr['#'][] = $vo;
            }
        }
        $letter = array_keys($arr);
        $index = array_search('#', $letter);
        if ($index) {
            unset($letter[$index]);
        }
        array_multisort($letter);
        if ($index) {
            array_push($letter, '#');
        }

        $response = [];
        foreach ($letter as $item) {
            $response['data'][] = [
                'letter' => $item,
                'data' => $arr[$item]
            ];
        }
        $response['sideBarData'] = array_column($response['data'], 'letter');
        return $response;
    }

    /**
     * Notes:获取贴吧用户总数
     * User: Jenick
     * Date: 2021/1/7
     * Time: 4:34 下午
     */
    public function getPostItUserCount()
    {
        $res = $this->model->getCount();
        return $res;
    }

    /**
     * Notes:新增贴吧id用户
     * User: Jenick
     * Date: 2021/1/7
     * Time: 5:07 下午
     * @throws \Exception
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
            'cby' => $this->getCby(),
            'create_time' => $this->getCreateTime(),
            'uby' => $this->getUby(),
            'update_time' => $this->getUpdateTime()
        ];
        $res = $this->model->insertGetId($data);
        if (!$res) {
            throw new \Exception('新增贴吧ID失败');
        }
        return $res;
    }

    /**
     * Notes:更新贴吧ID
     * User: Jenick
     * Date: 2021/1/17
     * Time: 3:17 下午
     * @throws \Exception
     */
    public function editUsername()
    {
        $id = $this->getId();
        $this->model->setWhereArr(['id' => $id]);
        $res = $this->model->findOneInfo();
        if (!$res) {
            throw new \Exception('贴吧ID不存在');
        }
        $oldUsername = $res['username'];
        $username = $this->getUsername();
        $this->model->setWhereArr(['username' => $username]);
        $res = $this->model->findOneInfo();
        if ($res) {
            throw new \Exception('贴吧id已存在');
        }
        $data = [
            'username' => $username,
            'uby' => $this->getUby(),
            'update_time' => $this->getUpdateTime()
        ];
        $this->model->setId($id);
        $this->model->setArr($data);
        $res = $this->model->useIdUpdateData();
        if (!$res) {
            throw new \Exception('更新贴吧ID失败');
        }
        return [
            'old_username' => $oldUsername,
            'new_username' => $username
        ];
    }

    /**
     * Notes:根据id获取贴吧用户信息
     * User: Jenick
     * Date: 2021/1/17
     * Time: 3:33 下午
     * @throws \Exception
     */
    public function getPostItUserInfoById()
    {
        $this->model->setWhereArr(['p.id' => $this->getId()]);
        $this->model->setField("p.*, user.avatar");
        $res = $this->model->findOneInfoAndUser();
        if (!$res) {
            throw new \Exception('贴吧ID信息不存在');
        }
        return $res;
    }

    /**
     * Notes:根据user_id获取贴吧用户信息
     * User: Jenick
     * Date: 2021/1/17
     * Time: 5:42 下午
     */
    public function getPostItUserInfoByUserId()
    {
        $this->model->setWhereArr(['user_id' => $this->getUserId()]);
        $res = $this->model->findOneInfo();
        return $res ?? [];
    }

    /**
     * Notes:生成绑定码
     * User: Jenick
     * Date: 2021/1/18
     * Time: 3:01 下午
     * @throws \Exception
     */
    public function generateBindingCode()
    {
        $id = $this->getId();
        $this->model->setWhereArr(['id' => $id]);
        $res = $this->model->findOneInfo();
        if (!$res) {
            throw new \Exception('贴吧ID不存在');
        }
        if (!empty($res['user_id'])) {
            throw new \Exception('该贴吧ID已被绑定');
        }

        $username = $res['username'];

        if($res['exp_time'] < date('Y-m-d H:i:s', time() + 60 * 60)) {
            $arr = [
                'binding_code' => BuildId::createId(),
                'exp_time' => date('Y-m-d H:i:s', time() + 60 * 120)
            ];
            $this->model->setId($id);
            $this->model->setArr($arr);
            $res = $this->model->useIdUpdateData();
            if (!$res) {
                throw new \Exception('绑定码生成失败');
            }
        } else {
            $arr = [
                'binding_code' => $res['binding_code'],
                'exp_time' => $res['exp_time'],
            ];
        }

        return [
            'flag' => ($res['exp_time'] < date('Y-m-d H:i:s', time() + 60 * 60)),
            'username' => $username,
            'binding_info' => $arr
        ];
    }

    /**
     * Notes:账号绑定
     * User: Jenick
     * Date: 2021/1/18
     * Time: 9:40 下午
     * @throws \Exception
     */
    public function accountBinding()
    {
        $bindingCode = $this->getBindingCode();
        $this->model->setWhereArr([
            ['binding_code', '=', $bindingCode],
            ['exp_time', '>', date('Y-m-d H:i:s')],
            ['user_id', '=', null]
        ]);
        $res = $this->model->findOneInfo();
        if (!$res) {
            throw new \Exception('绑定码不存在或者已失效！');
        }
        $postUserIt = $res;
        $userId = $this->getUserId();
        $this->model->setId($res['id']);
        $this->model->setArr(['user_id' => $userId, 'uby' => $userId, 'update_time' => date('Y-m-d H:i:s')]);
        $res = $this->model->useIdUpdateData();
        if (!$res) {
            throw new \Exception('绑定失败');
        }
        return $postUserIt;
    }


    /**
     * Notes:贴吧ID新增人数统计
     * User: Jenick
     * Date: 2021/1/23
     * Time: 3:52 下午
     */
    public function getAddPostItUserDataAnalysis()
    {
        $startDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 6, date("Y")));
        $endDate = date("Y-m-d");
        $where = [
            ['create_time', '>=', "{$startDate} 00:00:00"],
            ['create_time', '<=', "{$endDate} 23:59:59"]
        ];
        $this->model->setWhereArr($where);
        $this->model->setField('create_time, id');
        $res = $this->model->findAllInfo();

        $date = Date::getDateByInterval($startDate, $endDate, 'day');
        $response = [];
        foreach ($date as $value) {
            $response[] = [
                'date' => date("m-d", strtotime($value)),
                'sales' => count(array_filter($res, function ($item) use ($value) {
                    return date("Y-m-d", strtotime($item['create_time'])) == $value;
                }))
            ];
        }
        return $response;
    }

}