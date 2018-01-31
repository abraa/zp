<?php
namespace app\index\controller;

use app\index\BaseController;

class Tag extends BaseController
{

    /**
     * 获取tagType list
     */
    public function getTagType(){
       $result = model('tagType')->where('locked',0)->getAll();
        $this->success('Success','',$result);
    }

    public function getTagList(){
       $result =  model('tag')->where('locked',0)->getAll();
        $arr = [];
        foreach($result as $item){
            if(!isset($arr[$item['type_id']])) $arr[$item['type_id']] = [];
            $arr[$item['type_id']][] = $item;
        }
        $this->success('Success','',$arr);
    }
}