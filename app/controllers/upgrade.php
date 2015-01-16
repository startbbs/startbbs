<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	upgrade
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Upgrade extends Other_Controller
{
	function __construct ()
	{
		parent::__construct();

	}
	public function index ()
	{
		echo "<font color=red>升级前务必要备份数据库！！！</font></br>升级版本从1.2.1到1.2.2</br>";
		echo "<a class='btn btn-default' href='".site_url('upgrade/do_upgrade')."'>开始升级</a>";
		
	}

	public function do_upgrade()
	{
		$dbprefix=$this->db->dbprefix;
		$database=$this->db->database;

		$favorites=$this->db->get('favorites')->result_array();
		var_dump($favorites);
		exit();
		foreach($favorites as $k => $v )
		{
			$newfavorites[$k]['uid']=$v['uid'];
			$newfavorites[$k]['favorites']=$v['favorites'];
		}
		if($this->db->update_batch('users',$newfavorites,'uid')){
			echo "统计favorites成功<br/>";
		}
		sleep(2);
		$path=FCPATH.'/app/controllers/upgrade.php';
		if(@unlink($path)){
			echo "成功删除upgrade.php<br/>";
		}
		sleep(2);
		echo "生级完成!!";
	}

}