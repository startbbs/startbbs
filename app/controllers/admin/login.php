<?php
class Login extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('user_m');
	}

	public function index()
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('非管理员或未登录',site_url('admin/login/do_login'));
		}
		$data['title'] = '管理后台';
		//统计
		$data['total_topics']=$this->db->count_all('topics');
		$data['total_comments']=$this->db->count_all('comments');
		$data['total_users']=$this->db->count_all('users');
		
		//$redirect	= $this->auth->is_logged_in(false, false);
		$this->load->view('dashboard', $data);

			//redirect('dashboard');


	}

	public function do_login ()
	{
		/** 检查登陆 */
		if($this->auth->is_admin())
		{
			redirect('admin/login/index');
		}
		$data['title'] = '用户登录';
		$data['referer']=$this->input->get('referer',true);
		//$data['referer']=($this->input->server('HTTP_REFERER')==site_url('user/login'))?'/':$this->input->server('HTTP_REFERER');
		$data['referer']=$data['referer']?$data['referer']: $this->input->server('HTTP_REFERER');
		if($this->auth->is_login()){
			redirect('admin/login/index');
		}
		if($_POST){
			$username = $this->input->post('username',true);
			$password = $this->input->post('password',true);
			$user = $this->user_m->check_login($username, $password);
			$captcha = $this->input->post('captcha_code');
			if($this->config->item('show_captcha')=='on' && $this->session->userdata('yzm')!=$captcha) {
				show_message('验证码不正确');
			}
			if($user){
				//更新session
				$this->session->set_userdata(array ('uid' => $user['uid'], 'username' => $user['username'], 'group_type' => $user['group_type'], 'gid' => $user['gid']));

				//更新积分
				$this->config->load('userset');
				$this->user_m->update_credit($user['uid'],$this->config->item('credit_login'));
				//更新最后登录时间
				$this->user_m->update_user($user['uid'],array('lastlogin'=>time()));
				header("location: ".$data['referer']);
				//redirect($data['referer']);
				exit;
				
			} else {
				show_message('用户名或密错误!');
			}
		} else {
			$data['csrf_name'] = $this->security->get_csrf_token_name();
        	$data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('do_login',$data);
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
		redirect('admin/login/do_login');
	}

	
}