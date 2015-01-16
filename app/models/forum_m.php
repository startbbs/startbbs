<?php

#doc
#	classname:	Forum_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Forum_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		
	}

	/*
	获取栏目条目
	*/
	public function count_forums($cid)
	{
		$this->db->select('listnum');
		if($cid==0){
			$query = $this->db->get('categories');
		} else{
			$query = $this->db->get_where('categories',array('cid'=>$cid));
		}
		foreach ($query->result() as $row)
		{
		    return $row->listnum;
		}

    }

	
	/*贴子列表页带分页*/
	public function get_forums_list ($page, $limit, $cid)
	{
		$this->db->select('a.*,b.username, b.avatar, c.username as rname, d.cname');
		$this->db->from('forums a');
		$this->db->join('users b','b.uid = a.uid','left');
		$this->db->join('users c','c.uid = a.ruid','left');
		$this->db->join('categories d','d.cid = a.cid','left');
		if($cid!=0){
			$this->db->where('a.cid',$cid);
		}
		$this->db->where('a.is_hidden',0);
		$this->db->order_by('ord','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		} 
    }

	/**/
	public function get_forums_list_by_cids ($limit, $cids)
	{
		$sql="SELECT * from ( SELECT `a`.`fid`, `a`.`title`, `a`.`cid`, `a`.`updatetime`, `b`.`uid`, `b`.`username` FROM (`{$this->db->dbprefix}forums` a) LEFT JOIN `{$this->db->dbprefix}users` b ON `b`.`uid` = `a`.`uid` WHERE `cid` IN ({$cids}) ORDER BY `a`.`updatetime` DESC LIMIT {$limit}) alias GROUP BY cid";
$query=$this->db->query($sql);
		//备用
		//$this->db->select('a.fid,a.title,a.cid,a.updatetime,b.uid,b.username');
		//$this->db->from('forums a');
		//$this->db->join('users b','b.uid = a.uid','left');
		//$this->db->where_in('cid',$cids);
		//$this->db->order_by('a.updatetime','desc');
		//$this->db->group_by('cid');

		//$this->db->limit($limit);
		//$query = $this->db->get();

		//$sql="SELECT `a`.`fid`, `a`.`title`, `a`.`cid`, `a`.`updatetime`, `b`.`uid`, `b`.`username` FROM (`sb_forums` a) LEFT JOIN `sb_users` b ON `b`.`uid` = `a`.`uid` WHERE `cid` IN ('10', '9', '8', '6', '4', '11', '7', '5') ORDER BY `a`.`updatetime` desc LIMIT 8";
		//$query=$this->db->query($sql);
	
		if($query->num_rows() > 0){
			return $query->result_array();
		}
    }

	/*最新XX条贴子*/
	public function get_latest_forums ($limit)
	{
		$this->db->select('fid,title,updatetime');
		$this->db->from('forums');
		$this->db->where('is_hidden',0);
		$this->db->order_by('updatetime','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
    }

	/*贴子列表，无分页*/
	public function get_forums_list_nopage ($limit)
	{
		$this->db->select('forums.*,b.username, b.avatar, c.username as rname, d.cname');
		$this->db->from('forums');
		$this->db->join('users b','b.uid = forums.uid','left');
		$this->db->join('users c','c.uid = forums.ruid','left');
		$this->db->join('categories d','d.cid = forums.cid','left');
		$this->db->where('forums.is_hidden',0);
		$this->db->order_by('ord','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
			
		}
    }

    public function get_forum_by_fid ($fid)
    {
		$this->db->select('forums.*,users.username, users.avatar');
		$this->db->join('users', 'users.uid = forums.uid');
    	$query = $this->db->where('fid',$fid)->get('forums');
    	return $query->row_array();
    }

    public function add($data)
    {
    	$this->db->insert('forums',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	public function get_forums_by_uid($uid,$num)
	{
		$this->db->select('forums.*, b.username as rname,c.cname');
		$this->db->from('forums');
		$this->db->where('forums.uid',$uid);
		$this->db->where('forums.is_hidden',0);
		$this->db->join('users b', 'b.uid= forums.ruid','left');
		$this->db->join('categories c','c.cid = forums.cid','left');
		$this->db->limit($num);
		$this->db->order_by('updatetime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_forums_by_uids($uids,$num)
	{
		$this->db->select('forums.*, b.username, b.avatar, c.username as rname,d.cname');
		$this->db->from('forums');
		$this->db->where_in('forums.uid',$uids);
		$this->db->join('users b', 'b.uid= forums.uid','left');
		$this->db->join('users c', 'c.uid= forums.ruid','left');
		$this->db->join('categories d','d.cid = forums.cid','left');
		$this->db->limit($num);
		$this->db->order_by('updatetime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_all_forums($page, $limit)
	{
		$this->db->select('a.fid, a.title, a.addtime, a.views, a.uid, a.comments, a.is_top, a.is_hidden, b.cname, b.cid, c.username');
		$this->db->from('forums a');
		$this->db->join('categories b','b.cid = a.cid');
		$this->db->join('users c', 'c.uid = a.uid');
		$this->db->order_by('ord','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	function del_forum($fid,$cid,$uid)
	{
		$this->db->where('fid', $fid)->delete('forums');
		//查询相关数据
		$listnum = $this->db->select('listnum')->get_where('categories', array('cid'=>$cid))->row_array();
		$forums = $this->db->select('forums')->get_where('users', array('uid'=>$uid))->row_array();
		//更新分类中的贴子数
		$this->db->where('cid',$cid)->update('categories',array('listnum'=>$listnum['listnum']-1));
		//更新用户中的贴子数
		$this->db->where('uid',$uid)->update('users',array('forums'=>$forums['forums']-1));
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


	function update_forum($fid, $data){
		$this->db->where('fid',$fid);
  		$this->db->update('forums', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	//今日贴子
    public function today_forums_count($cid)
    {
    	$todaydate = date('Y-m-d');  //今天的日期
		$todayunix = strtotime($todaydate);  //今天零点的unix时间戳
		$this->db->select('fid');
		if($cid!=0){
			$this->db->where('cid',$cid);
		}
		$this->db->where('updatetime >=',$todayunix);
		$query = $this->db->get('forums');
		if($query->result()){
			return $query->num_rows();
		} else {
			return '0';
		}
		
    }
    
	//置顶及更新
    public function set_top($fid,$is_top,$update=0)
    {
		$arr=array();
		if($update==0){
	    	$arr['is_top']=($is_top==0)?1:0;
			$arr['ord'] = (3-2*$is_top)*time();
		}
		if($update==1){
			$arr['ord'] = (2*$is_top+1)*time();
		}
		$arr['updatetime'] = time();
		
    	if($this->db->where('fid',$fid)->update('forums', $arr)){
	    	return true;
    	}
    }

	public function get_near_id($fid,$cid,$position)
	{
		if($position==0){
			$this->db->select_max('fid')
			->where('fid <',$fid);
		}
		if($position==1){
			$this->db->select_min('fid')
			->where('fid >',$fid);
		}
		$query = $this->db->get('forums');
		if($query->num_rows() >0)
		{
			return $query->row_array();
		}
		else{
			return false;
		}
	}

/*    	public function get_forums_list ($page, $per_page = 1, $cid)
	{
		$this->db->select('forums.*,users.username');
		$this->db->from('sb_forums');
		$this->db->join('sb_users','users.uid = forums.uid','left');
		$this->db->join('sb_users','users.uid = forums.ruid','left');
		$this->db->where('cid',$cid);
		$this->db->limit($per_page,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return show_error('消息!!!!!!!');
		}
    }*/


}
