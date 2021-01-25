<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/7/23
 * Time: 5:31 ????
 */

namespace app\common\lib;


class Cos extends Base
{
    //当前时间戳
    private $time;
    //token
    private $token;
    //appid
    private $appid;
    //key
    private $key;
    //拼接符
    private $stitching_symbol;
    //上传文件
    private $uploadByFileUrl = 'https://cos.phpcgi.net/uploadByFileUrl';
    //获取文件链接
    private $getFileUrls = 'https://cos.phpcgi.net/getFileUrls';
    //软删除文件
    private $delFileUrls = 'https://cos.phpcgi.net/delFile';
    //修改文件信息
    private $editFileInfoUrl = 'https://cos.phpcgi.net/editFileInfo';

    public function __construct()
    {
        $this->appid = config('config.cos_appid');
        $this->key = config('config.cos_key');
        $this->stitching_symbol = config('config.cos_stitching_symbol');
    }

    /**
     * Notes:
     * User: Jenick
     * Date: 2020/7/23
     * Time: 6:37 ????
     * @param $file
     * @param array $param
     * @param int $serverNum
     * @return mixed
     */
    public function uploadByFileUrl($file, $param = [], $serverNum = 1)
    {
        $data = $this->_getToken();
        $data['file'] = $file;
        $data['folder'] = $param['folder'] ?? 'upload';
        $data['server_num'] = $serverNum;
        $data['file_type'] = $param['file_type'] ?? 'IMG';
        $data['data_class'] = $param['data_class'] ?? 'SYS';
        $data['topic'] = $param['topic'] ?? 'topic';
        $data['title'] = $param['title'] ?? '默认标题';
        $data['suffix'] = $param['suffix'];
        $res = Curl::curlPostContents($this->uploadByFileUrl, $data);
        return json_decode($res, true);
    }

    /**
     * Notes:
     * User: Jenick
     * Date: 2020/9/13
     * Time: 12:37 上午
     * @param $id
     * @param string $title
     * @param string $dataClass
     * @param string $topic
     * @return mixed
     */
    public function editFileInfo($id, $title = '默认标题', $dataClass = 'SYS', $topic = 'topic')
    {
        $data = $this->_getToken();
        $data['id'] = $id;
        $data['data_class'] = $dataClass;
        $data['topic'] = $topic;
        $data['title'] = $title;
        $res = Curl::curlPostContents($this->editFileInfoUrl, $data);
        return json_decode($res, true);
    }

    /**
     * Notes:
     * User: Jenick
     * Date: 2020/7/23
     * Time: 6:37 ????
     */
    public function getFileUrls($fileId)
    {
        $data = $this->_getToken();
        $data['id'] = $fileId;
        $res = Curl::curlPostContents($this->getFileUrls, $data);
        return json_decode($res, true);
    }

    /**
     * Notes:
     * User: Jenick
     * Date: 2020/7/23
     * Time: 6:37 ????
     */
    public function delFile($fileId)
    {
        $data = $this->_getToken();
        $data['id'] = $fileId;
        $res = Curl::curlPostContents($this->delFileUrls, $data);
        return json_decode($res, true);
    }


    /**
     * Notes:转换成ULR
     * User: Jenick
     * Date: 2020/9/9
     * Time: 5:37 下午
     * @param $res
     * @param string $key
     * @return array
     */
    public function getImgUrl($res, $key = 'img', $many = false)
    {
        if (empty($res)) return $res;
        $arrType = count($res) == count($res, 1);
        $fileIds = ($arrType) ? $res[$key] : implode(',', array_filter(array_column($res, $key)));
        $cos = new Cos();
        $result = $cos->getFileUrls($fileIds);
        if ($result['code'] == 200) {
            $result = array_column($result['data'], 'url', 'id');
            if ($arrType) {
                $res[$key] = $result[$res[$key]];
            } else if ($many) {
                foreach ($res as &$vo) {
                    $value = explode(',', $vo[$key]);
                    $urls = [];
                    foreach ($value as &$v) {
                        if (isset($result[$v])) {
                            array_push($urls, $result[$v]);
                        }
                    }
                    $vo[$key] = $urls;
                }
            } else {
                foreach ($res as &$vo) {
                    if (isset($result[$vo[$key]])) $vo[$key] = $result[$vo[$key]];
                }
            }
        }

        return $res ?? [];
    }

    /**
     * Notes:获取Token
     * User: Jenick
     * Date: 2021/1/25
     * Time: 8:29 下午
     */
    private function _getToken()
    {
        $data['time'] = time();
        $arr = [
            $data['time'],
            $this->appid,
            $this->key
        ];
        $data['token'] = md5(implode($this->stitching_symbol, $arr));
        $data['appid'] = $this->appid;
        return $data;
    }
}