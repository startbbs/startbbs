<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	User
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class User extends SB_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('user_m');
		$this->load->library('form_validation');

	}

	public function index()
	{
		$data['title'] = '用户';
		$data['new_users'] = $this->user_m->get_users(30,'new');
		$data['hot_users'] = $this->user_m->get_users(30,'hot');
		//action
		$data['action'] = 'user';		
		$this->load->view('user',$data);
	}
	public function profile ($uid)
	{
		$data['user'] = $this->user_m->get_user_by_id($uid);
		//用户大头像
		$this->load->model('upload_m');
		$data['big_avatar']=$this->upload_m->get_avatar_url($uid, 'big');
		//此用户发贴
		$this->load->model('topic_m');
		$data['topic_list'] = $this->topic_m->get_topics_by_uid($uid,5);
		//此用户回贴
		$this->load->model('comment_m');
		$data['comment_list'] = $this->comment_m->get_comments_by_uid($uid,5);
		//是否被关注
		$this->load->model('follow_m');
		$data['is_followed'] = $this->follow_m->follow_user_check($this->session->userdata('uid'), $uid);

		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
        $data['title']=$data['user']['username'];
		$this->load->view('user_profile', $data);
		
	}
	public function register ()
	{

		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');

		$data['title'] = '注册新用户';
		if ($this->auth->is_login()) {
			show_message('已登录，请退出再注册',site_url());
		}
		if($_POST && $this->form_validation->run() === TRUE){
			$password = $this->input->post('password',true);
			$salt =get_salt();
			$this->config->load('userset');//用户积分
			$data = array(
				'username' => strip_tags($this->input->post('username')),
				'password' => password_dohash($password,$salt),
				'salt' => $salt,
				'email' => $this->input->post('email',true),
				'credit' => $this->config->item('credit_start'),
				'ip' => get_onlineip(),
				'group_type' => 2,
				'gid' => 3,
				'regtime' => time(),
				'is_active' => 1
			);
			if($this->user_m->register($data)){
				//$uid = $this->db->insert_id();
				$newdata=array('username'=>$data['username'],'password'=>$password);
				$this->user_m->login($newdata);
				//去除验证码session
				$this->session->unset_userdata('yzm');
				//发送注册邮件
				if($this->config->item('mail_reg')=='on'){
					$subject='欢迎加入'.$this->config->item('site_name');
					$message='欢迎来到 '.$this->config->item('site_name').' 论坛<br/>请妥善保管这封信件。您的帐户信息如下所示：<br/>----------------------------<br/>用户名：'.$data['username'].'<br/>论坛链接: '.site_url().'<br/>----------------------------<br/><br/>感谢您的注册！<br/><br/>-- <br/>'.$this->config->item('site_name');
					send_mail($data['email'],$subject,$message);
					//echo $this->email->print_debugger();
				}

				redirect();
			}

		} else{
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('register',$data);
		}
	}
	
	public function _check_username($username)
	{  
		if(!preg_match('/^(?!_)(?!.*?_$)[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u', $username)){
  			return false;
		} else{
			return true;
		}
	}
	public function _check_captcha($captcha)
	{
		if($this->config->item('show_captcha')=='on' && $this->session->userdata('yzm')!=strtolower($captcha)){
  			return false;
		} else{
			return true;
		}
	}

	public function _disabled_username($username)
	{
		$this->config->load('userset');
		$user_arr=explode(',',$this->config->item('disabled_username'));
		if(in_array($username,$user_arr,true)){
			return false;
		}else{
			return true;
		}


	}
	
	public function login ()
	{
		$data['title'] = '用户登录';
		$data['referer']=$this->input->get('referer',true);
		//$data['referer']=($this->input->server('HTTP_REFERER')==site_url('user/login'))?'/':$this->input->server('HTTP_REFERER');
		$data['referer']=$data['referer']?$data['referer']: $this->input->server('HTTP_REFERER');
		if($this->auth->is_login()){
			redirect();
		}
		if($_POST && $this->form_validation->run() === TRUE){

            $data = array(
                'username' => $this->input->post('username', TRUE),
                'password' => $this->input->post('password',TRUE)
            );

            if ($this->user_m->login($data)) {
	            $uid=$this->session->userdata('uid');
				//更新积分
				if(time()-$data['myinfo']['lastlogin']>86400){
					$this->config->load('userset');
					$this->user_m->update_credit($uid,$this->config->item('credit_login'));
				}
				//更新最后登录时间
				$this->user_m->update_user($uid,array('lastlogin'=>time()));
                redirect($data['referer']);
            } else {
                show_message('用户名或密错误!');
            }
		} else {
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('login',$data);
		}
		
	}

	public function logout ()
	{
		$this->session->sess_destroy();
		
		$this->load->helper('cookie');
		delete_cookie('uid');
		delete_cookie('username');
		delete_cookie('group_type');
		delete_cookie('gid');
		delete_cookie('openid');
		redirect('user/login');
	}


	public function findpwd()
	{
		if($_POST){
			$username = $this->input->post('username');
			$data = $this->user_m->getpwd_by_username($username);
			if(@$data['email']==$this->input->post('email')){
				$x = md5($username.'+').@$data['password'];
				$string = base64_encode($username.".".$x);
				$subject ='重置密码';
				$message = '尊敬的用户'.$username.':<br/>你使用了本站提供的密码找回功能，如果你确认此密码找回功能是你启用的，请点击下面的链接，按流程进行密码重设。<br/><a href="'.site_url("user/resetpwd?p=").$string.'">'.site_url('user/reset_pwd?p=').$string.'</a><br/>如果不能打开链接，请复制链接到浏览器中。<br/>如果本次密码重设请求不是由你发起，你可以安全地忽略本邮件。';
			if(send_mail($this->input->post('email'),$subject,$message)){
				$data['msg'] = '密码重置链接已经发到您邮箱:'.$data['email'].',请注意查收！';
				}else{
					$data['msg'] = '没有发送成功';
				}
				$data['title'] =  '信息提示';
				$this->load->view('msg',$data);
				//echo $this->email->print_debugger();
			} else {
				show_message('用户名或邮箱错误!!');
			}
		} else{
			$data['title'] = '找回密码';
			$data['csrf_name'] = $this->security->get_csrf_token_name();
        	$data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('findpwd',$data);
		}

	}

	public function resetpwd()
	{
		$this->load->helper('form');
		$array = explode('.',base64_decode(@$_GET['p']));
		$data = $this->user_m->getpwd_by_username($array['0']);
		//$sql = "select passwords from member where username = '".trim($_array['0'])."'";
		$checkCode = md5($array['0'].'+').@$data['password'];
			
		if(@$array['1'] === $checkCode ){
			if($this->form_validation->run() === TRUE){
				$salt =get_salt();
				$password= password_dohash($this->input->post('password'),$salt);
				if($this->user_m->update_user(@$data['uid'], array('password'=>$password,'salt'=>$salt))){
					$this->session->set_userdata(array ('uid' => $data['uid'], 'username' => $array['0'], 'group_type' => $data['group_type'], 'gid' => $data['gid']));
					redirect('/');
				}
			}
		} else{
			show_message('非法重置！！');
		}
		$data['title'] = '设置新密码';
		$data['p'] = $_GET['p'];
	    $data['csrf_name'] = $this->security->get_csrf_token_name();
	    $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('findpwd',$data);
	}

}