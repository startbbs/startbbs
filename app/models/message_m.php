<?php

#doc
#	classname:	Message_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Message_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();

	}

	public function get_dialog_by_uid($sender_uid, $receiver_uid){
		$where = "(sender_uid='{$sender_uid}' AND receiver_uid='{$receiver_uid}') OR (sender_uid='{$receiver_uid}' AND receiver_uid='{$sender_uid}')";
		$this->db->where($where);
		$query=$this->db->get('message_dialog');
		if ($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	public function get_message_list($dialog_id,$start,$limit)
	{
		$this->db->select("a.*,b.username as sender_username,b.avatar as sender_avatar,c.username as receiver_username,c.avatar as receiver_avatar");
		$this->db->from('message a');
		$this->db->where('a.dialog_id',$dialog_id);
		$this->db->join('users b','b.uid = a.sender_uid','LEFT');
		$this->db->join('users c','c.uid = a.receiver_uid','LEFT');
		$this->db->order_by('a.create_time','desc');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	public function get_dialog_list($uid,$start,$limit)
	{
		$this->db->select('a.*,b.username as sender_username,b.avatar as sender_avatar,c.username as receiver_username,c.avatar as receiver_avatar')
			->from('message_dialog a')
			->or_where(array('sender_uid'=>$uid,'receiver_uid'=>$uid))
			->join('users b','b.uid =a.sender_uid','LEFT')
			->join('users c','c.uid =a.receiver_uid','LEFT')
			->order_by('a.update_time','desc')
			->limit($limit,$start);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}


}
