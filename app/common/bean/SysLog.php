<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/9/9
 * Time: 3:06 下午
 */

namespace app\common\bean;


class SysLog extends Base
{
    private $id = null;
    //1-用户 2后台
    private $type = null;
    //日志内容
    private $content = null;
    //操作人
    private $cby = null;
    //操作时间
    private $createTime = null;
    //ip地址
    private $ip = null;
    //IP国家
    private $ipCountry = null;
    //IP省份
    private $ipProvince = null;
    //IP城市
    private $ipCity = null;
    //IP运营商
    private $ipIsp = null;

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param null $ip
     */
    public function setIp($ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return null
     */
    public function getIpCountry()
    {
        return $this->ipCountry;
    }

    /**
     * @param null $ipCountry
     */
    public function setIpCountry($ipCountry): void
    {
        $this->ipCountry = $ipCountry;
    }

    /**
     * @return null
     */
    public function getIpProvince()
    {
        return $this->ipProvince;
    }

    /**
     * @param null $ipProvince
     */
    public function setIpProvince($ipProvince): void
    {
        $this->ipProvince = $ipProvince;
    }

    /**
     * @return null
     */
    public function getIpCity()
    {
        return $this->ipCity;
    }

    /**
     * @param null $ipCity
     */
    public function setIpCity($ipCity): void
    {
        $this->ipCity = $ipCity;
    }

    /**
     * @return null
     */
    public function getIpIsp()
    {
        return $this->ipIsp;
    }

    /**
     * @param null $ipIsp
     */
    public function setIpIsp($ipIsp): void
    {
        $this->ipIsp = $ipIsp;
    }
}