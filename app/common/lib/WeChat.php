<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/01/05
 * Time: 09:16
 */

namespace app\common\lib;


class WeChat extends Base
{
    //AppID
    private $appID;
    //AppSecret
    private $appSecret;
    //AccessToken
    private $accessToken = '';

    public function __construct($appID = '', $appSecretp = '')
    {
        if (!empty($appID) && !empty($appSecretp)) {
            $this->appID = $appID;
            $this->appSecret = $appSecretp;
        } else {
            $this->appID = config('wechat.app_id');
            $this->appSecret = config('wechat.app_secret');
        }
        $this->accessToken = $this->getAccessToken();
    }

    /**
     * Notes:微信小程序登录凭证校验
     * User: Jenick
     * Date: 2020/01/05
     * Time: 09:18
     * @param String $code
     * @param string $grant_type
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function getJscode2session(String $code, $grant_type = 'authorization_code')
    {
        if (empty($code)) {
            return false;
        }
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$this->appID}&secret={$this->appSecret}&js_code={$code}&grant_type={$grant_type}";
        try {
            $res = Curl::curlGetContents($url);
            $res = json_decode($res, true);
            return $res;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Notes:获取AccessToken
     * User: Jenick
     * Date: 2020/01/05
     * Time: 09:17
     */
    private function getAccessToken()
    {
        $accessToken = cache("accessToken_{$this->appID}");
        if (isset($accessToken)) {
            return $accessToken;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appSecret}";
        $html = file_get_contents($url);
        $res = json_decode($html, true);
        if (isset($res['access_token'])) {
            cache("accessToken_{$this->appID}", $res['access_token'], ['expire' => 7200]);
            return $res['access_token'];
        }
        return '';
    }

    /**
     * Notes:发送订阅消息
     * User: Jenick
     * Date: 2020/8/13
     * Time: 1:15 下午
     */
    public function sendSubscribeMessage($touser, $templateId, $arr, $page = null)
    {
        try {
            $url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token={$this->accessToken}";
            $data['touser'] = $touser;
            $data['template_id'] = $templateId;
            if (isset($page)) {
                $data['page'] = $page;
            }
            $data['data'] = $arr;
            $res = Curl::curlPostContents($url, json_encode($data, JSON_UNESCAPED_UNICODE));
            return json_decode($res, true);
        } catch (\Exception $e) {
            return false;
        }
    }
}