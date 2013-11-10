<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Page
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Page extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('page_m');
	}

	public function index($pid)
	{
		$data['page'] = $this->page_m->get_page_content($pid,0);
		$data['title'] = $data['page']['title'];
		$this->load->view('page',$data);
	}
	public function add()
	{
		$data['title'] = '增加页面';
		if($_POST){
			$str = array(
				'time'=>$this->input->post('name'),
				'content'=>$this->input->post('content'),
				'add_time'=>time(),
				'is_hidden'=>$this->input->post('is_hidden')
			);
			if($this->link_m->add_page($str)){
			$this->myclass->notice('alert("添加页面成功！");window.location.href="'.site_url('admin/links').'";');
			}

		}
		$this->load->view('link_add', $data);

	}
}
