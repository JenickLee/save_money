<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/3
 * Time: 11:29 下午
 */

namespace app\common\bean;


class Template extends Base
{
    private $id = null;
    //code
    private $code = null;
    //模板名称
    private $name = null;
    //模板id
    private $templateId = null;
    //关键词
    private $keyWords = null;
    //创建时间
    private $createTime = null;
    //状态
    private $status = 1;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param null $templateId
     */
    public function setTemplateId($templateId): void
    {
        $this->templateId = $templateId;
    }

    /**
     * @return null
     */
    public function getKeyWords()
    {
        return $this->keyWords;
    }

    /**
     * @param null $keyWords
     */
    public function setKeyWords($keyWords): void
    {
        $this->keyWords = $keyWords;
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
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}