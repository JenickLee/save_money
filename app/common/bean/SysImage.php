<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/25
 * Time: 8:01 下午
 */

namespace app\common\bean;


class SysImage extends Base
{
    //id
    private $id = null;
    //是否显示 0-下架 1-上架显示 默认1
    private $show = 1;
    //类型 1-奥特曼banner图
    private $type = null;
    //排序 越大越前 默认1
    private $sort = 1;
    //标题
    private $title = null;
    //图片id
    private $img = null;
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
     * @return int
     */
    public function getShow(): int
    {
        return $this->show;
    }

    /**
     * @param int $show
     */
    public function setShow(int $show): void
    {
        $this->show = $show;
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
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort(int $sort): void
    {
        $this->sort = $sort;
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