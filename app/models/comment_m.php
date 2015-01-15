<?php

#doc
#	classname:	Comment_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Comment_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();
	}

	public function add_comment ($data)
	{
		$this->db->insert('comments', $data);
	}
	
	function get_comment($page,$limit,$topic_id,$order='desc'){
		$this->db->select('comments.*, u.uid, u.username, u.avatar, u.signature');
		$query=$this->db->from('comments')
		->where('topic_id',$topic_id)
		->join ( 'users u', "u.uid=comments.uid" )
		->order_by('comments.replytime',$order)
		->limit($limit,$page)
		->get();
		return $query->result_array();
	}
	
	public function get_comments_by_uid($uid,$num)
	{
		$this->db->select('c.*, t.topic_id, t.title, t.addtime, u.uid, u.username');
		$this->db->from('comments c');
		$this->db->where('c.uid',$uid);
		$this->db->join('topics t', 't.topic_id = c.topic_id','left');
		$this->db->join('users u', 'u.uid = t.uid');
		$this->db->limit($num);
		$this->db->order_by('replytime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function del_comments_by_topic_id($topic_id,$uid)
	{
		$this->db->where('topic_id', $topic_id)->delete('comments');
		//更新用户中的回复数
		$rnum = mysql_affected_rows();
		$replies = $this->db->select('replies')->get_where('users', array('uid'=>$uid))->row_array();
		$this->db->where('uid',$uid)->update('users',array('replies'=>$replies['replies']-$rnum));
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function today_topics_count($node_id)
	{
		# code...
	}

	function get_comment_by_id ($id)
	{
		$this->db->select('id,topic_id,content')->where('id',$id);
		$query = $this->db->get('comments');
		return $query->row_array();
	}
}

	
