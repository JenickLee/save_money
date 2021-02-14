<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/7
 * Time: 7:00 下午
 */

namespace app\common\bean;


class ExchangeGoods extends Base
{
    private $id = null;
    //商品标题
    private $title = null;
    //icon文本
    private $iconText = null;
    //商品说明
    private $desc = null;
    //兑换类别 1-虚拟产品 2-话费/视频会员 3-礼品卡 4-实物
    private $redemptionCategory = null;
    //兑现所需积分
    private $integral = 0;
    //最多可兑换几次 默认一次
    private $num = 1;
    //创建时间
    private $createTime = null;
    //活动开始时间
    private $startTime = null;
    //活动结束时间
    private $endTime = null;

    public function __construct($createTime = null, $startTime = null, $endTime = null)
    {
        if(!isset($createTime)) $createTime = date('Y-m-d H:i:s');
        if(!isset($startTime)) $startTime = date('Y-m-d H:i:s');
        if(!isset($endTime)) $endTime = date('Y-m-d H:i:s');
        $this->createTime = $createTime;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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
    public function getRedemptionCategory()
    {
        return $this->redemptionCategory;
    }

    /**
     * @param null $redemptionCategory
     */
    public function setRedemptionCategory($redemptionCategory): void
    {
        $this->redemptionCategory = $redemptionCategory;
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
     * @return int
     */
    public function getNum(): int
    {
        return $this->num;
    }

    /**
     * @param int $num
     */
    public function setNum(int $num): void
    {
        $this->num = $num;
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
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param false|string|null $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return false|string|null
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param false|string|null $endTime
     */
    public function setEndTime($endTime): void
    {
        $this->endTime = $endTime;
    }
}