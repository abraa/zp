<?php
namespace app\index\controller;

use app\index\BaseController;
use app\common\support\LoginSupport;

class User extends BaseController
{

    /**
     * 收藏
     */
    public function collection(){
        $position_id = input('position_id');
        if(empty($position_id)){
            $this->error("缺少参数");
        }
        $user_id = LoginSupport::getUserId();
        model('userCollection')->create(['position_id'=>$position_id,'user_id'=>$user_id]);
        //用户消息
        $realname = model('userResume')->where('user_id',$user_id)->value('realname');
        $user = model('companyPosition')->where('id',$position_id)->field('position_name,user_id')->find();
        if(empty($user)){
            $this->error('用户不存在');
        }
        $user =$user->toArray();
        model('msgUser')->create(['user_id'=>$user['user_id'],'title'=>$realname.'收藏了您的职位'.$user['position_name']]);
        $this->success('收藏成功');
    }

    /**
     * 取消收藏
     */
    public function uncollection(){
        $position_id = input('position_id');
        if(empty($position_id)){
            $this->error("缺少参数");
        }
        $user_id = LoginSupport::getUserId();
        model('userCollection')->where(['position_id'=>$position_id,'user_id'=>$user_id])->delete();
        $this->success('取消收藏成功');
    }

    /**
     * 举报
     */
    public function report(){
        $tag_id = input('tag_id');
        $tag_text = input('tag_text');
        $type_id = input('type_id',6);          //用户
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
        model('msgUser')->create(['user_id'=>$user_id,'title'=>'有用户举报了您'.$tag_text]);
        $this->success("举报成功");
    }
}