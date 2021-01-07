<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 2:21 下午
 */

namespace app\common\bean;


class User extends Base
{
    //user_id
    private $id = null;
    //openid
    private $openid = null;
    //unionid
    private $unionid = null;
    //用户昵称
    private $nickname = null;
    //用户头像
    private $avatar = null;
    //用户手机号
    private $phone = null;
    //背景
    private $img = null;
    //个人简介
    private $introduction = null;
    //加入时间
    private $createTime = null;
    //更新时间
    private $updateTime = null;

    /**
     * User constructor.
     * @param null $createTime
     */
    public function __construct($createTime = null)
    {
        if(!isset($createTime)) $createTime = date('Y-m-d H:i:s');
        $this->createTime = $createTime;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @param null $openid
     */
    public function setOpenid($openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return null
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     * @param null $unionid
     */
    public function setUnionid($unionid): void
    {
        $this->unionid = $unionid;
    }

    /**
     * @return null
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param null $nickname
     */
    public function setNickname($nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param null $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param null $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return null
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param null $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
    }

    /**
     * @return null
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * @param null $introduction
     */
    public function setIntroduction($introduction): void
    {
        $this->introduction = $introduction;
    }

    /**
     * @return false|string|null
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param false|string|null $createTime
     */
    public function setCreateTime($createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @return null
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param null $updateTime
     */
    public function setUpdateTime($updateTime): void
    {
        $this->updateTime = $updateTime;
    }

}