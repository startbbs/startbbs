<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Group_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Group_m extends SB_Model {

    const TB_GROUPS= "user_groups";

	function __construct ()
	{
		parent::__construct();
	}

    /**
     * 取得组列表
     * @return bool
     */
	public function group_list() {
		$query = $this->db->order_by('gid')->get(self::TB_GROUPS);
		return $query->result_array();
	}

    /**
     * 获取用户组信息
     * @param $gid
     * @return mixed
     */
	public function get_group_info($gid)
	{
		$query = $this->db->get_where(self::TB_GROUPS, array('gid'=>$gid), 1)->row_array();
		return $query;
	}

	public function check_group($group_name)
	{
		$query = $this->db->get_where('user_groups',array('group_name'=>$group_name));
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

}
