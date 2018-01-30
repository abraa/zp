<?php
namespace app\index\model;

use app\index\BaseModel;


class CompanyCollection extends BaseModel
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
        if(isset($params['resume_id'])){
            $where['resume_id'] = $params['resume_id'];
        }
        $this->where($where);
    }
}