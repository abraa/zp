<?php
namespace app\index\logic;

use app\common\support\UploadSupport;
use app\index\BaseLogic;

class Company extends BaseLogic
{

    /**
     * 格式化处理结果
     * @param $data
     * @return mixed
     */
    public function format($data)
    {
        return $data;
    }

    public function _before_save(){
        //图片处理
        if(isset($this->data['logo'])){
            $this->data['logo'] = UploadSupport::base64SaveImage($this->data['logo']);
        }
        if(isset($this->data['thumb'])){
            $this->data['thumb'] = UploadSupport::base64SaveImage($this->data['thumb']);
        }
        if(isset($this->data['license'])){
            $this->data['audit'] = 0;                                  //上传执照需要重新认证
            $this->data['license'] = UploadSupport::base64SaveImage($this->data['license']);
        }
    }

}