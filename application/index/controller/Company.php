<?php
namespace app\index\controller;

use app\common\support\LoginSupport;
use app\common\support\LogSupport;
use app\index\BaseController;

class Company extends BaseController
{
    /**
     *  获取指定字段值 QQ,TEL
     */
    public function getValue(){
        $field = input('field');
        $company_id = input('company_id');
        if(empty($field) || empty($company_id)){
            $this->error("缺少参数");
        }
        $res = model('Company')->where('id',$company_id)->value($field);
        $this->success('Success','',[$field=>$res]);
    }

    /**
     * 收藏
     */
    public function collection(){
        $resume_id = input('resume_id');
        if(empty($resume_id)){
            $this->error("缺少参数");
        }
        $user_id = LoginSupport::getUserId();
        model('companyCollection')->create(['resume_id'=>$resume_id,'user_id'=>$user_id]);
        //用户消息
        $companyName = model('company')->where('user_id',$user_id)->value('text');
        $userId = model('userResume')->where('id',$resume_id)->value('user_id');
        LogSupport::userMsg($userId,$companyName.'收藏了您的简历');            //用户消息
        $this->success('收藏成功');
    }

    /**
     * 取消收藏
     */
    public function uncollection(){
        $resume_id = input('resume_id');
        if(empty($resume_id)){
            $this->error("缺少参数");
        }
        $user_id = LoginSupport::getUserId();
        model('companyCollection')->where(['resume_id'=>$resume_id,'user_id'=>$user_id])->delete();
        $this->success('取消收藏成功');
    }

    /**
     * 举报
     */
    public function report(){
        $tag_id = input('tag_id');
        $tag_text = input('tag_text');
        $type_id = input('type_id',5);
        $c_id = input('c_id');                  //职位id,
        $c_name = input('c_name');              //公司名称
        if(!in_array($type_id,[5,6]))           //公司或用户举报
        {
            $this->error('TYPE参数错误');
        }
        if(empty($tag_id) || empty($tag_text) || empty($type_id) || empty($c_id)|| empty($c_name) ){
            $this->error('缺少参数');
        }
        model('report')->create(input('post.'));
        //用户消息
        if(5 == $type_id){      //公司
            $user_id = model('companyPosition')->where('id',$c_id)->value('user_id');
        }else{                  //用户
            $user_id = model('userResume')->where('id',$c_id)->value('user_id');
        }
        LogSupport::userMsg($user_id,'有用户举报了您'.$tag_text);            //用户消息
        $this->success("举报成功");
    }
}