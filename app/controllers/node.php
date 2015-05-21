<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Node
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Node extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$models = array('topic_m', 'cate_m', 'stat_m');
		$this->load->model($models);
		$this->load->library('myclass');
	}

	public function index ()
	{
		$data['title'] = '版块列表';
		$stats = $this->stat_m->get_item('total_topics');
		$data['stats']['total_topics'] = @$stats['value'];
		//获取版块列表
		$data['catelist'] = $this->cate_m->get_all_cates();
		//获取node_ids数据
		if ($data['catelist']) {
			foreach($data['catelist'] as $k => $v){
				foreach($v as $k1 => $d){
					$node_ids[]=$d['node_id'];
				}
			}
		}

		if (@$node_ids) {
			$num = count(@$node_ids);
			$node_ids = implode(',', @$node_ids);//原生态的sql时用到
			$data['topic_list']= $this->topic_m->get_topics_list_by_node_ids($num, @$node_ids);
			if ($data['topic_list']) {
				foreach ($data['topic_list'] as $v)
				{
					$data['new_topic'][$v['node_id']][]=$v;
				}
			}
		}

		//for ($i=0 ; $i<$num; $i++){
			//$data['today_topics'][$i]=$this->topic_m->today_topics_count(@$node_ids[$i]);
			//if(@$data['new_topic'][$i]['pid']){
		 //   	$data['catelist'][$i] = @$data['catelist'][$i]['pid'] + @$data['new_topic'][$i]['pid'];
	    	//}
		//}
		//echo var_export(@$data['catelist']);
		//echo var_export($data['today_topics']);
		//echo var_export($data['catelist']);

		//最新会员列表
		$data['new_users'] = $this->user_m->get_users(15,'new');
		//最新贴子列表
		$data['new_topics'] = $this->topic_m->get_latest_topics(10);
		//action
		$data['action'] = 'node';
		$this->load->view('node_index',$data);
	}

	/**
	 * 版块
	 * @param $node_id 版块id
	 * @param int $page 页码
	 */
	public function show($node_id, $page=1)
	{
		//权限
		if(!$this->auth->user_permit($node_id)) {
			show_message('您无限访问此版块',site_url());
		} else {
			//分页
			$limit = 10;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('node/show/'.$node_id);
			$config['total_rows'] = $this->topic_m->count_topics($node_id);
			$config['per_page'] = $limit;
			$config['first_link'] ='首页';
			$config['last_link'] ='尾页';
			$config['num_links'] = 10;
			
			$this->load->library('pagination');
			//$this->pagination->initialize($config);
			
			$start = ($page - 1) * $limit;
			$data['pagination'] = $this->pagination->create_links();
			//获取列表
			$data['topic_list'] = $this->topic_m->get_topics_list($start, $limit, $node_id);
			$data['category'] = $this->cate_m->get_category_by_node_id($node_id);
			$data['title'] = strip_tags($data['category']['cname']);
			
			//获取分类
			$this->load->model('cate_m');
			$data['catelist'] =$this->cate_m->get_all_cates();
			$this->load->view('node_show', $data);
		}
	}
}