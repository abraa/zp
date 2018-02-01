<?php
namespace app\index\logic;

use app\common\support\LoginSupport;
use app\common\support\LogSupport;
use app\index\BaseLogic;
use app\common\support\UploadSupport;

class User extends BaseLogic
{
    protected $modelName = 'UserResume';

    public function format($data){
        $result = isset($data['row']) ? $data['row'] : [$data];
        $tagId = array_merge(array_column($result,'salary'),array_column($result,'education'),array_column($result,'experience'));      //薪水.工作经验.学历
        $tag = db('tag')->whereIn('id',$tagId)->column('id,text');
        $resume_id = array_column($result,'id');                                                                                        //是否收藏
        $collection = db('companyCollection')->whereIn('resume_id',$resume_id)->where('user_id',LoginSupport::getUserId())->column('resume_id,id');
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
        if(empty($result)) return null;
        $tagId = [$result['salary'],$result['education'],$result['experience']];      //薪水.工作经验.学历
        $tag = db('tag')->whereIn('id',$tagId)->column('id,text');
        $result['salary_text'] = $tag[$result['salary']];
        $result['education_text'] = $tag[$result['education']];
        $result['experience_text'] = $tag[$result['experience']];
        $resume_id = $result['id'];                                                                                        //是否收藏
        $collection = db('companyCollection')->whereIn('resume_id',$resume_id)->where('user_id',LoginSupport::getUserId())->column('resume_id,id');
        if(isset($collection[$result['id']])){
            $result['collection'] = 1;
        }else{
            $result['collection'] = 0;
        }
        //工作和学习经历
        $res = db('userSchool')->where('resume_id',$resume_id)->field('id,start_time,end_time,text,school')->select();
        $result['school'] = collection($res)->toArray();
        $res = db('userWork')->where('resume_id',$resume_id)->field('id,start_time,end_time,text,company')->select();
        $result['work'] = collection($res)->toArray();
        if($result['user_id'] <> LoginSupport::getUserId()){
            unset($result['qq']);                   //去掉qq和电话
            unset($result['tel']);
            //被浏览
            $company = db('company')->where('user_id',LoginSupport::getUserId())->field('id,text')->find();
            $company_id = isset($company->id) ? $company->id : null;
            $company_name = isset($company->text) ? $company->text : null;
            if(!empty($company_id) && !model('userCompany')->where(['user_id'=>$result['user_id'],'company_id'=>$company_id])->count()){
                model('userCompany')->create(['user_id'=>$result['user_id'],'company_id'=>$company_id]);
                LogSupport::userMsg($result['user_id'],$company_name.'浏览了您的简历');            //用户消息
//                model('msgUser')->create(['user_id'=>$result['user_id'],'title'=>$company_name.'浏览了您的简历']);
            }
        }
        return $result;
    }

    public function _before_save(){
        //图片处理
        if(isset($this->data['thumb'])){
            $this->data['thumb'] = UploadSupport::base64SaveImage($this->data['thumb']);
        }
        //职位信息
        if(isset($this->data['position_tag'])){
            $res = db('tag')->whereIn('id',$this->data['position_tag'])->where('type_id',1)->column('text');
            $this->data['position_name'] = implode(',',$res);
        }
    }

    public function _after_save(){
        //是否有工作和学习
        if(!empty($this->data['school'])){
             $this->dbModel->school()->saveAll($this->data['school']);
        }
        if(!empty($this->data['work'])){
            $this->dbModel->school()->saveAll($this->data['work']);
        }
        //检查公司资料是否已经填写
        $res =  db('company')->where('user_id',LoginSupport::getUserId())->find();
        if(empty($res) || empty($res->text) || empty($res->tel)){
            $this->success("请完善公司资料",'',['code'=>'COMPANY_NOT_PERFECT']);
        }
    }
}