<?php

#doc
#	classname:	Favorites_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Favorites_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
	}
	
	/*收藏列表带分页*/
	public function get_favorites_list ($page, $limit, $topic_ids)
	{

		$sql = "SELECT a.*,b.username, b.avatar, c.username as rname
		FROM {$this->db->dbprefix}topics a 
        LEFT JOIN {$this->db->dbprefix}users b ON b.uid=a.uid
        LEFT JOIN {$this->db->dbprefix}users c ON c.uid=a.ruid
        WHERE a.topic_id in(".$topic_ids.") 
		ORDER BY FIELD(`topic_id`,".$topic_ids.")";
		$query = $this->db->query($sql);

		//$this->db->select('topics.*,b.username, b.avatar, c.username as rname');
		//$this->db->from('topics');
		//$this->db->join('users b','b.uid = topics.uid','left');
		//$this->db->join('users c','c.uid = topics.ruid','left');
		//$this->db->where_in('topic_id',$topic_ids);
		//$this->db->limit($limit,$page);
		//$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		} 
    }

	/**/
	public function get_latest_topics ($limit)
	{
		$this->db->select('topics.*,b.username, b.avatar, c.username as rname, d.cname');
		$this->db->from('topics');
		$this->db->join('users b','b.uid = topics.uid','left');
		$this->db->join('users c','c.uid = topics.ruid','left');
		$this->db->join('nodes d','d.node_id = topics.node_id','left');
		$this->db->order_by('updatetime','desc');
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
    	$this->db->insert('sb_topics',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	public function get_topics_by_uid($uid,$num)
	{
		$this->db->select('topics.*, b.username as rname,c.cname');
		$this->db->from('topics');
		$this->db->where('topics.uid',$uid);
		$this->db->join('users b', 'b.uid= topics.ruid','left');
		$this->db->join('nodes c','c.node_id = topics.node_id','left');
		$this->db->limit($num);
		$this->db->order_by('addtime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_all_topics($page, $limit)
	{
		$this->db->select('topics.*, c.cname, c.node_id, u.username');
		$this->db->from('topics');
		$this->db->join('nodes c','c.node_id = topics.node_id');
		$this->db->join('users u', 'u.uid = topics.uid');
		$this->db->order_by('addtime','desc');
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
