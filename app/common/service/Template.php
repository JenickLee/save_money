<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/8/13
 * Time: 2:41 下午
 */
namespace app\common\service;

use app\common\model\mysql\Template as TemplateModel;
use app\common\bean\Template as TemplateBean;


class Template extends TemplateBean
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new TemplateModel();
    }
}