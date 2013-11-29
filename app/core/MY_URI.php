<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class MY_URI extends CI_URI {
 
    function _filter_uri($str) {
        $encoding = mb_detect_encoding($str, "gb2312,utf-8");
        if ($encoding != "utf-8") {
            $str = iconv($encoding, "utf-8", $str);
        }
        if ($str != '' && $this->config->item('permitted_uri_chars') != '' && $this->config->item('enable_query_strings') == FALSE) {
            // preg_quote() in PHP 5.3 escapes -, so the str_replace() and addition of - to preg_quote() is to maintain backwards
            // compatibility as many are unaware of how characters in the permitted_uri_chars will be parsed as a regex pattern
            if (!preg_match($this->config->item('permitted_uri_chars'), $str)) {
                show_error('myurl:The URI you submitted has disallowed characters.' . $str, 400);
            }
        }
        // Convert programatic characters to entities
        $bad = array('$', '(', ')', '%28', '%29');
        $good = array('$', '(', ')', '(', ')');
 
        return str_replace($bad, $good, $str);
    }
 
}
 