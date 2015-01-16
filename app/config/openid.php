<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//QQ
$config = array (
  'qq_appid' => '100370901',//申请到的appid
  'qq_appkey' => '45c6ecefcc8985b5fc4e273608bdce57',//申请到的appkey
  'qq_callback' => 'oauth/qqcallback',//Q登录成功后跳转的地址,请确保地址真实可用，否则会导致登录失败。
  'qq_scope' => 'get_user_info',//QQ授权api接口.按需调用
);

/* End of file openid.php */
/* Location: ./application/config/openid.php */