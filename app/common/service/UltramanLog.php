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

    /**
     * Notes:获取用户当前基数数据
     * User: Jenick
     * Date: 2021/1/28
     * Time: 12:24 下午
     */
    public function getUserDepositBaseDataAnalysis($pUserId)
    {
        $where = [
            ['u.p_user_id', '=', $pUserId],
            ['log.type', 'in', [1, 2]],
            ['log.create_time', '>=', date('Y-01-01 00:00:00')],
            ['log.create_time', '<=', date('Y-12-31 23:59:59')]
        ];
        $this->model->setWhereArr($where);
        $this->model->setField('log.create_time date, log.deposit_base value');
        return $this->model->findAllInfoJoinUltraman();
    }
}