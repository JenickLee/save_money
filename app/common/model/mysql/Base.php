<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/01/04
 * Time: 13:09
 */

namespace app\common\model\mysql;

use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class Base extends Bean
{
    /**
     * Notes:根据条件获取总数
     * User: Jenick
     * Date: 2020/1/3
     * Time: 9:50
     */
    public function getCount()
    {
        try {
            $res = $this->where($this->getWhereArr())->count();
            return $res;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Notes:根据条件获取数据
     * User: Jenick
     * Date: 2020/1/3
     * Time: 10:27
     */
    public function findOneInfo()
    {
        try {
            if (empty($this->getWhereArr())) {
                $res = $this->field($this->getField())->order($this->getOrder())->find(1);
            } else {
                $res = $this->field($this->getField())->where($this->getWhereArr())->order($this->getOrder())->find();
            }

            if (is_object($res)) $res = $res->toArray();
            return $res;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Notes:根据条件获取数据
     * User: Jenick
     * Date: 2020/01/04
     * Time: 22:38
     */
    public function findAllInfo()
    {
        try {
            $res = $this->field($this->getField())->where($this->getWhereArr())->limit($this->getOffset(), $this->getLimit())->order($this->getOrder())->select();
            if (is_object($res)) $res = $res->toArray();
            return $res;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    /**
     * Notes:根据id删除数据
     * User: Jenick
     * Date: 2020/04/12
     * Time: 18:45
     * @return bool
     */
    public function useIdDelete()
    {
        if (empty($this->getId())) return false;

        try {
            $res = $this->where(['id' => $this->getId()])->delete();
            return $res;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Notes:根据id更新数据
     * User: Jenick
     * Date: 2020/04/12
     * Time: 18:46
     */
    public function useIdUpdateData()
    {
        if (empty($this->getId())) return false;
        try {
            $res = $this->where(['id' => $this->getId()])->update($this->getArr());
            return (!!$res);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Notes:根据条件自增
     * User: Jenick
     * Date: 2020/1/3
     * Time: 11:22
     */
    public function useIdSetInc()
    {
        if (empty($this->getId())) return false;
        if (empty($this->getInc())) return false;

        try {
            return $this->where(['id' => $this->getId()])->inc($this->getInc(), $this->getStride())->update();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Notes:根据条件自减
     * User: Jenick
     * Date: 2020/1/3
     * Time: 11:22
     */
    public function useIdSetDec()
    {
        if (empty($this->getId())) return false;
        if (empty($this->getDec())) return false;

        try {
            return $this->where(['id' => $this->getId()])->dec($this->getDec(), $this->getStride())->update();
        } catch (\Exception $e) {
            return false;
        }
    }
}