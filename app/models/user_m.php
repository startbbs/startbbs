<?php

#doc
#	classname:	User_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class User_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();
	}

	function reg($data){
		return $this->db->insert('users',$data);
	}
	function check_reg($email){
		$query = $this->db->get_where('users',array('email'=>$email));
        return $query->row_array();
	}
	function check_username($username){
		$query = $this->db->get_where('users',array('username'=>$username));
        return $query->row_array();
	}
	function check_login($username,$password){
		$query = $this->check_username($username);
		$password = md5($password);
		if(@$query['password']==$password){
			$this->db->where('uid', @$query['uid'])->update('users',array('lastlogin'=>time()));
			return $query;
		} else {
			return false;
		}
		
	}
	public function get_user_by_id($uid)
	{
		$query = $this->db->get_where('users', array('uid'=>$uid));
		return $query->row_array();
	}

	function update_user($uid, $data){
		$this->db->where('uid',$uid);
  		$this->db->update('users', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function update_pwd($data){
		$this->db->where('uid',$data['uid']);
		$this->db->where('password',$data['password']);
		$this->db->update('users', array('password'=>$data['newpassword']));
		return $this->db->affected_rows();
	}
	function update_avatar($avatar,$uid)
	{
		$this->db->where('uid',$uid);
		$this->db->update('users', array('avatar'=>$avatar));
	}
	public function get_all_users($page, $limit)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->order_by('uid','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	public function get_users($limit,$ord)
	{
		$this->db->select('uid,username,avatar');
		$this->db->from('users');
		if($ord=='new'){
			$this->db->order_by('uid','desc');	
		}
		if($ord=='hot'){
			$this->db->order_by('lastlogin','desc');	
		}
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function is_user($uid)
	{
		return ($this->auth->is_login() && $uid==$this->session->userdata('uid')) ? TRUE : FALSE;
	}
	function get_user_msg($uid,$username){
		if($uid){
		   $query = $this->db->select('username')->get_where('users',array('uid'=>$uid));
		}else{
		   $query = $this->db->select('uid')->get_where('users',array('username'=>$username));
		}
	   	   return $query->row_array();
	}

	public function getpwd_by_username($username)
	{
		$query = $this->db->select('uid,email,password,group_type')->get_where('users', array('username'=>$username));
		return $query->row_array();
	}
		public function get_user_by_username($username)
	{
		$query = $this->db->limit(1)->get_where('users', array('username'=>$username));
		return $query->result_array();
	}

}
