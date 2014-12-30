<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['admin']='/admin';
$route['add.html']='topic/add';
$route['qq_login'] = 'oauth/qqlogin';
$route['qq_callback'] = 'oauth/qqcallback';
$route['node/show/(:num)'] = 'node/show/$1';
$route['topic/show/(:num)'] = 'topic/show/$1';
$route['tag/show/(:any)'] = 'tag/show/$1';
