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

		$this->load->model('forum_m');
		$this->load->model('cate_m');
		$this->load->library('myclass');
		$this->load->model('link_m');
		$this->home_page_num=($this->config->item('home_page_num'))?$this->config->item('home_page_num'):20;
		
	}
	public function index ()
	{
		//获取列表
		$data['view_url']=array_keys($this->router->routes,'forum/view/$1');
		$data['flist_url']=array_keys($this->router->routes,'forum/flist/$1');
		//echo $this->router->routes['admin'];
		//echo var_export($this->router->routes);

		$data['list'] = $this->forum_m->get_forums_list_nopage($this->home_page_num);
		if(is_array($data['list']))
		foreach($data['list'] as $k=>$v)
		{
			$data['list'][$k]['view_url']=str_replace('(:num)',$v['fid'],$data['view_url'][0]);
			$data['list'][$k]['flist_url']=str_replace('(:num)', $v['cid'], $data['flist_url'][0]);
		}
		//echo var_export($data['list']);
		//echo var_export($data['list']['view_url']);
		
		
		$data['catelist'] =$this->cate_m->get_all_cates();
		//echo var_dump($data['catelist']);

		$this->db->cache_on();
		$data['total_forums']=$this->db->count_all('forums');
		$data['today_forums']=$this->forum_m->today_forums_count(0);
		$data['total_comments']=$this->db->count_all('comments');
		$this->db->cache_off();
		$data['total_users']=$this->db->count_all('users');
		$data['last_user']=$this->db->select('username',1)->order_by('uid','desc')->get('users')->row_array();

		//tags
		$this->load->model('tag_m');
		$data['taglist'] = $this->tag_m->get_latest_tags(15);

		//links
		$data['links']=$this->link_m->get_latest_links();

		//action
		$data['action'] = 'home';
		$this->load->view('home',$data);

	}
	public function latest()
	{
		$data['list'] = $this->forum_m->get_forums_list_nopage(5);
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
		$config['total_rows'] = $this->forum_m->count_forums(0);
		$config['per_page'] = $limit;
		$config['first_link'] ='首页';
		$config['last_link'] ='尾页';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		//获取列表
		$data['list'] = $this->forum_m->get_forums_list($start, $limit, 0);

		//自定义url
		$data['view_url']=array_keys($this->router->routes,'forum/view/$1');
		$data['flist_url']=array_keys($this->router->routes,'forum/flist/$1');
		if(is_array($data['list'])){
			foreach($data['list'] as $k=>$v)
			{
				$data['list'][$k]['view_url']=str_replace('(:num)',$v['fid'],$data['view_url'][0]);
				$data['list'][$k]['flist_url']=str_replace('(:num)', $v['cid'], $data['flist_url'][0]);
			}
		}
		
		//$data['category'] = $this->cate_m->get_category_by_cid($cid);
		$this->load->view('getmore', $data);
	}

}