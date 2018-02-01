<?php
namespace app\index\logic;

use app\index\BaseLogic;

class Social extends BaseLogic
{
    protected $modelName = 'SocialR';

    function format($data){

        return $data;
    }


    /**
     * @return bool
     */
    public function _before_delete(){
        if(!isset($this->data['id'])){      //无主键不删除
            $this->err = '缺少参数';
            return false;
        }
    }

    public function _after_delete(){
        //回复点赞全删
        $r_id = $this->data['id'];
        db('socialA')->where('r_id',$r_id)->delete();
        db('socialApproval')->where('r_id',$r_id)->delete();
    }
}