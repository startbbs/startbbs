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
		$sql1="ALTER TABLE `{$dbprefix}users` ADD `favorites` INT( 11 ) NULL DEFAULT '0' AFTER `follows`";
		if($this->db->query($sql1)){
			echo "修改表users成功<br/>";
		}
		sleep(2);
		$follow=$this->db->get('user_follow')->result_array();
		foreach( $follow as $k => $v )
		{
			$newfollow[]['uid']=$v['uid'];
			$uids=$explode(",",$v['follow_uid']));
			$newfollow[]['follows']=count($uids);
		}
		$sql2=$this->db->update_batch('users',$newfollow,$newfollow['uid']);
		
		if($sql2){
			echo "统计follows成功<br/>";
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