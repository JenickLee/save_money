<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/25
 * Time: 8:06 下午
 */
namespace app\api\controller;

use app\common\lib\Response;
use app\common\service\SysImage as SysImageService;
use think\App;

class SysImage extends Base
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->obj = new SysImageService($this->page, $this->pageSize);
    }

    /**
     * Notes:获取奥特曼Banner图
     * User: Jenick
     * Date: 2021/1/25
     * Time: 8:09 下午
     */
    public function getUltramanBanner()
    {
        $this->obj->setShow(config('config.sys_image_show'));
        $this->obj->setType(config('config.ultraman_banner_type'));
        try {
            $res = $this->obj->getSysImageByType();
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}