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

	public function index($tag_title,$page=1)
	{

		$data['title'] = urldecode($tag_title);
		//分页
		$limit = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('tag/index/'.$data['title']);
		$data['tag']=$this->db->select('forums')->where('tag_title',$data['title'])->get('tags')->row_array();
		$config['total_rows'] = @$data['tag']['forums'];
		$config['per_page'] = $limit;
		$config['first_link'] ='首页';
		$config['last_link'] ='尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] ='尾页';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		$data['tag_list'] = $this->tag_m->get_tag_forums_list($start, $limit, $data['title']);
		if($data['tag_list']){
			$view_url=array_keys($this->router->routes,'forum/view/$1');
			foreach($data['tag_list'] as $k=>$v)
			{
				$data['tag_list'][$k]['view_url']=str_replace('(:num)',$v['fid'],$view_url[0]);
			}
			
			$this->load->view('tag',$data);
		} else {
			$this->myclass->notice('alert("标签不存在");window.location.href="'.site_url('/').'";');
		}

	}


}
