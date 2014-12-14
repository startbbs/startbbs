<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['base_url']	= '';
$config['index_page'] = '';
$config['uri_protocol']	= 'AUTO';
$config['url_suffix'] = '';
$config['language']	= 'zh_cn';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
//$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['permitted_uri_chars'] = '|^[a-z 0-9~%\.\:_\+\- \x{4e00}-\x{9fa5}]+$|iu';
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['cache_path'] = '';
$config['encryption_key'] = '';
$config['sess_cookie_name']		= 'stb_session';
$config['sess_expiration']		= 86400;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= TRUE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']		= 'stb_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= FALSE;
$config['sess_time_to_update']	= 300;

$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;

$config['global_xss_filtering'] = FALSE;

$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'stb_csrf_token';
$config['csrf_cookie_name'] = 'stb_csrf_cookie';
$config['csrf_expire'] = 7200;

$config['compress_output'] = FALSE;

$config['time_reference'] = 'local';

$config['rewrite_short_tags'] = true;

$config['proxy_ips'] = '';

$config['admin_folder']		= 'admin';

$config['time_zone'] = date_default_timezone_get();

/* End of file config.php */
/* Location: ./application/config/config.php */
