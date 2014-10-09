<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['admin']='/admin';
$route['add.html']='topic/add';
$route['qq_login'] = 'oauth/qqlogin';
$route['qq_callback'] = 'oauth/qqcallback';
$route['topic/flist/(:num)'] = 'topic/flist/$1';
$route['topic/view/(:num)'] = 'topic/view/$1';
$route['tag/index/(:any)'] = 'tag/index/$1';
