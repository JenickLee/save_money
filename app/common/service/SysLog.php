<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/1/6
 * Time: 17:33
 */

namespace app\common\service;

use app\common\lib\Juhe;
use app\common\model\mysql\{SysLog as SysLogModel};
use app\common\bean\SysLog as SysLogBean;

class SysLog extends SysLogBean
{
    public function __construct($page = 0, $pageSize = 10)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new SysLogModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:保存日志
     * User: Jenick
     * Date: 2020/1/6
     * Time: 17:38
     */
    public function saveSysLog()
    {
        $juhe = new Juhe();
        $res = $juhe->getIpData($this->getIp());
        $res = json_decode($res, true);
        if ($res['resultcode'] == 200 && $res['error_code'] == 0) {
            $data['ip_country'] = $res['result']['Country'];
            $data['ip_province'] = $res['result']['Province'];
            $data['ip_city'] = $res['result']['City'];
            $data['ip_isp'] = $res['result']['Isp'];
        }
        $data['type'] = $this->getType();
        $data['content'] = $this->getContent();
        $data['cby'] = $this->getCby();
        $data['create_time'] = $this->getCreateTime();
        $data['ip'] = $this->getIp();
        return $this->model->insertGetId($data);
    }

    /**
     * Notes:获取系统日志
     * User: Jenick
     * Date: 2020/01/06
     * Time: 20:51
     */
    public function getSysLog()
    {
        $this->model->setOrder(['create_time' => 'desc']);
        return $this->model->findAllInfo();
    }

    /**
     * Notes:获取系统日志数量
     * User: Jenick
     * Date: 2020/9/9
     * Time: 3:14 下午
     */
    public function getSysLogCount()
    {
        return $this->model->getCount();
    }
}