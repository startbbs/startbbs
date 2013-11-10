<?php
class Login extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = '管理后台';
		//统计
		$data['total_forums']=$this->db->count_all('forums');
		$data['total_comments']=$this->db->count_all('comments');
		$data['total_users']=$this->db->count_all('users');
		
		//$redirect	= $this->auth->is_logged_in(false, false);
		$this->load->view('dashboard', $data);

			//redirect('dashboard');


	}

	
}