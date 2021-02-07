<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 3:03 下午
 */

namespace app\common\bean;


class PointsList extends Base
{
    private $id = null;
    //用户id
    private $userId = null;
    //类型 1-获得 2-使用
    private $type = null;
    //积分任务id/兑换产品id
    private $pid = null;
    //积分数量
    private $integral = 0;
    //获得/使用时间
    private $createTime = null;
    //失效时间
    private $expTime = null;

    public function __construct($createTime = null, $expTime = null)
    {
        if(!isset($createTime)) $createTime = date('Y-m-d H:i:s');
        if(!isset($expTime)) $expTime = date('Y-m-d H:i:s');
        $this->createTime = $createTime;
        $this->expTime = $expTime;
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
     * @return null
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param null $pid
     */
    public function setPid($pid): void
    {
        $this->pid = $pid;
    }

    /**
     * @return int
     */
    public function getIntegral(): int
    {
        return $this->integral;
    }

    /**
     * @param int $integral
     */
    public function setIntegral(int $integral): void
    {
        $this->integral = $integral;
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
    public function getExpTime()
    {
        return $this->expTime;
    }

    /**
     * @param false|string|null $expTime
     */
    public function setExpTime($expTime): void
    {
        $this->expTime = $expTime;
    }


}