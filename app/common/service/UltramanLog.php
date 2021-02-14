<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/15
 * Time: 7:24 下午
 */

namespace app\common\service;

use app\common\bean\UltramanLog as UltramanLogBean;
use app\common\lib\Date;
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
     * Notes:获取用户当前存款数据
     * User: Jenick
     * Date: 2021/1/28
     * Time: 12:24 下午
     */
    public function getUserDepositBaseDataAnalysis($pUserId)
    {
        $where = [
            ['u.p_user_id', '=', $pUserId],
            ['log.type', 'in', [1, 2]]
        ];
        $this->model->setWhereArr($where);
        $this->model->setField("FROM_UNIXTIME( UNIX_TIMESTAMP( log.create_time ), '%Y-%m-%d' ) date, log.deposit_base value");
        $res = $this->model->getUserDepositBaseDataAnalysis();
//        $newArr = [];
//        for ($i = 0; $i < count($res); $i++) {
//            array_push($newArr, $res[$i]);
//            $startDate =  date('Y-m-d', strtotime($res[$i]['date']) + 86400);
//            $endDate = null;
//            if (!isset($res[$i + 1])) {
//                $endDate = date('Y-m-d');
//            } else if ($startDate != $res[$i + 1]['date']) {
//                $endDate = date('Y-m-d', strtotime($res[$i + 1]['date']) - 86400);
//            }
//
//            if(isset($endDate)){
//                $value = $res[$i]['value'];
//                $dateArr = Date::getDateByInterval($startDate, $endDate);
//                foreach ($dateArr as $vo) {
//                    array_push($newArr, ['date' => $vo, 'value' => $value]);
//                }
//            }
//        }
        return $res;
    }
}