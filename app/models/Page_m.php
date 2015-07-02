<?php

#doc
#	classname:	Page_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Page_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();

	}

	//获取单页面菜单
	public function get_page_menu($num,$is_hidden)
	{
		$this->db->select('pid,title,go_url');
		$this->db->where('is_hidden',$is_hidden);
		$this->db->limit($num);
		$query = $this->db->get('page');
		if($query->num_rows() > 0){
		return $query->result_array();
		}
	}

	
	//获取单页面内容
	public function get_page_content($pid)
	{
		$this->db->where('pid',$pid);
		$query = $this->db->get('page');
		if($query->num_rows() > 0){
		return $query->row_array();
		}
	}
	//获取单页面列表
	public function get_page_list($start, $limit)
	{
		$this->db->select('pid,title,add_time,is_hidden');
		$this->db->limit($limit,$start);
		$query = $this->db->get('page');
		if($query->num_rows() > 0){
		return $query->result_array();
		}
	}
	//添加页面
	public function add_page($data)
    {
    	$this->db->insert('page',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	//删除页面
	function del_page($pid)
	{
		$this->db->where('pid', $pid)->delete('page');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	//更新页面
	function update_page($pid, $data){
		$this->db->where('pid',$pid);
  		$this->db->update('page', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


}
