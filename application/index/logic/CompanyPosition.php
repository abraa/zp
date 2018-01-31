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

    public function _before_save(){
        //公司id
        $this->data['company_id'] = model('company')->where('user_id',LoginSupport::getUserId())->value('id');
    }
}