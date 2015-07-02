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
		$this->load->model('page_m');
	}

	public function index($pid)
	{
		$data['page'] = $this->page_m->get_page_content($pid,0);
		$data['title'] = $data['page']['title'];
		$this->load->view('page',$data);
	}
}
