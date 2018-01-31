<?php
namespace app\index\model;

use app\index\BaseModel;

class UserResume extends BaseModel
{

    public function filter($params)
    {

        $where = [];
        $order = [];
        $field = [];
        if(isset($params['field'])){
            $this->field($params['field']);
        }else{
            $field = ['id','status','user_id','latitude','longitude','thumb','realname','sex','birthday',
                'position_name','position_tag','place','salary','experience','education','order','create_time','update_time','locked'];
        }
        if(isset($params['id'])){
            $where['id'] = $params['id'];
        }
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $where['position_name|place|realname'] = ['LIKE', "%{$params['keyword']}%"];
        }
        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $where['user_id'] = $params['user_id'];
        }
        if (isset($params['position_tag']) && !empty($params['position_tag'])) {
            $where['position_tag'] = $params['position_tag'];
        }
        if (isset($params['longitude']) && isset($params['latitude']) && isset($params['distance'])) {
            $where['longitude'] = ['between',[$params['longitude']-$params['distance'],$params['longitude']+$params['distance']]];
            $where['latitude'] = ['between',[$params['latitude']-$params['distance'],$params['latitude']+$params['distance']]];
            $field['ROUND(lat_lng_distance('.$params['latitude'].', '.$params['longitude'].', latitude, longitude), 2)'] = 'distance';
            $order['distance'] = 'asc';
            //距离排序
            //SELECT * ,ROUND(lat_lng_distance(20, 40, latitude, longitude), 2) as dis FROM py_company_position ORDER BY dis desc;
        }
        if(isset($params['salary'])){
            $where['salary'] = ['ELT',$params['salary']];
        }
        if(isset($params['experience'])){
            $where['experience'] = ['EGT',$params['experience']];
        }
        if(isset($params['education'])){
            //如果要取比这个大的所有值,先去tag查询比这大的所有id(order字段?)
            $where['education'] = ['EGT',$params['education']];
        }
        if(isset($params['order'])){                    //排序
            $order['order'] = $params['order'];
        }
        if(isset($params['update_time'])){              //排序
            $order['update_time'] = $params['update_time'];
        }
        $this->field($field);
        $this->where($where);
        $this->order($order);
        return $this;
    }

}