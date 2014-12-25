<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('非管理员或未登录',site_url('admin/login/do_login'));
		}
	}

	public function index ($page=1)
	{
		$data['title'] = '用户管理';
		$data['act']=$this->uri->segment(3);
		//分页
		$limit = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('admin/users/index');
		$config['total_rows'] = $this->db->count_all('users');
		$config['per_page'] = $limit;
		$config['prev_link'] = '&larr;';
		$config['first_link'] ='首页';
		$config['last_link'] ='尾页';
		$config['prev_tag_open'] = '<li class=\'prev\'>';
		$config['prev_tag_close'] = '</li';
		$config['cur_tag_open'] = '<li class=\'active\'><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li class=\'next\'>';
		$config['next_tag_close'] = '</li>';
        $config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li class=\'last\'>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();
		
		$data['users'] = $this->user_m->get_all_users($start, $limit);
		
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('users', $data);
		
	}
	public function index1()
	{
		$data['title'] = '站点设置';
		if($_POST){
			$str = array(
				array('value'=>$this->input->post('site_name'),'id'=>1),
				array('value'=>$this->input->post('welcome_tip'),'id'=>2),
				array('value'=>$this->input->post('short_intro'),'id'=>3),
				array('value'=>$this->input->post('show_captcha'),'id'=>4),
				array('value'=>$this->input->post('site_run'),'id'=>5),
				array('value'=>$this->input->post('site_stats'),'id'=>6),
				array('value'=>$this->input->post('site_keywords'),'id'=>7),
				array('value'=>$this->input->post('site_description'),'id'=>8),
				array('value'=>$this->input->post('reward_title'),'id'=>9),
				array('value'=>$this->input->post('per_page_num'),'id'=>10)
			);
			$this->db->update_batch('settings', $str, 'id');
			show_message('网站设置更新成功',site_url('admin/site_settings'),1);			
		}
		$data['item'] = $this->db->get_where('settings',array('group_type'=>0))->result_array();		
		$this->load->view('users', $data);

	}
	public function edit($uid)
	{
		$data['title'] = '修改用户信息';
		$data['user'] = $this->user_m->get_user_by_id($uid);
	
		$this->load->model('group_m');
		if($_POST){
			$group_info = $this->group_m->get_group_info($this->input->post('gid'));
			$str = array(
				'username'=> $this->input->post('username'),
				'email'=> $this->input->post('email'),
				//'password'=> md5($this->input->post('password')),
				'homepage'=> $this->input->post('homepage'),
				'location'=> $this->input->post('location'),
				'qq'=> $this->input->post('qq'),
				'signature'=> $this->input->post('signature'),
				'introduction'=> $this->input->post('introduction'),
				'credit'=> $this->input->post('credit'),
				'gid'=> $this->input->post('gid'),
				'group_type'=> @$group_info['group_type']
			);
			$str['password'] = $this->input->post('password')!=''?md5($this->input->post('password')):$data['user']['password'];
			if($this->user_m->update_user($uid, $str)){
				show_message('修改用户成功',site_url('admin/users/index'),1);
			}

		}

		$this->load->model('group_m');
		$data['groups'] = $this->group_m->group_list();
		$data['group']=$this->db->get_where('user_groups',array('gid'=>$data['user']['gid']))->row_array();
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('user_edit', $data);
	}

	public function group($act,$gid='')
	{
		$data['title'] = '用户组管理';
		$data['act']=$this->uri->segment(3).$this->uri->segment(4);
		$this->load->model('group_m');
		$data['group_list'] = $this->group_m->group_list();
		$data['group_info'] = $this->group_m->get_group_info($gid);
		$check_group = $this->group_m->check_group(@$_POST['group_name']);
		if($act == 'add'){
			$data['title'] = '添加用户组';
			if(@$_POST['group_name']){
				if($check_group){
					show_message('用户组已存在',site_url('admin/users/group/add'));
				}
				$str = array(
					'group_name' => $this->input->post('group_name',true),
					'group_type' => 2
				);
				if($this->db->insert('user_groups', $str)){
					show_message('添加用户组成功',site_url('admin/users/group/index'),1);
				}
			}
		}
		if($act == 'edit'){
			$data['title'] = '编辑用户组';
			if(@$_POST['commit_edit']){
				if($check_group){
					show_message('用户组已存在',site_url('admin/users/group/edit/'.$gid));
				}
				$str = array(
					'group_name' => $this->input->post('group_name',true)
				);
				if($this->db->where('gid',$gid)->update('user_groups', $str)){
					show_message('修改用户组成功',site_url('admin/users/group/index'),1);
				}
			}
		}
		if($act == 'del'){
			if(@$data['group_info']['group_type']>1){
				if($this->db->where('gid',$gid)->delete('user_groups')){
					show_message('删除用户组成功',site_url('admin/users/group/index'),1);
				}
			} else {
				show_message('无法删除系统用户组',site_url('admin/users/group/index'));
			}
		}
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('users', $data);

	}

	public function del ()
	{	
		$uid=$this->uri->segment(4);
		if(empty($uid)){
			show_message('uid不能为空',site_url('admin/users/index'));
		} elseif($this->db->delete('users',array('uid'=>$uid))){
			show_message('删除用户成功',site_url('admin/users/index'),1);
		}
	}

	public function search()
	{
		//查找用户
		$data['title'] = '用户搜索';
		$data['act']=$this->uri->segment(3);
		if($_POST){
			$data['users']=$this->user_m->search_user_by_username($this->input->post('username'));
		}
		$this->load->view('users', $data);
	}

	
}