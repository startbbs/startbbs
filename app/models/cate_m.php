<?php

#doc
#	classname:	Cate_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Cate_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();

	}
	/**/
	public function get_category_by_cid($cid)
	{
		$this->db->where('cid',$cid);
		$query = $this->db->get('categories');
		return $query->row_array();
	}
	public function get_all_cates ()
	{
		$this->db->select('cid,pid,cname,ico,content,listnum,master');
		$this->db->order_by('pid', 'desc');
		$query=$this->db->get('categories')->result_array();
		$flist_url=array_keys($this->router->routes,'forum/flist/$1');
		if(!empty($query)){
			foreach($query as $k=>$v){
				$flist_url['flist_url']=str_replace('(:num)', $v['cid'], $flist_url[0]);
				$new=array_merge($v, $flist_url);
				$cates[$v['pid']][] = $new;
				
			}
		}
		return @$cates;
	}
	
	public function get_cates_by_pid($pid)
	{
		$this->db->select('cid,pid,cname,listnum');
		$query = $this->db->where('pid',$pid)->get('categories');
		return $query->result_array();
	}
	public function del_cate($cid)
	{
		$this->db->where('cid',$cid)->delete('categories');
		$this->db->where('pid',$cid)->delete('categories');
		
	}
	public function add_cate($data)
	{
		$this->db->insert('categories',$data);
	}
	public function move_cate($cid,$pid)
	{
		$this->db->where('cid', $cid)->update('categories', array('pid'=>$pid));
	}
	public function update_cate($cid,$data)
	{
		$this->db->where('cid',$cid)->update('categories', $data);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	
	

}
