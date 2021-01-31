<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/23
 * Time: 3:43 下午
 */

namespace app\admin\controller;

use app\common\lib\Response;
use think\Validate;
use app\common\service\{
    UltramanLog as UltramanLogService,
    User as UserService,
    PostItUser as PostItUserService
};

class DataAnalysis extends Base
{
    /**
     * Notes:用户新增人数统计
     * User: Jenick
     * Date: 2021/1/23
     * Time: 3:43 下午
     */
    public function getAddUserDataAnalysis()
    {
//        $data = [
//            time(),
//           '5823185398',
//            '76b58be3f0ab729bf300384b3b28d235'
//        ];
//        // token检验
//        $data['token'] = md5(implode('&&', $data));
//        dump($data);
        try {
            $this->obj = new UserService(0, null);
            $res = $this->obj->getAddUserDataAnalysis();
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }

    /**
     * Notes:贴吧ID新增人数统计
     * User: Jenick
     * Date: 2021/1/23
     * Time: 3:43 下午
     */
    public function getAddPostItUserDataAnalysis()
    {
        try {
            $this->obj = new PostItUserService(0, null);
            $res = $this->obj->getAddPostItUserDataAnalysis();
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }

    /**
     * Notes:获取用户当前存款数据
     * User: Jenick
     * Date: 2021/1/28
     * Time: 12:22 下午
     */
    public function getUserDepositBaseDataAnalysis()
    {
        $param = input('post.');
        $validate = new Validate();
        $rule['p_user_id'] = 'require';
        if (!$validate->check($param, $rule)) {
            return Response::error(config('code.params_invalid'), $validate->getError());
        }
        try {
            $this->obj = new UltramanLogService();
            $res = $this->obj->getUserDepositBaseDataAnalysis($param['p_user_id']);
            return Response::success($res);
        } catch (\Exception $e) {
            return Response::error(config('code.error'), $e->getMessage());
        }
    }
}