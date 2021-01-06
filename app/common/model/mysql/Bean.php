<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/9/9
 * Time: 6:10 下午
 */

namespace app\common\model\mysql;


use think\Model;

class Bean extends Model
{
    //主键id
    private $id = null;
    //数据
    private $arr = [];
    //自增字段
    private $inc = null;
    //自减字段
    private $dec = null;
    //步长
    private $stride = 1;
    //条件
    private $whereArr = [];
    //
    private $whereRaw = null;
    //开始
    private $offset = 0;
    //数量
    private $limit = null;
    //字段
    protected $field = '*';
    //排序
    private $order = null;
    //分组
    private $group = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getArr()
    {
        return $this->arr;
    }

    public function setArr($arr): void
    {
        $this->arr = $arr;
    }

    public function getInc()
    {
        return $this->inc;
    }

    public function setInc($inc): void
    {
        $this->inc = $inc;
    }

    public function getDec()
    {
        return $this->dec;
    }


    public function setDec($dec): void
    {
        $this->dec = $dec;
    }

    public function getStride(): int
    {
        return $this->stride;
    }

    public function setStride(int $stride): void
    {
        $this->stride = $stride;
    }


    public function getWhereArr()
    {
        return $this->whereArr;
    }

    public function setWhereArr($whereArr): void
    {
        $this->whereArr = $whereArr;
    }

    public function getWhereRaw()
    {
        return $this->whereRaw;
    }

    public function setWhereRaw($whereRaw): void
    {
        $this->whereRaw = $whereRaw;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }


    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }


    public function getLimit()
    {
        return $this->limit;
    }


    public function setLimit($limit): void
    {
        $this->limit = $limit;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setField($field): void
    {
        $this->field = $field;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order): void
    {
        $this->order = $order;
    }


    public function getGroup()
    {
        return $this->group;
    }


    public function setGroup($group): void
    {
        $this->group = $group;
    }
}