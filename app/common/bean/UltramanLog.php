<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/15
 * Time: 7:20 下午
 */

namespace app\common\bean;


class UltramanLog extends Base
{
    //主键id
    private $id = null;
    //奥特曼id
    private $uid = null;
    //类型 1-创建 2-修改当前基数 3-修改目标
    private $type = null;
    //当前存款基数
    private $depositBase = 0;
    //目标
    private $aims = 0;
    //创建时间
    private $createTime = null;
    //更新时间
    private $updateTime = null;

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
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param null $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null $type
     */
    public function setType($type): void
    {
        $this->type = $type;
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
     * @return false|string|null
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param false|string|null $updateTime
     */
    public function setUpdateTime($updateTime): void
    {
        $this->updateTime = $updateTime;
    }
}