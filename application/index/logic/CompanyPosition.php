<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/28
 * Time: 22:26
 */

namespace app\index\logic;

use app\common\support\LoginSupport;
use app\index\BaseLogic;

class CompanyPosition extends BaseLogic
{
    public function format($data){
        $result = isset($data['row']) ? $data['row'] : [$data];
        $tagId = array_merge(array_column($result,'salary'),array_column($result,'education'),array_column($result,'experience'));
        $tag = db('tag')->whereIn('id',$tagId)->column('id,text');
        $position_id = array_column($result,'id');
        $collection = db('userCollection')->whereIn('position_id',$position_id)->where('user_id',LoginSupport::getUserId())->column('position_id,id');
        foreach($result as &$item){
            if(isset($collection[$item['id']])){
                $item['collection'] = 1;
            }else{
                $item['collection'] = 0;
            }
            $item['salary_text'] = $tag[$item['salary']];
            $item['education_text'] = $tag[$item['education']];
            $item['experience_text'] = $tag[$item['experience']];
        }
        if(isset($data['row'])){
            $data['row'] = $result;
        }else{
            $data = $result[0];
        }
        return $data;
    }

    public function _after_info($result){
        $tagId = [$result['salary'],$result['education'],$result['experience']];      //薪水.工作经验.学历
        $tag = db('tag')->whereIn('id',$tagId)->column('id,text');
        $position_id = $result['id'];                                                       //用户收藏
        $collection = db('userCollection')->whereIn('position_id',$position_id)->where('user_id',LoginSupport::getUserId())->column('position_id,id');
        if(isset($collection[$result['id']])){
            $result['collection'] = 1;
        }else{
            $result['collection'] = 0;
        }
        $result['salary_text'] = $tag[$result['salary']];
        $result['education_text'] = $tag[$result['education']];
        $result['experience_text'] = $tag[$result['experience']];
        // 浏览 --排除自己
        if($result['user_id'] <> LoginSupport::getUserId()){
            if(!model('userPosition')->where(['user_id'=>LoginSupport::getUserId(),'position_id'=>$result['id']])->count()){
                model('userPosition')->create(['user_id'=>LoginSupport::getUserId(),'position_id'=>$result['id']]);
//                model('msgUser')->create(['user_id'=>$result['user_id'],'title'=>'有新用户浏览了您的职位信息']);    //用户消息
            }
        }
        return $result;
    }

    public function _before_save(){
        //公司id
        $this->data['company_id'] = model('company')->where('user_id',LoginSupport::getUserId())->value('id');
        //职位信息
        if(isset($this->data['position_tag'])){
            $res = db('tag')->whereIn('id',$this->data['position_tag'])->where('type_id',1)->column('text');
            $this->data['position_name'] = implode(',',$res);
        }
    }

    public function _after_save(){
        //检查公司资料是否已经填写
        $res =  db('company')->where('user_id',LoginSupport::getUserId())->find();
        if(empty($res) || empty($res->text) || empty($res->tel)){
            $this->success("请完善公司资料",'',['code'=>'COMPANY_NOT_PERFECT']);
        }
    }
}