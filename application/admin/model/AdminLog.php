<?php
/**
 * ====================================
 * 日志模型(mysql)
 * ====================================
 * Author: 9004396
 * Date: 2017-11-23 14:48
 * ====================================
 * Project: ggzy
 * File: Log.php
 * ====================================
 */

namespace app\admin\model;

use app\admin\BaseModel;

class AdminLog extends BaseModel
{
    protected $updateTime = false;

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function filter($params)
    {
        $where = [];
        if (!empty($params['keyword'])) {
            $where['user_name|note'] = ['LIKE', "%{$params['keyword']}%"];
        }
        if(!empty($params['user_id'])){
            $where['user_id'] = $params['user_id'];
        }
        if (!empty($params['module'])) {
            $where['module_name'] = $params['module'];
        }
        if (!empty($params['controller'])) {
            $where['controller_name'] = $params['controller'];
        }
        if (!empty($params['method']) && $params['method'] != '*') {
            $where['action_name'] = $params['method'];
        }
        $this->where($where);
        return $this;
    }
}