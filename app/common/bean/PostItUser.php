<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/7
 * Time: 12:40 上午
 */

namespace app\common\bean;


class PostItUser extends Base
{
    //主键id
    private $id = null;
    //贴吧ID
    private $username = null;
    //创建时间
    private $createTime = null;
    //更新时间
    private $updateTime = null;

    /**
     * PostItUser constructor.
     * @param null $createTime
     */
    public function __construct($createTime = null, $updateTime = null)
    {
        if (!isset($createTime)) $createTime = date('Y-m-d H:i:s');
        if (!isset($updateTime)) $updateTime = date('Y-m-d H:i:s');
        $this->updateTime = $updateTime;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param null $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
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