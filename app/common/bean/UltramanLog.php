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
    //类型 1-创建 2-修改当前存款 3-修改目标
    private $type = null;
    //当前存款存款
    private $depositBase = 0;
    //目标
    private $aims = 0;
    //创建人
    private $cby = null;
    //创建时间
    private $createTime = null;

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
}