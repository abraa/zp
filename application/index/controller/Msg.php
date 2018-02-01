<?php
namespace app\index\controller;

use app\common\support\LoginSupport;
use app\index\BaseController;

class Msg extends BaseController
{
    public function feedback(){
        $title = input('title');
        $content = input('content');
        $user_id = LoginSupport::getUserId();
        model('MsgFeedback')->create(['title'=>$title,'content'=>$content,'user_id'=>$user_id]);
        $this->success('提交成功');
    }
}