<?php
namespace app\index\controller;

use app\common\support\LoginSupport;
use app\common\support\UploadSupport;
use app\index\BaseController;
use extend\WeChatSmall;

class Index extends BaseController
{
    public function index()
    {

    }

    /**
     * 登录
     */
    public function login(){

        //1。根据openid获取用户数据
        $code = input('code');
        WeChatSmall::init(config('wechatsmall'));
        $data = WeChatSmall::authorizationCode($code);
        if(empty($data)){
            $this->error('Code失效，登陆失败!');
        }
        $openId = $data['openid'];
        session('openid',$data['openid']);
        session('sessionKey',$data['session_key']);
        session('unionid',$data['unionid']);
        //2.用户不存在时添加用户
        $wechatuserModel= model('WechatUser');
        $user = $wechatuserModel->getRow(['openid'=>$openId]);
        if(empty($user)){
            $wechatuserModel->create(['openid'=>$openId,'unionid'=>$data['unionid']]);
            $userId = $wechatuserModel->getLastInsID();
            $data['user_id'] = $userId;
        }else{
            $data['user_id'] = $user['id'];
        }
        LoginSupport::login($data);
        //3返回成功
        $this->success('登录成功');
    }


    /**
     *  更新微信用户信息
     */
    public function updateUserinfo(){
        $iv = input('iv');
        $encryptedData = input('encryptedData');
        WeChatSmall::init(config('wechatsmall'));
        WeChatSmall::$sessionKey = LoginSupport::getUserInfo('session_key');
        $data = WeChatSmall::decryptData($encryptedData, $iv);
        if(empty($data)){
            $this->error('解析失败,请重新登录');
        }
        $wechatuserModel= model('WechatUser');
        $wechatuserModel->Update($data,['openid'=>$data['openid']]);
        $this->success('更新资料成功');
    }

    /**
     * 上传文件 返回文件路径
     */
    public function upload(){
        LoginSupport::getUserId();  //检查用户是否登录
        $res = UploadSupport::upload();
        if(!$res){
            $this->error('上传失败');
        }else{
            $this->success('上传成功','',$res);
        }
    }

}
