<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Section
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Section extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->model('topic_m');
		$this->load->model('cate_m');
		$this->load->library('myclass');
	}
	public function index ()
	{
		$data['title'] = '版块列表';
		$data['total_topics']=$this->db->count_all('topics');
		//获取版块列表
		$data['catelist'] = $this->cate_m->get_all_cates();
		//获取cids数据
		if($data['catelist'])
		foreach($data['catelist'] as $k=>$v){
			$c[$k]=$v;
			foreach($c[$k] as $k1=>$d){
				//if($d['pid'] != 0)
				$cids[]=$d['cid'];
				$data['today_topics'][$d['cid']][]=$this->topic_m->today_topics_count($d['cid']);
			}
		}
		//echo var_dump(@$cids);

		if(@$cids){
			$num = count(@$cids);
			$cids = implode(',',@$cids);//原生态的sql时用到
			
			$data['topic_list']= $this->topic_m->get_topics_list_by_cids($num,@$cids);
			
			//echo var_export($data['new_topics']);
			//echo $this->db->last_query();
			if($data['topic_list'])
			foreach( $data['topic_list'] as $v )
			{
				$data['new_topic'][$v['cid']][]=$v;
				
			}
		}

		
		//for ($i=0 ; $i<$num; $i++){
			//$data['today_topics'][$i]=$this->topic_m->today_topics_count(@$cids[$i]);
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
		$data['action'] = 'section';

		$this->load->view('section',$data);
	}

}
