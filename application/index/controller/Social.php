<?php
namespace app\index\controller;

use app\common\support\LoginSupport;
use app\index\BaseController;

class Social extends BaseController
{

    public function request(){
        $title = input('title',null,'trim');
        $content = input('content',null,'trim');
        $user_id = LoginSupport::getUserId();
        if(empty($title)){
            $this->error('内容不能为空');
        }
        model('SocialR')->create(['title'=>$title,'content'=>$content,'user_id'=>$user_id]);
        $this->success('Success');
    }

    /**
     * 回复
     */
    public function reply(){
        $rid = input('r_id');
        $user_id = LoginSupport::getUserId();
        $content = input('content',null,'trim');
        if(empty($content) ||empty($rid)){
            $this->error("内容不能为空");
        }
        model('SocialA')->create(['r_id'=>$rid,'content'=>$content,'user_id'=>$user_id]);
        $this->success('Success');
    }

    /**
     * 点赞
     */
    public function approval(){
        $rid = input('r_id');
        $user_id = LoginSupport::getUserId();
        $res = model('socialApproval')->where('r_id',$rid)->where('user_id',$user_id)->find();
        if(!$res){
            model('socialApproval')->create(['r_id'=>$rid,'user_id'=>$user_id]);
        }
        $this->success('已赞赏');
    }

    /**
     * 回复删除
     */
    public function replyDelete(){
        $aid = input('id');
        $user_id = LoginSupport::getUserId();
        if(empty($aid)){
            $this->error("请指定删除内容");
        }
        $res = model('SocialA')->where(['id'=>$aid,'user_id'=>$user_id])->delete();
        if($res){
            $this->success('Success');
        }else{
            $this->error('删除失败');
        }

    }
}