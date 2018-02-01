<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [


    // 定义demo模块的自动生成 （按照实际定义的文件名生成）
    'admin'     => [
        'model'       => ['Order','Level','WarrantLinked','Warrant','UserSchool','UserWork','CompanyPosition','CompanyCollection','UserPosition','UserCompany','UserCollection','MsgFeedback','MsgUser','MsgSys',
            'Report','TagType','Tag','SocialApproval','SocialR','SocialA','Company'],
        'controller'       => ['Order','Level','WarrantLinked','Warrant','UserSchool','UserWork','CompanyPosition','CompanyCollection','UserPosition','UserCompany','UserCollection','MsgFeedback','MsgUser','MsgSys',
            'Report','TagType','Tag','SocialApproval','SocialR','SocialA','Company'],
        'view'       => ['order','level','warrant_linked','warrant','user_school','user_work','company_position','company_collection','user_position','user_company','user_collection','msg_feedback','msg_user','msg_sys',
            'report','tag_type','tag','social_approval','social_r','social_a','company'],
    ],
    // 其他更多的模块定义
];
