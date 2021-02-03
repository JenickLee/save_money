<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/9/9
 * Time: 2:58 下午
 */

namespace app\common\bean;


class SubscriptionMessage extends Base
{
    private $id = null;
    //user_id
    private $userId = null;
    //code
    private $code = null;
    //发送内容JOSN
    private $sentContent = null;
    //创建时间
    private $createTime = null;
    //发送时间
    private $sendTime = null;

    public function __construct($createTime = null, $sendTime = null)
    {
        if(!isset($createTime)) $createTime = date('Y-m-d H:i:s');
        if(!isset($sendTime)) $sendTime = date('Y-m-d H:i:s');
        $this->createTime = $createTime;
        $this->sendTime = $sendTime;
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param null $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return null
     */
    public function getSentContent()
    {
        return $this->sentContent;
    }

    /**
     * @param null $sentContent
     */
    public function setSentContent($sentContent): void
    {
        $this->sentContent = $sentContent;
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
    public function getSendTime()
    {
        return $this->sendTime;
    }

    /**
     * @param null $sendTime
     */
    public function setSendTime($sendTime): void
    {
        $this->sendTime = $sendTime;
    }
}