<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/29
 * Time: 10:24 下午
 */

namespace app\common\bean;


class Binding extends Base
{
    //id
    private $id = null;
    //图片
    private $img = null;
    //处理结果
    private $processResult = null;
    //进度 0-未处理 1-已阅读 2-已处理
    private $schedule = 0;
    //创建人
    private $cby = null;
    //创建时间
    private $createTime = null;
    //更新人
    private $uby = null;
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
    public function getProcessResult()
    {
        return $this->processResult;
    }

    /**
     * @param null $processResult
     */
    public function setProcessResult($processResult): void
    {
        $this->processResult = $processResult;
    }

    /**
     * @return int
     */
    public function getSchedule(): int
    {
        return $this->schedule;
    }

    /**
     * @param int $schedule
     */
    public function setSchedule(int $schedule): void
    {
        $this->schedule = $schedule;
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