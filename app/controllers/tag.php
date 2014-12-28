<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Tag
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Tag extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('tag_m');
	}

	public function index($page=1)
	{
		$limit = 30;
		$start = ($page-1)*$limit;
		$this->load->library('pagination');
		$data['pagination'] = $this->pagination->create_links();
		$data['tag_list'] = $this->tag_m->get_tag_list($start, $limit);
		$data['action']='tag';
		$data['title']="标签列表";
		$this->load->view('tag_index',$data);
	}
	public function show($tag_title,$page=1)
	{

		$data['title'] = urldecode(strip_tags($tag_title));
		//分页
		$limit = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = url('tag_show','',$data['title']);
		$data['tag']=$this->db->select('topics')->where('tag_title',$data['title'])->get('tags')->row_array();
		$config['total_rows'] = @$data['tag']['topics'];
		$config['per_page'] = $limit;
		$config['first_link'] ='首页';
		$config['last_link'] ='尾页';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		$data['tag_list'] = $this->tag_m->get_tag_topics_list($start, $limit, $data['title']);
		if($data['tag_list']){
			$this->load->view('tag_show',$data);
		} else {
			show_message('标签不存在',site_url());
		}

	}


}
