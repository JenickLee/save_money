<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2020/8/13
 * Time: 1:50 下午
 */

namespace app\common\service;

use app\common\lib\Str;
use app\common\lib\WeChat;
use app\common\model\mysql\SubscriptionMessage as SubscriptionMessageModel;
use app\common\bean\SubscriptionMessage as SubscriptionMessageBean;

class SubscriptionMessage extends SubscriptionMessageBean
{
    public function __construct($page = 0, $pageSize = 10)
    {
        parent::__construct();
        $this->setOffset($page * $pageSize);
        $this->setLimit($pageSize);
        $this->model = new SubscriptionMessageModel();
        $this->model->setOffset($this->getOffset());
        $this->model->setLimit($this->getLimit());
    }

    /**
     * Notes:新增订阅消息
     * User: Jenick
     * Date: 2020/8/13
     * Time: 1:56 下午
     * @return int
     * @throws \Exception
     */
    public function addSubscribeMessage()
    {
        $i = 0;
        foreach ($this->getCode() as $vo) {
            $data[$i]['user_id'] = $this->getUserId();
            $data[$i]['code'] = $vo;
            $data[$i]['create_time'] = date('Y-m-d H:i:s');
            $i++;
        }
        $res = $this->model->insertAll($data);
        if (!$res) {
            throw new \Exception('新增失败');
        }
        return $res;
    }

    /**
     * Notes:获取有效订阅消息数
     * User: Jenick
     * Date: 2020/8/13
     * Time: 4:46 下午
     * @return int
     */
    public function getSubscribeMessageCountByCode()
    {
        $where['sent_content'] = null;
        $where['code'] = $this->getCode();
        $where['user_id'] = $this->getUserId();
        $this->model->setWhereArr($where);
        return $this->model->getCount();
    }

    /**
     * Notes:发送百度ID审核提醒
     * User: Jenick
     * Date: 2021/2/4
     * Time: 11:38 下午
     */
    public function sendBaiduIdReviewReminder($numbering, $content, $remarks = null)
    {
        $where['s.sent_content'] = null;
        $where['s.code'] = 'baidu_id_review_reminder';
        $where['s.user_id'] = $this->getUserId();
        $this->model->setField('s.id, s.code, u.openid, t.status, t.template_id');
        $this->model->setWhereArr($where);
        $this->model->setGroup('s.user_id');
        $temlate = $this->model->findOneInfoJoinUserAndTemlate();
        $weChat = (new WeChat());
        if ($temlate) {
            if (strlen($numbering) > 32) {
                $numbering = Str::cutStr($numbering, 29, 0, 'UTF-8') . '...';
            }
            if (strlen($content) > 20) {
                $content = Str::cutStr($content, 17, 0, 'UTF-8') . '...';
            }
            if (!empty($remarks) && strlen($remarks) > 20) {
                $remarks = Str::cutStr($remarks, 17, 0, 'UTF-8') . '...';
            }
            $data['character_string5']['value'] = $numbering;
            $data['thing2']['value'] = $content;
            $data['thing4']['value'] = $remarks ?? '  ';
            $page = "admin/pages/binding/index";
            $weChat->sendSubscribeMessage($temlate['openid'], $temlate['template_id'], $data, $page);

            $this->model->setArr(['sent_content' => json_encode($data), 'send_time' => date('Y-m-d H:i:s')]);
            $this->model->setId($temlate['id']);
            $this->model->useIdUpdateData();
        }
    }


    /**
     * Notes:发送百度ID审核结果通知
     * User: Jenick
     * Date: 2021/2/4
     * Time: 11:38 下午
     */
    public function sendBaiduIdReviewNotice($auditType, $applicant, $approvalResults, $remarks = null)
    {
        $where['s.sent_content'] = null;
        $where['s.code'] = 'baidu_id_review_notice';
        $where['s.user_id'] = $this->getUserId();
        $this->model->setField('s.id, s.code, u.openid, t.status, t.template_id');
        $this->model->setWhereArr($where);
        $this->model->setGroup('s.user_id');
        $temlate = $this->model->findOneInfoJoinUserAndTemlate();
        $weChat = (new WeChat());
        if ($temlate) {
            if (strlen($auditType) > 20) {
                $auditType = Str::cutStr($auditType, 17, 0, 'UTF-8') . '...';
            }
            if (strlen($applicant) > 20) {
                $applicant = Str::cutStr($applicant, 17, 0, 'UTF-8') . '...';
            }
            if (strlen($approvalResults) > 5) {
                $approvalResults = Str::cutStr($approvalResults, 5, 0, 'UTF-8');
            }
            if (!empty($remarks) && strlen($remarks) > 20) {
                $remarks = Str::cutStr($remarks, 17, 0, 'UTF-8') . '...';
            }
            $data['thing1']['value'] = $auditType;
            $data['thing3']['value'] = $applicant;
            $data['phrase4']['value'] = $approvalResults;
            $data['time5']['value'] = date('Y-m-d H:i:s');
            $data['thing6']['value'] = $remarks ?? ' ';
            $page = "pages/index/index";
            $weChat->sendSubscribeMessage($temlate['openid'], $temlate['template_id'], $data, $page);

            $this->model->setArr(['sent_content' => json_encode($data), 'send_time' => date('Y-m-d H:i:s')]);
            $this->model->setId($temlate['id']);
            $this->model->useIdUpdateData();
        }
    }
}