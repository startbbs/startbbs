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

	const TB_USERS = 'users';

	function __construct ()
	{
		parent::__construct();
	}

	function register($data){
		return $this->db->insert('users',$data);
	}
	/*login in*/
    function login($data){
	    $user = $this->get_user_by_username($data['username']);
	    if($user){
			$password = password_dohash($data['password'],$user['salt']);
			if($user['password']==$password){
				$this->session->set_userdata(array ('uid' => $user['uid'], 'username' => $user['username'], 'group_type' => $user['group_type'], 'gid' => $user['gid'], 'avatar' => $user['avatar'], 'group_name' => $user['group_name'], 'is_active' => $user['is_active'], 'favorites' => $user['favorites'], 'follows' => $user['follows'], 'notices' => $user['notices'], 'messages_unread' => $user['messages_unread'], 'credit' => $user['credit'], 'lastpost' => $user['lastpost']));
				return TRUE;
			} else {
				return FALSE;
			}
	    } else {
			return FALSE;
		}
    }
	function check_register($email){
		$query = $this->db->get_where('users',array('email'=>$email));
        return $query->row_array();
	}
	function get_user_by_username($username){
		$query = $this->db->select('a.*,b.*')->from('users a')->join('user_groups b','b.group_type=a.group_type','LEFT')->where('a.username',$username)->get();
        return $query->row_array();
	}
	public function get_user_by_uid($uid)
	{
		$query = $this->db->get_where(self::TB_USERS, array('uid'=>$uid), 1);
		return $query->row_array();
	}

	public function get_username_by_uid($uid) {
		$this->db->select('username');
		return $this->get_user_by_uid($uid);
	}

	function update_user($uid, $data){
		$this->db->where('uid',$uid);
  		$this->db->update('users', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function update_pwd($data){
		$query = $this->get_user_by_uid($data['uid']);
		$password = password_dohash($data['password'],@$query['salt']);
		$this->db->where('uid',$data['uid']);
		$this->db->update('users', array('password'=>$password));
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
	public function search_user_by_username($username)
	{
		$query = $this->db->limit(1)->get_where('users', array('username'=>$username));
		return $query->result_array();
	}
	public function update_credit($uid,$credit)
	{
		$this->db->set('credit','credit+'.$credit,false)->where('uid',$uid)->update('users');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del($uid)
	{
		$this->db->where('uid',$uid)->delete('users');
		$comment=$this->db->select('topic_id')->where('uid',$uid)->get('comments')->result_array();
		if($comment){
			$data=array();
			foreach($comment as $k=>$v)
			{
				$data[$k]['topic_id']=@$v['topic_id'];
				$data[$k]['comments']=$this->db->where('topic_id',@$v['topic_id'])->count_all_results('comments');
			}
			$this->db->update_batch('topics', $data, 'topic_id');
		}
		$this->db->where('uid',$uid)->delete('comments');
		$this->db->where('uid',$uid)->delete('favorites');
		$this->db->where('uid',$uid)->delete('user_follow');
		$this->db->where('nuid',$uid)->delete('notifications');

		$topic=$this->db->select('topic_id')->where('uid',$uid)->get('topics')->result_array();
		if($topic){
			foreach($topic as $v)
			{
				$topic_ids[]=$v['topic_id'];
			}
			$this->db->where_in('topic_id',@$topic_ids)->delete('comments');
			$this->db->where('uid',$uid)->delete('topics');
		}

	}

}
