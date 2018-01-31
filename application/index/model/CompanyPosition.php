<?php
namespace app\index\model;

use app\index\BaseModel;

class CompanyPosition extends BaseModel
{

    public function filter($params)
    {
        $this->alias('CP');
        $this->view('Company','text,address,scale,welfare,thumb,industry,tel,qq,audit','Company.id=CP.company_id','LEFT');
        $where = [];
        $order = [];
        $field = [];
        if(isset($params['field'])){
            $this->field($params['field'],false,$this->getTable(),'CP');
        }else{
            $field = ['CP.id','CP.company_id','CP.user_id','latitude','longitude',
                'position_name','position_tag','place','salary','experience','education','CP.order','CP.create_time','CP.update_time','CP.locked'];
        }
        if(isset($params['id'])){
            $where['CP.id'] = $params['id'];
        }
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $where['position_name|place|Company.text'] = ['LIKE', "%{$params['keyword']}%"];
        }
        if(isset($params['company_id']) && !empty($params['company_id'])){
            $where['company_id'] = $params['company_id'];
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
            $where['salary'] = $params['salary'];
        }
        if(isset($params['experience'])){
            $where['experience'] = $params['experience'];
        }
        if(isset($params['education'])){
            $where['education'] = $params['education'];
        }
        if(isset($params['order'])){                    //排序
            $order['order'] = $params['order'];
        }
        if(isset($params['update_time'])){              //排序
            $order['CP.update_time'] = $params['update_time'];
        }
        $this->field($field);
        $this->where($where);
        $this->order($order);
        return $this;
    }

}