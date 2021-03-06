<?php
namespace app\index\model;

use app\index\BaseModel;

class SocialApproval extends BaseModel
{
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
        $this->where($where);
    }
}