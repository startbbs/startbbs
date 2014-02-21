<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth extends SB_Controller {
	
	public function __construct()
    {
        parent::__construct();
		$this->load->library('myclass');
		$this->load->model('user_m');
    }
	/**
	 * 登陆页面
	 */
	public function index()
	{
		$this->load->view('qqlogin');
	}
	/**
	 * 点击QQ登陆页面操作
	 */
	public function qqlogin()
	{
		$qq_state = md5(uniqid(rand(), TRUE)); //CSRF protection
		$this->qqclass->qq_login($qq_state, $this->config->item("qq_appid"), $this->config->item("qq_scope"), site_url($this->config->item("qq_callback")));//用户点击qq登录按钮调用此函数	
	}
	/**
	 * QQ登陆返回到本网站
	 */
	public function qqcallback()
	{
		$this->load->helper('form');
		$inputs = $this->input->get();
		$access_token = $this->qqclass->qq_callback($inputs, $this->config->item("qq_appid"), $this->config->item("qq_appkey"), site_url($this->config->item("qq_callback")));//QQ登录成功后的回调地址,主要保存access token
		$open_id = $this->qqclass->get_openid($inputs, $access_token);//获取用户标示id
		
		//获取用户基本资料
		$arr['user'] = $this->qqclass->get_user_info($access_token, $this->config->item("qq_appid"), $open_id);
		$arr['user']['username'] = $arr['user']['nickname'];
		$arr['user']['openid'] = $open_id;

		if(empty($open_id)){
			$this->myclass->notice('alert("QQ一键登录授权失败，请采用普通方式注册和登录！");window.location.href="'.site_url().'";');	
		} else {
			$user = $this->db->select('uid,username,password,openid,group_type,gid')->from('users')->where('openid', $open_id)->limit(1)->get()->row_array();
			if($user){
				$this->session->set_userdata(array ('uid' => $user['uid'], 'username' => $user['username'],'openid'=>$open_id,'password' => $user['password'], 'group_type' => $user['group_type'], 'gid' => $user['gid']));
				redirect('/');
			} elseif(!$this->check_username($arr['user']['username'])){
				$userinfo = array('username'=>$arr['user']['username'],'openid'=>$open_id, 'ip'=>$this->myclass->get_ip(),'group_type'=>2,'gid'=>3, 'regtime'=>time(), 'is_active'=>1);
				$this->user_m->reg($userinfo);
				$uid = $this->db->insert_id();
				$this->session->set_userdata(array ('uid' => $uid, 'username' => $userinfo['username'],'openid' => $userinfo['openid'], 'group_type' => $userinfo['group_type'], 'gid' => $userinfo['gid']) );
				redirect('/');
			} else{
				if($_POST && $this->validate_qqlogin_form()) {
					$ip = $this->myclass->get_ip();
					$data = array(
						'username' => strip_tags($this->input->post('username')),
						'password' => md5($this->input->post('password',true)),
						'email' => $this->input->post('email',true),
						'openid' => $open_id,
						'ip' => $ip,
						'group_type' => 2,
						'gid' => 3,
						'regtime' => time(),
						'is_active' => 1
					);
					if($this->user_m->reg($data)){
						$uid = $this->db->insert_id();
						$this->session->set_userdata(array ('uid' => $uid, 'username' => $data['username'], 'password' =>$data['password'],'group_type' => $data['group_type'],'gid' => $data['gid']) );
						redirect('/');	
					}
				}
				$this->load->view('qqcallback',$arr);
			}
	}
	
}
	private function check_username($username)
	{
		$check_username = $this->db->select('username')->from('users')->where('username', $username)->get()->row_array();
		if($check_username){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', '昵称' , 'callback_check_username');
			$this->form_validation->set_message('check_username', 'The %s 已经存在');
			return true;
		}else{
			return false;
		}
	}
	private function validate_qqlogin_form(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email' , 'trim|required|min_length[3]|max_length[50]|valid_email');
		$this->form_validation->set_rules('username', '昵称' , 'trim|required|min_length[2]|max_length[20]|xss_clean|callback_check_username');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
		$this->form_validation->set_message('valid_email', "邮箱格式不对");
		$this->form_validation->set_message('alpha_dash', "邮箱格式不对");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
}

/* End of file oauth.php */
/* Location: ./application/controllers/oauth.php */