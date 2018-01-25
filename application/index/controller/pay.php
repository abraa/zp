<?php
 /**
 * ====================================
 * thinkphp5
 * ====================================
 * Author: 1002571
 * Date: 2018/1/22 16:29
 * ====================================
 * File: pay.php
 * ====================================
 */

namespace app\index\controller;

use aggregation\pay\AlipayPagePay;
use aggregation\pay\Tenpay;
use aggregation\pay\WeChatNative;
use app\index\BaseController;


class Pay extends BaseController{

    protected $pay;

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 微信扫码支付
     */
    public function weChatNative(){
        $this->pay = new WeChatNative();
        $config = config('wechat');
        $config['notify_url'] = url('weChatNativeNotify','',true,true);
//        print_r($this->pay->setup());             //需要填写的内容
         $this->pay->init($config);
//        $url = $res->getCode(['product_id'=>8888]);         //模式一 后台预定义产品生成二维码
        $url = $this->pay->getCode(['body'=>'测试',
            'out_trade_no' =>   212352153513,            //商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。详见商户订单号
            'total_fee' =>   30,            //订单总金额，单位为分，详见支付金额
            'trade_type' =>   'NATIVE',            //交易类型 取值如下：JSAPI，NATIVE，APP等
            'product_id' =>   '33',            //产品id
        ]);         //模式二 统一下单
        header( "Content-type: image/jpeg");
        echo $this->pay->getQrCode($url);       //二维码图片
        exit;
    }

    /**
     *  微信扫码支付回调通知地址
     */
    public function weChatNativeNotify(){
        $this->pay = new WeChatNative();
        $this->pay->init(config('wechat'));
        if($this->pay->verify()){         //验证通过
            //TODO...
//       $query_result =  $this->queryOrder($result);           //查询订单
//        if(array_key_exists("return_code", $query_result)
//            && array_key_exists("result_code", $query_result)
//            && $query_result["return_code"] == "SUCCESS"
//            && $query_result["result_code"] == "SUCCESS")
//        {
//            return $result;
//        }else{
//            return false;
//        }
        }
        $this->pay->notify();       //返回微信通知结果
    }

    /**
     *  财富通支付
     */
    public function tenpay(){
        $this->pay = new Tenpay(config('tenpay'));
        $data = [
            'return_url' => 'http://www.baidu.com',
            'notify_url' => 'http://www.baidu.com',
            'bank_type' => 'DEFAULT',          //银行卡类型
            'trade_mode' => '1',
            'out_trade_no' => '12345682555111',
            'total_fee' => '100',       //分
            'body' => 'test',
            'subject' => 'test',
        ];
        $code = $this->pay->getCode($data);
        echo $code;
        exit;
    }

    /**
     * 财付通通知
     */
    public function tenpayNotify(){
        $this->pay = new Tenpay(config('tenpay'));
        $data = array_merge(input('get.',[]),input('post.',[]));
        if($this->pay->notify($data,[$this,'order'])){              //回调函数处理通过逻辑
            return ;
        }
        //TODO.. 不通过处理
    }

    /**
     *  通过执行订单更新操作
     */
    public function order(){
        //TODO...
    }

    /**
     * 财付通回调
     */
    public function tenpayReturn(){
        $this->pay = new Tenpay(config('tenpay'));
        $data = array_merge(input('get.',[]),input('post.',[]));
        if($this->pay->verify($data)){              //通过验证
            return "pay OK";
        }
        return "pay fail";
    }

    public function alipay(){
        $this->pay = new AlipayPagePay();
        $this->pay->init(config('alipay'));
        $data = [
           'out_trade_no' => '1232432534543645',
           'subject' => 'test',
           'total_amount' => '100',
           'body' => 'test',
        ];
        echo $this->pay->getCode($data);
    }
    public function index(){
        echo 1;
    }
}