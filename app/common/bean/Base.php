<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/9/9
 * Time: 10:43 上午
 */
namespace app\common\bean;


class Base
{
    public $model = null;
    //开始
    private $offset = 0;
    //数量
    private $limit = null;
    //排序
    private $order = null;

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param null $limit
     */
    public function setLimit($limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param null $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

}