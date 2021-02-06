<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 12:12 上午
 */

namespace app\common\bean;


class PointsTask extends Base
{
    private $id = null;
    //任务标题
    private $title = null;
    //icon文本
    private $iconText = null;
    //说明
    private $desc = null;
    //任务类型 1-绑定百度id 2-签到
    private $taskType = null;
    //积分
    private $integral = 0;
    //创建时间
    private $createTime = null;
    //生效时间
    private $effTime = null;
    //失效时间
    private $expTime = null;

    public function __construct($createTime = null, $effTime = null, $expTime = null)
    {
        if(!isset($createTime)) $createTime = date('Y-m-d H:i:s');
        if(!isset($effTime)) $effTime = date('Y-m-d H:i:s');
        if(!isset($expTime)) $expTime = date('Y-m-d H:i:s');
        $this->createTime = $createTime;
        $this->effTime = $effTime;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getIconText()
    {
        return $this->iconText;
    }

    /**
     * @param null $iconText
     */
    public function setIconText($iconText): void
    {
        $this->iconText = $iconText;
    }

    /**
     * @return null
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param null $desc
     */
    public function setDesc($desc): void
    {
        $this->desc = $desc;
    }

    /**
     * @return null
     */
    public function getTaskType()
    {
        return $this->taskType;
    }

    /**
     * @param null $taskType
     */
    public function setTaskType($taskType): void
    {
        $this->taskType = $taskType;
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
    public function getEffTime()
    {
        return $this->effTime;
    }

    /**
     * @param false|string|null $effTime
     */
    public function setEffTime($effTime): void
    {
        $this->effTime = $effTime;
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