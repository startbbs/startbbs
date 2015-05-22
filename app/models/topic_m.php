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

    const TB_NODES = "nodes";
    const TB_TOPICS = "topics";
    const TB_USERS = "users";

	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
	}

	/*
	获取栏目条目
	* result部分有点疑问 by Skiychan
	*/
	public function count_topics($node_id)
	{
		$this->db->select('listnum');
		if($node_id==0){
			$query = $this->db->get(self::TB_NODES);
		} else{
			$query = $this->db->get_where(self::TB_NODES,array('node_id'=>$node_id));
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
		$this->db->from(self::TB_TOPICS.' a');
		$this->db->join(self::TB_USERS.' b','b.uid = a.uid','left');
		$this->db->join(self::TB_USERS.' c','c.uid = a.ruid','left');
		$this->db->join(self::TB_NODES.' d','d.node_id = a.node_id','left');
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
		$query = $this->db->select('topic_id,title,updatetime')
            ->where(array('is_hidden' => 0))
            ->order_by('updatetime','desc')
            ->limit($limit)
            ->get(self::TB_TOPICS);
		if($query->num_rows() > 0){
			return $query->result_array();
		}
    }

	/*贴子列表，无分页*/
	public function get_topics_list_nopage($limit)
	{
		$this->db->select('t.*,b.username, b.avatar, c.username as rname, d.cname');
		$this->db->from(self::TB_TOPICS.' t');
		$this->db->join(self::TB_USERS.' b','b.uid = t.uid','left');
		$this->db->join(self::TB_USERS.' c','c.uid = t.ruid','left');
		$this->db->join(self::TB_NODES.' d','d.node_id = t.node_id','left');
		$this->db->where('t.is_hidden',0);
		$this->db->order_by('ord','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
    }

    public function get_topic_by_topic_id ($topic_id)
    {
    	$query = $this->db->select('t.*,u.username, u.avatar')
				->from(self::TB_TOPICS.' t')
                ->join(self::TB_USERS.' u', 'u.uid = t.uid', 'left')
                ->where('topic_id',$topic_id)
                ->get();
    	return $query->row_array();
    }

	/**
	 * 通过topic_id获取单条文章信息
	 * @param string $feild 获取字段名
	 * @return mixed
	 */
	public function get_info_by_topic_id($tid, $feild='') {
		$this->db->select($feild);
		return $this->db->get_where(self::TB_TOPICS, array('topic_id' => $tid), 1)->row_array();
	}

    public function add($data)
    {
    	$this->db->insert(self::TB_TOPICS, $data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

	public function get_topics_by_uid($uid,$num)
	{
		$this->db->select('t.*, b.username as rname,c.cname');
		$this->db->from(self::TB_TOPICS.' t');
		$this->db->where('t.uid',$uid);
		$this->db->where('t.is_hidden',0);
		$this->db->join(self::TB_USERS.' b', 'b.uid= t.ruid','left');
		$this->db->join(self::TB_NODES.' c','c.node_id = t.node_id','left');
		$this->db->limit($num);
		$this->db->order_by('updatetime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_topics_by_uids($uids,$num)
	{
		$this->db->select('t.*, b.username, b.avatar, c.username as rname,d.cname');
		$this->db->from(self::TB_TOPICS.' t');
		$this->db->where_in('t.uid',$uids);
		$this->db->join(self::TB_USERS.' b', 'b.uid= t.uid','left');
		$this->db->join(self::TB_USERS.' c', 'c.uid= t.ruid','left');
		$this->db->join(self::TB_NODES.' d','d.node_id = t.node_id','left');
		$this->db->limit($num);
		$this->db->order_by('updatetime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_all_topics($page, $limit)
	{
		$this->db->select('a.topic_id, a.title, a.addtime, a.views, a.uid, a.comments, a.is_top, a.is_hidden, b.cname, b.node_id, c.username');
		$this->db->from(self::TB_TOPICS.' a');
		$this->db->join(self::TB_NODES.' b','b.node_id = a.node_id');
		$this->db->join(self::TB_USERS.' c', 'c.uid = a.uid');
		$this->db->order_by('ord','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	function del_topic($topic_id,$node_id,$uid)
	{
		$this->db->where('topic_id', $topic_id)->delete(self::TB_TOPICS);
		//更新分类中的贴子数
		$this->db->set('listnum','listnum-1',FALSE)->where('node_id',$node_id)->update(self::TB_NODES);
		//更新用户中的贴子数
		$this->db->set('topics','topics-1',FALSE)->where('uid',$uid)->update(self::TB_USERS);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


	function update_topic($topic_id, $data){
  		$this->db->where('topic_id',$topic_id)->update(self::TB_TOPICS, $data);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	/**
	 * 更新文章信息
	 * @param $tid
	 * @return bool
	 */
	private function set_info_by_topic_id($tid) {
		if ($this->db->where('topic_id', $tid)->update(self::TB_TOPICS)){
			return TRUE;
		}
	}

	/**
	 * 置顶及更新
	 * @param $tid
	 * @param $is_top
	 * @param int $update
	 * @return bool
	 */
    public function set_top($tid, $is_top, $update=0)
    {
		if ($update == 0) {
			$this->db->set('is_top', ($is_top == 0) ? 1 : 0);
			$this->db->set('ord', (3 - 2 * $is_top) * time());
		}
		if ($update == 1) {
			$this->db->set('ord', (2 * $is_top + 1) *time());
		}
		$this->db->set('updatetime', time());
		$this->set_info_by_topic_id($tid);
    }

	/**
	 * 更新浏览数
	 */
	public function set_views($tid) {
		$this->db->set('views', 'views+1', FALSE);
		$this->set_info_by_topic_id($tid);
	}

	public function set_reply($tid, $ruid) {
		$this->db->set('ruid',$ruid)
					->set('comments', 'comments+1',FALSE)
					->set('lastreply', time());
		$this->set_info_by_topic_id($tid);
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
		$query = $this->db->get(self::TB_TOPICS);
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
		$query=$this->db->get(self::TB_TOPICS);
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
