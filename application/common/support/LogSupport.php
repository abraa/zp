<?php
 /**
 * ====================================
 * thinkphp5
 * ====================================
 * Author: 1002571
 * Date: 2018/1/9 17:29
 * ====================================
 * File: LogSupport.php
 * ====================================
 */

namespace app\common\support;


class LogSupport {

    /**
     * 后台操作日志
     * @param $message
     * @param int $user_id
     */
    public static function adminLog($message, $user_id = 0){
        $user_id or $user_id = LoginSupport::getUserId();
        $data = array(
            'user_id' => $user_id,
            'module_name' => strtolower(request()->module()),
            'controller_name' => strtolower(request()->controller()),
            'action_name' => strtolower(request()->action()),
            'note' => $message,
            'create_time' => time(),
        );
        db('adminLog')->insert($data);
    }

    /**
     * 用户消息
     * @param $user_id
     * @param $title
     * @param string $content
     * @return int|string
     */
    public static function userMsg($user_id,$title,$content = ''){
        $data = array(
            'user_id' => $user_id,
            'title' => $title,
            'content' => $content,
            'update_time' => time(),
            'create_time' => time(),
        );
        return db('msgUser')->insert($data);
    }

    /**
     * 系统消息
     * @param $user_id
     * @param $title
     * @param string $thumb
     * @param string $content
     * @return int|string
     */
    public static function sysMsg($user_id,$title,$thumb='',$content = ''){
        $user_id or $user_id = 0;
        $data = array(
            'user_id' => $user_id,
            'title' => $title,
            'content' => $content,
            'thumb' => $thumb,
            'update_time' => time(),
            'create_time' => time(),
        );
        return db('msgUser')->insert($data);
    }
}