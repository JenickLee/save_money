<?php
declare (strict_types=1);

namespace app\api\controller;

use app\common\lib\Page;
use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 * User: Jenick
 * Date: 2020/1/3
 * Time: 13:45
 */
abstract class Base
{
    public $obj;
    //user_id
    public $userId = null;
    //页码
    public $page = 0;
    //数量
    public $pageSize = 30;
    //响应数据
    public $response = [];
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $this->app->request;
        $this->userId = $this->app->request->userId;
        $params = $this->request->param();
        $pageOpt = Page::getPage(intval($params['page'] ?? $this->page), intval($params['pageSize'] ?? $this->pageSize));
        $this->page = $pageOpt['page'];
        $this->pageSize = $pageOpt['pageSize'];
        $this->response['page'] = $this->page;
        $this->response['pageSize'] = $this->pageSize;
        // 控制器初始化
        $this->initialize();


    }

    // 初始化
    protected function initialize()
    {
    }

    /**
     * 验证数据
     * @access protected
     * @param array $data 数据
     * @param string|array $validate 验证器名或者验证规则数组
     * @param array $message 提示信息
     * @param bool $batch 是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

}
