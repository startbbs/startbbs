<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Settings
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Settings extends SB_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('user_m');
		$this->load->model('upload_m');
		$this->load->library('myclass');
		$this->load->library('form_validation');
		$this->load->helper('form');
		if(!$this->auth->is_login ()){
			redirect('user/login');
		}

	}
	public function index()
	{
		$this->profile();
	}

	public function profile()
	{
		$uid = $this->session->userdata ('uid');
		$data = $this->user_m->get_user_by_id($uid);
		if($_POST && $this->form_validation->run('settings/profile')===TRUE){
			$data = array(
				'uid' => $uid,
				'email' => $this->input->post('email'),
				'homepage' => $this->input->post('homepage'),
				'location' => $this->input->post('location'),
				'qq' => $this->input->post('qq'),
				'signature' => $this->input->post('signature'),
				'introduction' => $this->input->post('introduction')
			);
			$this->user_m->update_user($uid, $data);
			$data = $this->user_m->get_user_by_id($uid);
			//$this->myclass->notice('alert("更新账户成功");history.back();');
			
		}
		$data['title'] = '账户设置';
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('settings_profile', $data);

	}
	
	public function avatar() {
		$data['title'] = '头像设置';
		$uid=$this->session->userdata('uid');
		$data['my_avatar'] = $this->upload_m->get_avatar_url($uid, 'middle');
		if($_POST){
			//print_r($this->input->post('avatar_file'));
			if($this->upload_m->do_avatar()){
				$this->db->where('uid',$uid)->update('users', array('avatar'=>$data['my_avatar']));
				$data['msg'] = '头像上传成功!';
				header("location:".$_SERVER["PHP_SELF"]);
				exit();
			} else {
				$data['msg'] = $this->upload->display_errors();
			}
			//header("location:".$_SERVER["PHP_SELF"]);
			
		}
		$data['avatars']['big'] = $this->upload_m->get_avatar_url($uid, 'big');
		$data['avatars']['middle'] = $this->upload_m->get_avatar_url($uid, 'middle');
		$data['avatars']['small'] = $this->upload_m->get_avatar_url($uid, 'small');
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('settings_avatar', $data);
	}
	
	public function password() 
	{
		$data ['title'] = '修改密码';
		if ($_POST && $this->form_validation->run('settings/password')===TRUE) {
			$newpassword = $this->input->post ('newpassword');
			$data = array ('uid' => $this->session->userdata ( 'uid' ), 'password' =>$newpassword);
			if($this->user_m->update_pwd($data)) {
				$data ['msg'] = '更新成功';
				$this->session->set_userdata ('password', @$data['newpassword'] );
			} else {
				$data ['msg'] = '修改失败';
			}
		}
		$data['csrf_name'] = $this->security->get_csrf_token_name();
	    $data['csrf_token'] = $this->security->get_csrf_hash();
	    $this->load->view('settings_password', $data);

	}

	function _check_password($password){
	        $data = array(
	            'username' => $this->session->userdata('username'),
	            'password' => $password,
	            );
	        if (!$this->user_m->check_login($data['username'],$data['password'])){
	            return FALSE;
	        } else {
	            return TRUE;
	        }
	}
	
}
