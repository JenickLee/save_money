<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/6
 * Time: 5:06 下午
 */

namespace app\common\bean;


class Ultraman extends Base
{
    //主键id
    private $id = null;
    //贴吧用户id
    private $pUserId = null;
    //当前存款存款
    private $depositBase = 0;
    //目标
    private $aims = 0;
    //创建人
    private $cby = null;
    //创建时间
    private $createTime = null;
    //更新人
    private $uby = null;
    //更新时间
    private $updateTime = null;
    //开始时间
    private $startTime = null;
    //截止时间
    private $endTime = null;
    //贴吧用户数据
    private $postItUser = null;


    public function __construct($createTime = null, $updateTime = null)
    {
        if(!isset($createTime)) $createTime = date('Y-m-d H:i:s');
        if(!isset($updateTime)) $updateTime = date('Y-m-d H:i:s');
        $this->createTime = $createTime;
        $this->updateTime = $updateTime;
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
    public function getPUserId()
    {
        return $this->pUserId;
    }

    /**
     * @param null $pUserId
     */
    public function setPUserId($pUserId): void
    {
        $this->pUserId = $pUserId;
    }

    public function getDepositBase()
    {
        return $this->depositBase;
    }


    public function setDepositBase($depositBase): void
    {
        $this->depositBase = $depositBase;
    }

    public function getAims()
    {
        return $this->aims;
    }


    public function setAims($aims): void
    {
        $this->aims = $aims;
    }

    /**
     * @return null
     */
    public function getCby()
    {
        return $this->cby;
    }

    /**
     * @param null $cby
     */
    public function setCby($cby): void
    {
        $this->cby = $cby;
    }

    /**
     * @return null
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param null $createTime
     */
    public function setCreateTime($createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @return null
     */
    public function getUby()
    {
        return $this->uby;
    }

    /**
     * @param null $uby
     */
    public function setUby($uby): void
    {
        $this->uby = $uby;
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

    /**
     * @return null
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param null $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return null
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param null $endTime
     */
    public function setEndTime($endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return null
     */
    public function getPostItUser()
    {
        return $this->postItUser;
    }

    /**
     * @param null $postItUser
     */
    public function setPostItUser($postItUser): void
    {
        $this->postItUser = $postItUser;
    }


}