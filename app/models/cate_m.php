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

    const TB_NODES = "nodes";

	function __construct ()
	{
		parent::__construct();
	}
	/**/
	public function get_category_by_node_id($node_id)
	{
		$query = $this->db->where('node_id',$node_id)->get(self::TB_NODES);
		return $query->row_array();
	}
	public function get_all_cates()
	{
		$this->db->select('node_id,pid,cname,ico,content,listnum,master');
		$this->db->order_by('pid', 'desc');
		$query = $this->db->get(self::TB_NODES)->result_array();
		if(!empty($query)) {
			foreach($query as $k=>$v) {
				$cates[$v['pid']][] = $v;
			}
		}
		return @$cates;
	}
	
	public function get_cates_by_pid($pid)
	{
		$this->db->select('node_id,pid,cname,listnum');
		$query = $this->db->where('pid',$pid)->get(self::TB_NODES);
		return $query->result_array();
	}

	public function del_cate($node_id)
	{
		$this->db->where('node_id',$node_id)->delete(self::TB_NODES);
		$this->db->where('pid',$node_id)->delete(self::TB_NODES);
		
	}
	public function add_cate($data)
	{
		$this->db->insert(self::TB_NODES,$data);
	}

	public function move_cate($node_id,$pid)
	{
		$this->db->where('node_id', $node_id)->update(self::TB_NODES, array('pid'=>$pid));
	}

	public function update_cate($node_id,$data)
	{
		$this->db->where('node_id',$node_id)->update(self::TB_NODES, $data);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	public function get_node_ids()
	{
		return $this->db->select('node_id')->get(self::TB_NODES)->result_array();
	}
}
