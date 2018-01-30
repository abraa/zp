<?php
namespace app\index\model;

use app\index\BaseModel;

class MsgUser extends BaseModel
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
        $this->where($where);
    }
}