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
		echo "<font color=red>升级前务必要备份数据库！！！</font></br></br>";
		echo "<a class='btn btn-default' href='".site_url('upgrade/do_upgrade')."'>开始升级</a>";
		
	}

	public function do_upgrade()
	{
		$dbprefix=$this->db->dbprefix;
		$database=$this->db->database;
		$sql1="ALTER TABLE `{$dbprefix}users` CHANGE `openid` `openid` CHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL";
		$sql2="delete from `{$dbprefix}users` where uid in (select * from (select max(uid) from `{$dbprefix}users` group by username having count(username)>1) as b)";
		$sql3="ALTER TABLE `{$dbprefix}users` ADD UNIQUE (`username`)";

		if($this->db->query($sql1)){
			echo "修改openid成功<br/>";
		}
		sleep(2);
		if($this->db->query($sql2) && $this->db->query($sql3)){
			echo "修改username成功<br/>";
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