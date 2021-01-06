<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/6
 * Time: 5:05 下午
 */

namespace app\common\service;

use app\common\bean\Ultraman as UltramanBean;
use app\common\model\mysql\Ultraman as UltramanModel;

class Ultraman extends UltramanBean
{
    public function __construct($page = 0, $pageSize = 10)
    {
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new UltramanModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    public function getList()
    {
        $field =  "u.id uid, DATE_FORMAT(y.start_time,'%Y') as '年度', user.username, u.deposit_base, u.aims,(u.aims - u.deposit_base) as difference, if((truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2) > 0),truncate(((`u`.`deposit_base` / `u`.`aims`) * 100),2),0.00) as schedule";
        $this->model->setField($field);
        $res = $this->model->findAllInfoJoinUser();
        return $res;
    }
}