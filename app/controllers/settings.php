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
	
	public function avatar($msg='') {
		$data['title'] = '头像设置';
		$uid=$this->session->userdata('uid');
		$user_info=$this->user_m->get_user_by_id($this->session->userdata('uid'));
        $data['avatar']=$user_info['avatar'];
		$data['msg'] = $msg;

        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('settings_avatar', $data);
	}

    public function avatar_upload()
    {
        $config['upload_path'] = './uploads/avatar';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '512';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('avatar_file'))
        {
            $this->avatar($this->upload->display_errors());
        }
        else
        {
            //upload sucess
            $img_array = $this->upload->data();
            $this->load->library('AvatarResize');

            if ($this->avatarresize->resize($img_array['full_path'], 100 ,100 ,'big') && $this->avatarresize->resize($img_array['full_path'], 48 ,48 ,'normal') && $this->avatarresize->resize($img_array['full_path'], 24 ,24 ,'small')) {

                $data = array(
                    'avatar' => $this->avatarresize->get_dir()
                    );
                $this->user_m->update_user($this->session->userdata('uid'), $data);
                //删除tmp下的原图
                unlink($img_array['full_path']);
                redirect('settings/avatar','refresh');
            } else {
                //设置三个头像没有成功
                $this->avatar('头像上传失败，请重试！');
            }
        }
    }

	public function password() 
	{
		$data ['title'] = '修改密码';
		if ($_POST && $this->form_validation->run('settings/password')===TRUE) {
			$newpassword = $this->input->post ('newpassword');
			$data = array ('uid' => $this->session->userdata ( 'uid' ), 'password' =>$newpassword);
			if($this->user_m->update_pwd($data)) {
				//$data ['msg'] = '更新成功';
				//$this->session->set_userdata ('password', @$data['newpassword'] );
				show_message('修改密码成功,请重新登录！',site_url('user/logout'),1);
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
	        if (!$this->user_m->login($data)){
	            return FALSE;
	        } else {
	            return TRUE;
	        }
	}
	
}
