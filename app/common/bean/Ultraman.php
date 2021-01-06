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
    //当前存款基数
    private $depositBase = 0;
    //目标
    private $aims = 0;
    //创建时间
    private $createTime = null;
    //更新时间
    private $updateTime = null;
    //开始时间
    private $startTime = null;
    //截止时间
    private $endTime = null;

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

    /**
     * @return int
     */
    public function getDepositBase(): int
    {
        return $this->depositBase;
    }

    /**
     * @param int $depositBase
     */
    public function setDepositBase(int $depositBase): void
    {
        $this->depositBase = $depositBase;
    }

    /**
     * @return int
     */
    public function getAims(): int
    {
        return $this->aims;
    }

    /**
     * @param int $aims
     */
    public function setAims(int $aims): void
    {
        $this->aims = $aims;
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

}