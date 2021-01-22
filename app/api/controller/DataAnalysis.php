<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/23
 * Time: 12:56 上午
 */

namespace app\api\controller;


use app\common\lib\Response;
use app\common\service\Ultraman as UltramanService;
use think\Validate;

class DataAnalysis extends Base
{
    /**
     * Notes:获取奥特曼数据统计
     * User: Jenick
     * Date: 2021/1/23
     * Time: 12:59 上午
     */
    public function getUltramanDataAnalysis()
    {
        $param = input('get.');
        $validate = new Validate();
        $rule['analysis_item'] = 'require';//1-当前基数 2-目标 3-完成率
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }
        try {
            $this->obj = new UltramanService();
            switch ($param['analysis_item']) {
                case 1:
                    $res = $this->obj->getDataAnalysisByDepositBase();
                    break;
                case 2:
                    $res = $this->obj->getDataAnalysisByAims();
                    break;
                case 3:
                    $res = $this->obj->getDataAnalysisBySchedule();
                    break;
            }
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}