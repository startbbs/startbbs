<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Links extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('link_m');
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('非管理员或未登录',site_url('admin/login/do_login'));
		}

	}

	public function index ($page=1)
	{
		$data['title'] = '链接管理';
		//分页
		$limit = 20;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('admin/links/index/');
		$config['total_rows'] = $this->db->count_all('links');
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

		$data['links'] = $this->link_m->get_all_links($start, $limit);
		$this->load->view('links', $data);
		
	}
	
	public function del($id)
	{
		$data['title'] = '删除链接';
		//删除链接
		if($this->link_m->del_link($id)){
			show_message('删除链接成功！',site_url('admin/links'),1);
		}

	}

	public function edit($id)
	{
		$data['title'] = '修改链接';
		if($_POST){
			$str = array(
				'name'=>$this->input->post('name'),
				'url'=>$this->input->post('url'),
				'is_hidden'=>$this->input->post('is_hidden')
			);
			if($this->link_m->update_link($id, $str)){
				show_message('修改链接成功！',site_url('admin/links'),1);
			}

		}
		$data['link']=$this->link_m->get_link_by_id($id);
		
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('link_edit', $data);
	}
	public function add()
	{
		$data['title'] = '增加链接';
		if($_POST){
			$str = array(
				'name'=>$this->input->post('name'),
				'url'=>$this->input->post('url'),
				'is_hidden'=>$this->input->post('is_hidden')
			);
			if($this->link_m->add_link($str)){
				show_message('增加链接成功！',site_url('admin/links'),1);
			}

		}
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('link_add', $data);

	}

	
}