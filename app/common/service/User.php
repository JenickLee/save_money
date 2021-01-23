<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 2:21 下午
 */

namespace app\common\service;

use app\common\model\mysql\{User as UserModel};
use app\common\bean\User as UserBean;
use app\common\lib\{Date, WeChat as WeChatLib};

class User extends UserBean
{
    public function __construct($page = 0, $pageSize = 10)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new UserModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:用户注册
     * User: Jenick
     * Date: 2020/01/05
     * Time: 09:33
     * @param String $code
     * @return UserModel|array|bool|mixed|string
     * @throws \Exception
     */
    public function userRegistered(String $code)
    {
        try {
            $user = (new WeChatLib(config('wechat.app_id'), config('wechat.app_secret')))->getJscode2session($code);
            if (isset($user['errcode'])) {
                throw new \Exception($user['errmsg']);
            }
            if ($user && isset($user['openid'])) {
                $result = [
                    'openid' => $user['openid'],
                    'session_key' => $user['session_key'],
                    'unionid' => $user['unionid'] ?? ''
                ];
                $this->model->setField('openid, id, unionid');
                $this->model->setWhereArr(['openid' => $result['openid']]);
                $userInfo = $this->model->findOneInfo();

                if (!$userInfo) {
                    $data['app_id'] = $appInfo['id'] ?? 0;
                    $data['openid'] = $result['openid'];
                    $data['unionid'] = $result['unionid'];
                    $data['nickname'] = $this->getNickname();
                    $data['avatar'] = $this->getAvatar();
                    $data['create_time'] = $this->getCreateTime();
                    $userId = $this->model->insertGetId($data);
                    if (!$userId) {
                        throw new \Exception('注册失败');
                    }
                } else {
                    $userId = $userInfo['id'];
                    $data['nickname'] = $this->getNickname();
                    $data['avatar'] = $this->getAvatar();
                    $data['update_time'] = date('Y-m-d H:i:s');
                    $this->model->setId($userId);
                    $this->model->setArr($data);
                    $this->model->useIdUpdateData();
                }

                if ($userId) {
                    $response['user_id'] = $userId;
                    $response['openid'] = $result['openid'];
                    $response['nickname'] = $this->getNickname();
                    $response['avatar'] = $this->getAvatar();
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $response ?? [];
    }

    /**
     * Notes:获取用户信息
     * User: Jenick
     * Date: 2020/9/4
     * Time: 10:12 下午
     */
    public function getUserInfo()
    {
        $where['id'] = $this->getId();
        $this->model->setWhereArr($where);
        $this->model->setField('id user_id, nickname, avatar, img, introduction, root');
        $res = $this->model->findOneInfo();
        return $res;
    }

    /**
     * Notes:小程序新增人数
     * User: Jenick
     * Date: 2021/1/23
     * Time: 3:52 下午
     */
    public function getAddUserDataAnalysis()
    {
        $startDate = date("Y-m-d", mktime(0, 0, 0, date("d") - 14, 1, date("Y")));
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