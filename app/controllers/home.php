<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Home
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Home extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();

		$this->load->model('topic_m');
		$this->load->model('cate_m');
		$this->load->library('myclass');
		$this->load->model('link_m');
		$this->home_page_num=($this->config->item('home_page_num'))?$this->config->item('home_page_num'):20;
		
	}
	public function index ()
	{
		//获取列表
		$data['topic_list'] = $this->topic_m->get_topics_list_nopage($this->home_page_num);
		$data['catelist'] =$this->cate_m->get_all_cates();
		//echo var_dump($data['catelist']);

		$this->db->cache_on();
		$stats=$this->db->get('site_stats')->result_array();
		$data['stats']=array_column($stats, 'value', 'item');
		$data['last_user']=$this->db->select('username')->where('uid',@$data['stats']['last_uid'])->get('users')->row_array();
		$data['stats']['last_username']=@$data['last_user']['username'];
		$this->db->cache_off();

		//links
		$data['links']=$this->link_m->get_latest_links();

		//action
		$data['action'] = 'home';
		$this->load->view('home',$data);

	}
	public function latest()
	{
		$data['list'] = $this->topic_m->get_topics_list_nopage(5);
		$this->load->view('latest',$data);
	}
	public function search()
	{
		$data['q'] = $this->input->get('q', TRUE);
		$data['title'] = '搜索';
		$this->load->view('search',$data);
	}

	public function getmore ($page=1)
	{
		//分页
		$limit = $this->home_page_num;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('home/getmore/'.$page);
		$config['total_rows'] = $this->topic_m->count_topics(0);
		$config['per_page'] = $limit;
		$config['first_link'] ='首页';
		$config['last_link'] ='尾页';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		//获取列表
		$data['topic_list'] = $this->topic_m->get_topics_list($start, $limit, 0);
		
		//$data['category'] = $this->cate_m->get_category_by_node_id($node_id);
		$this->load->view('getmore', $data);
	}

}