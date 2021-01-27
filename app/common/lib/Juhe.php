<?php
/**
 * 聚合数据
 * User: Jenick
 * Date: 2020/01/04
 * Time: 23:03
 */
namespace app\common\lib;


class Juhe extends Base
{
    private $key;

    /**
     * Notes:获取ip信息
     * User: Jenick
     * Date: 2020/01/04
     * Time: 23:22
     * @param String $ip ip地址
     * @return bool|string
     */
    public function getIpData(String $ip)
    {
        $this->key = config('juhe.ip_app_key');
        $url = "http://apis.juhe.cn/ip/ipNew?ip={$ip}&key={$this->key}";
        $res = Curl::curlGetContents($url);
        return $res;
    }

    /**
     * Notes:搜集网络幽默、搞笑、内涵段子，不间断更新
     * User: Jenick
     * Date: 2019/10/04
     * Time: 18:55
     * @param int $type  1 - 按更新时间查询笑话 2 - 最新笑话 默认 - 随机获取笑话
     * @param int $page 当前页数,默认1,最大20
     * @param int $pageSize 每次返回条数,默认1,最大20
     * @param string $sort 类型，desc:指定时间之前发布的，asc:指定时间之后发布的
     * @param int $time 时间戳（10位），如：1418816972
     * @return bool|string
     */
    public function getJokes(int $type = 3,int  $page = 1, int $pageSize = 10, $sort = 'asc', int $time = 0)
    {
        $this->key = config('juhe.joke_app_key');
        switch ((int) $type)
        {
            case 1:
                $time = $time??time();
                $url = "http://v.juhe.cn/joke/content/list.php?key={$this->key}&page={$page}&pagesize={$pageSize}&sort={$sort}&time={$time}";
                break;
            case 2:
                $url = "http://v.juhe.cn/joke/content/text.php?key={$this->key}&page={$page}&pagesize={$pageSize}";
                break;
            default:
                $url = "http://v.juhe.cn/joke/randJoke.php?&key={$this->key}";
                break;
        }

        $res = Curl::curlGetContents($url);
        return $res;
    }

    /**
     * Notes:获取手机号归属地
     * User: Jenick
     * Date: 2020/01/04
     * Time: 23:45
     * @param String $phone
     * @return bool|string
     */
    public function getPhoneAttribution(String $phone)
    {
        $this->key = config('juhe.phone_app_key');
        $url = "http://apis.juhe.cn/mobile/get?phone={$phone}&key={$this->key}";
        $res = Curl::curlGetContents($url);
        return $res;
    }
}