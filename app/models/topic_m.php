<?php

#doc
#	classname:	topic_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class topic_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		
	}

	/*
	获取栏目条目
	*/
	public function count_topics($node_id)
	{
		$this->db->select('listnum');
		if($node_id==0){
			$query = $this->db->get('nodes');
		} else{
			$query = $this->db->get_where('nodes',array('node_id'=>$node_id));
		}
		foreach ($query->result() as $row)
		{
		    return $row->listnum;
		}

    }

	
	/*贴子列表页带分页*/
	public function get_topics_list ($page, $limit, $node_id)
	{
		$this->db->select('a.*,b.username, b.avatar, c.username as rname, d.cname');
		$this->db->from('topics a');
		$this->db->join('users b','b.uid = a.uid','left');
		$this->db->join('users c','c.uid = a.ruid','left');
		$this->db->join('nodes d','d.node_id = a.node_id','left');
		if($node_id!=0){
			$this->db->where('a.node_id',$node_id);
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
	public function get_topics_list_by_node_ids ($limit, $node_ids)
	{
		$sql="SELECT * from ( SELECT `a`.`topic_id`, `a`.`title`, `a`.`node_id`, `a`.`updatetime`, `b`.`uid`, `b`.`username` FROM (`{$this->db->dbprefix}topics` a) LEFT JOIN `{$this->db->dbprefix}users` b ON `b`.`uid` = `a`.`uid` WHERE `node_id` IN ({$node_ids}) ORDER BY `a`.`updatetime` DESC LIMIT {$limit}) alias GROUP BY node_id";
$query=$this->db->query($sql);
		//备用
		//$this->db->select('a.topic_id,a.title,a.node_id,a.updatetime,b.uid,b.username');
		//$this->db->from('topics a');
		//$this->db->join('users b','b.uid = a.uid','left');
		//$this->db->where_in('node_id',$node_ids);
		//$this->db->order_by('a.updatetime','desc');
		//$this->db->group_by('node_id');

		//$this->db->limit($limit);
		//$query = $this->db->get();

		//$sql="SELECT `a`.`topic_id`, `a`.`title`, `a`.`node_id`, `a`.`updatetime`, `b`.`uid`, `b`.`username` FROM (`sb_topics` a) LEFT JOIN `sb_users` b ON `b`.`uid` = `a`.`uid` WHERE `node_id` IN ('10', '9', '8', '6', '4', '11', '7', '5') ORDER BY `a`.`updatetime` desc LIMIT 8";
		//$query=$this->db->query($sql);
	
		if($query->num_rows() > 0){
			return $query->result_array();
		}
    }

	/*最新XX条贴子*/
	public function get_latest_topics ($limit)
	{
		$this->db->select('topic_id,title,updatetime');
		$this->db->from('topics');
		$this->db->where('is_hidden',0);
		$this->db->order_by('updatetime','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
    }

	/*贴子列表，无分页*/
	public function get_topics_list_nopage ($limit)
	{
		$this->db->select('topics.*,b.username, b.avatar, c.username as rname, d.cname');
		$this->db->from('topics');
		$this->db->join('users b','b.uid = topics.uid','left');
		$this->db->join('users c','c.uid = topics.ruid','left');
		$this->db->join('nodes d','d.node_id = topics.node_id','left');
		$this->db->where('topics.is_hidden',0);
		$this->db->order_by('ord','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
			
		}
    }

    public function get_topic_by_topic_id ($topic_id)
    {
		$this->db->select('topics.*,users.username, users.avatar');
		$this->db->join('users', 'users.uid = topics.uid');
    	$query = $this->db->where('topic_id',$topic_id)->get('topics');
    	return $query->row_array();
    }

    public function add($data)
    {
    	$this->db->insert('topics',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	public function get_topics_by_uid($uid,$num)
	{
		$this->db->select('topics.*, b.username as rname,c.cname');
		$this->db->from('topics');
		$this->db->where('topics.uid',$uid);
		$this->db->where('topics.is_hidden',0);
		$this->db->join('users b', 'b.uid= topics.ruid','left');
		$this->db->join('nodes c','c.node_id = topics.node_id','left');
		$this->db->limit($num);
		$this->db->order_by('updatetime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_topics_by_uids($uids,$num)
	{
		$this->db->select('topics.*, b.username, b.avatar, c.username as rname,d.cname');
		$this->db->from('topics');
		$this->db->where_in('topics.uid',$uids);
		$this->db->join('users b', 'b.uid= topics.uid','left');
		$this->db->join('users c', 'c.uid= topics.ruid','left');
		$this->db->join('nodes d','d.node_id = topics.node_id','left');
		$this->db->limit($num);
		$this->db->order_by('updatetime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_all_topics($page, $limit)
	{
		$this->db->select('a.topic_id, a.title, a.addtime, a.views, a.uid, a.comments, a.is_top, a.is_hidden, b.cname, b.node_id, c.username');
		$this->db->from('topics a');
		$this->db->join('nodes b','b.node_id = a.node_id');
		$this->db->join('users c', 'c.uid = a.uid');
		$this->db->order_by('ord','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	function del_topic($topic_id,$node_id,$uid)
	{
		$this->db->where('topic_id', $topic_id)->delete('topics');
		//查询相关数据
		$listnum = $this->db->select('listnum')->get_where('nodes', array('node_id'=>$node_id))->row_array();
		$topics = $this->db->select('topics')->get_where('users', array('uid'=>$uid))->row_array();
		//更新分类中的贴子数
		$this->db->where('node_id',$node_id)->update('nodes',array('listnum'=>$listnum['listnum']-1));
		//更新用户中的贴子数
		$this->db->where('uid',$uid)->update('users',array('topics'=>$topics['topics']-1));
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


	function update_topic($topic_id, $data){
		$this->db->where('topic_id',$topic_id);
  		$this->db->update('topics', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	//今日贴子
    public function today_topics_count($node_id)
    {
    	$todaydate = date('Y-m-d');  //今天的日期
		$todayunix = strtotime($todaydate);  //今天零点的unix时间戳
		$this->db->select('topic_id');
		if($node_id!=0){
			$this->db->where('node_id',$node_id);
		}
		$this->db->where('updatetime >=',$todayunix);
		$query = $this->db->get('topics');
		if($query->result()){
			return $query->num_rows();
		} else {
			return '0';
		}
		
    }
    
	//置顶及更新
    public function set_top($topic_id,$is_top,$update=0)
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
		
    	if($this->db->where('topic_id',$topic_id)->update('topics', $arr)){
	    	return true;
    	}
    }

	public function get_near_id($topic_id,$node_id,$position)
	{
		if($position==0){
			$this->db->select_max('topic_id')
			->where('topic_id <',$topic_id);
		}
		if($position==1){
			$this->db->select_min('topic_id')
			->where('topic_id >',$topic_id);
		}
		$query = $this->db->get('topics');
		if($query->num_rows() >0)
		{
			return $query->row_array();
		}
		else{
			return false;
		}
	}

	public function get_search_list($page,$limit,$keyword)
	{
		$this->db->select('topic_id, title,updatetime,comments');
		if(preg_match('/[\x80-\xff]./',$keyword)){
			$this->db->like('title',$keyword);
		}else{
			$keyword=mysql_real_escape_string($keyword);
			$this->db->where('MATCH (title) AGAINST ("'.$keyword.'" IN BOOLEAN MODE)',null,FALSE);
		}
		$this->db->limit($limit,$page);
		$query=$this->db->get('topics');
		//$query=$this->db->query($sql);
		
		return $query->result_array();

			
	}

/*    	public function get_topics_list ($page, $per_page = 1, $node_id)
	{
		$this->db->select('topics.*,users.username');
		$this->db->from('sb_topics');
		$this->db->join('sb_users','users.uid = topics.uid','left');
		$this->db->join('sb_users','users.uid = topics.ruid','left');
		$this->db->where('node_id',$node_id);
		$this->db->limit($per_page,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return show_error('消息!!!!!!!');
		}
    }*/


}
