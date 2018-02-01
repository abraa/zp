<?php
namespace app\index\model;

use app\index\BaseModel;

class SocialR extends BaseModel
{

    public function socialA(){
       return $this->hasMany('SocialA','r_id')->field('r_id,content')->view('WechatUser','nickname','user_id = WechatUser.id');
    }

    public function SocialApproval(){
       return $this->hasMany('SocialApproval','r_id');
    }

    public function filter($params)
    {
        $where = [];
        if(isset($params['id'])){
            $where['id'] = $params['id'];
        }
        if(isset($params['user_id'])){
            $where['user_id'] = $params['user_id'];
        }
        if(isset($params['r_id'])){
            $where['r_id'] = $params['r_id'];
        }
        $this->order(['update_time'=>'desc']);
        $this->with('socialA');
        $this->where($where);
        $this->withCount('SocialApproval');
    }


}