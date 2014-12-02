<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$config = array(
	'user/register' => array(
		array(
			'field' => 'email',
			'label' => '邮箱',
			'rules' => 'trim|required|min_length[3]|max_length[50]|valid_email|is_unique[users.email]|xss_clean'
		),
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'trim|required|min_length[3]|max_length[15]|is_unique[users.username]|callback__check_username|xss_clean'
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required|min_length[4]|max_length[15]'
		),
		array(
			'field' => 'password_confirm',
			'label' => '重复密码',
			'rules' => 'trim|required|matches[password]'
		),
        array(
            'field' => 'captcha_code',
            'label' => '验证码',
            'rules' => 'trim|required|exact_length[4]|callback__check_captcha'
        )
		
	),
	'user/login' => array(
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'trim|required|min_length[3]|max_length[15]|xss_clean'
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required|min_length[4]|max_length[15]'
		),
        array(
            'field' => 'captcha_code',
            'label' => '验证码',
            'rules' => 'trim|required|exact_length[4]|callback__check_captcha'
        )
		
	),

    'topic/add' => array(
        array(
            'field' => 'title',
            'label' => '标题',
            'rules' => 'trim|required|htmlspecialchars|xss_clean|min_length[4]|max_length[60]'
        ),
        array(
            'field' => 'content',
            'label' => '内容',
            'rules' => 'trim|required|htmlspecialchars|min_length[8]|max_length['.$CI->config->item('words_limit').']|xss_clean|nl2br_except_pre'
        ),
        array(
            'field' => 'node_id',
            'label' => '栏目',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'keywords',
            'label' => '关键字',
            'rules' => 'trim|strip_tags'
        )
    ),
    'message/send' => array(
        array(
            'field' => 'content',
            'label' => '信息内容',
            'rules' => 'trim|strip_tags'
        )
    ),
    'auth/register' => array(
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'trim|required|max_length[50]|valid_email|is_unique[users.email]|xss_clean'
        ),
        array(
            'field' => 'captcha',
            'label' => '验证码',
            'rules' => 'trim|required|exact_length[8]|callback__check_captcha'
        )
    ),
    'auth/active' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|max_length[18]|is_unique[users.username]|xss_clean'
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        ),
        array(
            'field' => 'passconf',
            'label' => '重复密码',
            'rules' => 'trim|required|matches[password]'
        )
    ),
    'auth/login' => array(
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'trim|required|max_length[50]|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        )

    ),
    'auth/forgotten_password' => array(
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'trim|required|max_length[50]|valid_email|callback__email_valid'
        ),
        array(
            'field' => 'captcha',
            'label' => '验证码',
            'rules' => 'trim|required|exact_length[8]|callback__check_captcha'
        )
    ),
    'auth/reset_password' => array(
        array(
            'field' => 'password',
            'label' => '新密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        ),
        array(
            'field' => 'passconf',
            'label' => '重复新密码',
            'rules' => 'trim|required|matches[password]'
        )
    ),
    'topics/create' => array(
        array(
            'field' => 'title',
            'label' => '标题',
            'rules' => 'trim|required|min_length[5]|max_length[50]|xss_clean'
        ),
        array(
            'field' => 'content',
            'label' => '内容',
            'rules' => 'trim|required|min_length[20]|max_length[2000]|xss_clean'
        )
    ),
    'comments/create' => array(
        array(
            'field' => 'content',
            'label' => '回复',
            'rules' => 'trim|required|min_length[5]|max_length[400]|xss_clean'
        )
    ),
    'users/profile' => array(
        array(
            'field' => 'city',
            'label' => '城市',
            'rules' => 'trim|max_length[20]|xss_clean'
        ),
        array(
            'field' => 'company',
            'label' => '公司',
            'rules' => 'trim|max_length[20]|xss_clean'
        ),
        array(
            'field' => 'blog',
            'label' => '主页',
            'rules' => 'trim|max_length[100]|prep_url|xss_clean'
        ),
        array(
            'field' => 'intro',
            'label' => '简介',
            'rules' => 'trim|max_length[400]|xss_clean'
        )
    ),
    'users/password' => array(
        array(
            'field' => 'passold',
            'label' => '原密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]|callback__correct_password'
        ),
        array(
            'field' => 'password',
            'label' => '新密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        ),
        array(
            'field' => 'passconf',
            'label' => '重复新密码',
            'rules' => 'trim|required|matches[password]'
        )
    ),
);