<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Search
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Search extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('topic_m');
		$this->load->helper('text');
	}

	public function index($page=1)
	{
		
		$keyword=$this->input->post('keyword',true);
		$data['title'] = urldecode($keyword).'搜索结果';
		$data['keyword'] = urldecode($keyword);
		//echo $this->db->last_query();
		
		//分页
		$limit = 10;
		$start = ($page-1)*$limit;
		$data['search_list'] = $this->topic_m->get_search_list($start, $limit, $data['keyword']);
		$data['topic_num']=count($data['search_list']);
		
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('search');
		$config['total_rows'] = $data['topic_num'];
		$config['per_page'] = $limit;
		$config['first_link'] ='首页';
		$config['last_link'] ='尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] ='尾页';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		

		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('search',$data);


	}


}
