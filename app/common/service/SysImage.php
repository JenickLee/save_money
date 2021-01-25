<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/25
 * Time: 8:05 下午
 */

namespace app\common\service;

use app\common\bean\SysImage as SysImageBean;
use app\common\lib\Cos;
use app\common\model\mysql\SysImage as SysImageModel;

class SysImage extends SysImageBean
{
    public function __construct($page = 0, $pageSize = null)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new SysImageModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:获取相应类型的图片
     * User: Jenick
     * Date: 2021/1/25
     * Time: 8:13 下午
     */
    public function getSysImageByType()
    {
        $where = [
            'type' => $this->getType(),
            'show' => $this->getShow()
        ];
        $this->model->setField('*, img img_id');
        $this->model->setWhereArr($where);
        $this->model->setOrder('sort desc, id desc');
        $res = $this->model->findAllInfo();
        $res = (new Cos())->getImgUrl($res, 'img');
        return $res;
    }
}