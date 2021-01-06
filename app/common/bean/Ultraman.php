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
    //年度id
    private $yid = null;
    //用户id
    private $userId = null;
    //当前存款基数
    private $depositBase = 0;
    //目标
    private $aims = 0;
    //创建时间
    private $createTime = null;
    //更新时间
    private $updateTime = null;

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
    public function getYid()
    {
        return $this->yid;
    }

    /**
     * @param null $yid
     */
    public function setYid($yid): void
    {
        $this->yid = $yid;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param null $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
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
}