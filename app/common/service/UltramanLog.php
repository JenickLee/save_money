<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/15
 * Time: 7:24 下午
 */

namespace app\common\service;

use app\common\bean\UltramanLog as UltramanLogBean;
use app\common\model\mysql\{UltramanLog as UltramanLogModel};

class UltramanLog extends UltramanLogBean
{
    public function __construct($page = 0, $pageSize = null)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new UltramanLogModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }
}