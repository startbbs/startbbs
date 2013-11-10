<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Links extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('link_m');

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
		$this->myclass->notice('alert("确定要删除此链接吗！");');
		//删除链接
		if($this->link_m->del_link($id)){
		$this->myclass->notice('alert("删除链接成功！");window.location.href="'.site_url('admin/links').'";');
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
				$this->myclass->notice('alert("修改链接成功");window.location.href="'.site_url('admin/links').'";');
			}

		}
		$data['link']=$this->link_m->get_link_by_id($id);
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
			$this->myclass->notice('alert("添加链接成功！");window.location.href="'.site_url('admin/links').'";');
			}

		}
		$this->load->view('link_add', $data);

	}

	
}