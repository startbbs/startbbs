<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('page_m');
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('非管理员或未登录',site_url('admin/login/do_login'));
		}

	}

	public function index ($page=1)
	{
		$data['title'] = '单页面管理';
		//分页
		$limit = 20;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('admin/page/index/');
		$config['total_rows'] = $this->db->count_all('page');
		$config['per_page'] = $limit;
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li class=\'prev\'>';
		$config['prev_tag_close'] = '</li';
		$config['cur_tag_open'] = '<li class=\'active\'><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li class=\'next\'>';
		$config['next_tag_close'] = '</li>';
        $config['first_link'] = '首页';
		$config['first_tag_open'] = '<li class=\'first\'>';
		$config['first_tag_close'] = '</li>';
        $config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li class=\'last\'>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		$data['page_list'] = $this->page_m->get_page_list($start, $limit);
		$this->load->view('page', $data);
		
	}
	
	public function del($pid)
	{
		$data['title'] = '删除页面';
		//$this->myclass->notice('alert("确定要删除此页面吗！");');
		//删除链接
		if($this->page_m->del_page($pid)){
			show_message('删除页面成功！',site_url('admin/page'),1);
		}

	}

	public function edit($pid)
	{
		$data['title'] = '修改页面';
		if($_POST){
			$str = array(
				'title'=>$this->input->post('title'),
				'content'=>nl2br($this->input->post('content')),
				'go_url'=>$this->input->post('go_url'),
				'is_hidden'=>$this->input->post('is_hidden'),
				'add_time'=>time()
			);
			if($this->page_m->update_page($pid, $str)){
				show_message('修改页面成功！',site_url('admin/page'),1);
			}

		}
		$data['page']=$this->page_m->get_page_content($pid);
		$this->load->helper('br2nl');
		$data['page']['content'] = br2nl($data['page']['content']);
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('page_edit', $data);
	}
	public function add()
	{
		$data['title'] = '增加页面';
		if($_POST){
			$str = array(
				'title'=>$this->input->post('title'),
				'content'=>nl2br($this->input->post('content')),
				'go_url'=>$this->input->post('go_url'),
				'is_hidden'=>$this->input->post('is_hidden'),
				'add_time'=>time()
			);
			if($this->page_m->add_page($str)){
				show_message('添加页面成功！',site_url('admin/page'),1);
			}

		}
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('page_add', $data);

	}

	
}