<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Follow
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Follow extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('follow_m');
		$uid = $this->session->userdata('uid');
		if(!$this->auth->is_user($uid)){
			show_message('非法用户uid');
		}
	}

	public function index ()
	{
		$data['follow_list'] = $this->follow_m->get_follow_list($this->session->userdata('uid'),20);
		//echo var_export($data['follow_list']);
		//获取ids数据
		if(is_array($data['follow_list'])){
			foreach($data['follow_list'] as $v ){
				$ids[] = $v['follow_uid'];
			}
		}
		//获取关注用户的贴子
		$this->load->model('topic_m');
		if(@$ids){
			$data['follow_user_topics'] = $this->topic_m->get_topics_by_uids(@$ids,15);
		}
		$data['title'] = '我关注的用户';
		$this->load->view('follow',$data);

	}

	public function add($follow_uid)
	{
		//关注操作(需要优化)
		$uid = $this->session->userdata('uid');
		$is_followed = $this->follow_m->follow_user_check($uid, $follow_uid);
		//echo var_dump($is_followed);
		if($is_followed=='0' && $uid!=$follow_uid){
			$data = array(
				'uid' => $uid,
				'follow_uid' => $follow_uid,
				'addtime' => time()
			);
			//插入数据
			if($this->db->insert('user_follow',$data) && $this->db->set('follows','follows+1',FALSE)->where('uid', $uid)->update('users')){
				//更新会员积分
				$this->config->load('userset');
				$this->load->model ('user_m');
				$this->user_m->update_credit($follow_uid,$this->config->item('credit_follow'));
				$user=$this->db->select('follows')->get_where('users',array('uid'=>$uid))->row_array();
				$this->session->set_userdata('follows',$user['follows']);
				redirect('user/profile/'.$follow_uid);
			}
		} else{
			redirect('user/profile/'.$follow_uid);
		}
	}

	public function cancel($follow_uid)
	{
		$uid = $this->session->userdata('uid');
		$is_followed = $this->follow_m->follow_user_check($uid, $follow_uid);
		if($is_followed && $this->db->delete('user_follow', array('uid'=>$uid,'follow_uid'=>$follow_uid)) && $this->db->set('follows','follows-1',FALSE)->where('uid', $uid)->update('users')){
			$user=$this->db->select('follows')->get_where('users',array('uid'=>$uid))->row_array();
			$this->session->set_userdata('follows',$user['follows']);
			redirect('user/profile/'.$follow_uid);
		}
	}


}
