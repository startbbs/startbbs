<?php

return [
    'group_list' => [
	    'base'=>'基础',
	    //'sys'=>'系统',
	    'content'=>'内容',
	    'user'=>'用户',
	    //'upload' =>'上传',
	    //'develop' =>'开发',
	    //'databases' =>'数据库',
	    'mail' =>'邮件',
	],
	'group_type' => ['input','textarea','array','switch','select','radio','checkbox','image','file'],
	// 系统数据表
    'tables'            => [
		'stb_article',
		'stb_article_category',
		'stb_attachment',
		'stb_auth_group',
		'stb_auth_group_access',
		'stb_auth_rule',
		'stb_category',
		'stb_hook',
		'stb_hook_plugin',
		'stb_link',
		'stb_nav',
		'stb_plugin',
		'stb_post',
		'stb_slide',
		'stb_slide_category',
		'stb_system',
		'stb_topic',
		'stb_user',
		'stb_user_oauth'
    ],
];
