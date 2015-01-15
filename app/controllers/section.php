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
		$this->load->model('forum_m');
		$this->load->model('cate_m');
		$this->load->library('myclass');
	}
	public function index ()
	{
		$data['title'] = '版块列表';
		$data['total_forums']=$this->db->count_all('forums');
		//获取版块列表
		$data['catelist'] = $this->cate_m->get_all_cates();
		//获取cids数据
		if($data['catelist'])
		foreach($data['catelist'] as $k=>$v){
			$c[$k]=$v;
			foreach($c[$k] as $k1=>$d){
				//if($d['pid'] != 0)
				$cids[]=$d['cid'];
				$data['today_forums'][$d['cid']][]=$this->forum_m->today_forums_count($d['cid']);
			}
		}
		//echo var_dump(@$cids);

		if(@$cids){
			$num = count(@$cids);
			$cids = implode(',',@$cids);//原生态的sql时用到
			
			$data['forum_list']= $this->forum_m->get_forums_list_by_cids($num,@$cids);
			
			//echo var_export($data['new_forums']);
			//echo $this->db->last_query();
			if($data['forum_list'])
			foreach( $data['forum_list'] as $v )
			{
				$data['new_forum'][$v['cid']][]=$v;
				
			}
		}

		
		//for ($i=0 ; $i<$num; $i++){
			//$data['today_forums'][$i]=$this->forum_m->today_forums_count(@$cids[$i]);
			//if(@$data['new_forum'][$i]['pid']){
		 //   	$data['catelist'][$i] = @$data['catelist'][$i]['pid'] + @$data['new_forum'][$i]['pid'];
	    	//}
		//}
		//echo var_export(@$data['catelist']);
		//echo var_export($data['today_forums']);
		//echo var_export($data['catelist']);

		


		//最新会员列表
		$data['new_users'] = $this->user_m->get_users(15,'new');
		//最新贴子列表
		$data['new_forums'] = $this->forum_m->get_latest_forums(10);
		//action
		$data['action'] = 'section';

		$this->load->view('section',$data);
	}

}
