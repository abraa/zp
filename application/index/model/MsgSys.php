<?php
namespace app\index\model;

use app\index\BaseModel;

class MsgSys extends BaseModel
{
    public function filter($params)
    {
        $where = [];
        if(isset($params['id'])){
            $where['id'] = $params['id'];
        }
        if(isset($params['user_id'])){
            $where['user_id'] = ['in',[$params['user_id'],0]];
        }else{
            $where['user_id'] = 0;                              //0面向所有用户
        }
        $this->where($where);
    }
}