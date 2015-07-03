<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Common.php
 *
 * @author  :  Skiychan <dev@skiy.net>
 * @created :  2015/7/3
 * @modified:  
 * @version :  0.0.1
 */

class Common {

    private static $_log_path = "logs/debug.txt";

    /**
     * 写入日志
     * @param $msg 信息
     * @param string $key 标识
     */
    public static function log($msg, $key = " >>") {
        self::create_path();
        error_log($key.json_encode($msg, JSON_UNESCAPED_UNICODE).PHP_EOL.PHP_EOL, 3, self::$_log_path);
    }

    /**
     * 创建日志路径
     */
    public static function create_path() {
        $dirname = dirname(FCPATH.self::$_log_path);
        if (! is_dir($dirname)) {
            mkdir($dirname, 0777, true);
        }
    }

    /**
     * 删除日志
     * @return bool
     */
    public static function del_log() {
        if (file_exists(self::$_log_path)) {
            unlink(self::$_log_path);
        }
        return true;
    }

}