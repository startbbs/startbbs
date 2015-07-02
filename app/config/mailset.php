<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//mailset
$config = array (
  'protocol' => 'smtp',//邮件方式
  'smtp_host' => '',//设置 SMTP 服务器的地址
  'smtp_port' => '',//设置 SMTP 服务器的端口，默认为 25
  'smtp_user' => '',//发信人邮件地址。
  'smtp_pass' => '',//SMTP 身份验证密码
  'mail_reg' => 'off',//发送注册邮件
);

/* End of file mailset.php */
/* Location: ./application/config/mailset.php */