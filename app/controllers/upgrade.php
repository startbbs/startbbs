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
		$sql1="ALTER TABLE `{$dbprefix}users`ADD`credit` INT(11) NOT NULL DEFAULT '100' AFTER `money`";
		$sql2="ALTER TABLE `{$dbprefix}users` CHANGE `money` `money` INT(11) NULL DEFAULT '0'";
		$sql3="UPDATE `{$dbprefix}users` SET money=''";
		$sql4="RENAME TABLE `{$database}`.`{$dbprefix}forums` TO `{$database}`.`{$dbprefix}topics`";
		$sql5="ALTER TABLE `{$dbprefix}comments` CHANGE `fid` `topic_id` INT( 11 ) NOT NULL DEFAULT '0'";
		$sql6="ALTER TABLE `{$dbprefix}notifications` CHANGE `fid` `topic_id` INT( 11 ) NULL DEFAULT NULL";
		$sql7="ALTER TABLE `{$dbprefix}tags` CHANGE `forums` `topics` INT( 10 ) NOT NULL DEFAULT '0'";
		$sql8="ALTER TABLE `{$dbprefix}tags_relation` CHANGE `fid` `topic_id` INT( 10 ) NULL DEFAULT NULL";
		$sql9="ALTER TABLE `{$dbprefix}topics` CHANGE `fid` `topic_id` INT( 11 ) NOT NULL AUTO_INCREMENT";
		$sql10="ALTER TABLE `{$dbprefix}users` CHANGE `forums` `topics` INT( 11 ) NULL DEFAULT '0'";
		$sql11="ALTER TABLE `{$dbprefix}categories` CHANGE `cid` `node_id` SMALLINT( 5 ) NOT NULL AUTO_INCREMENT";
		$sql12="ALTER TABLE `{$dbprefix}topics` CHANGE `cid` `node_id` SMALLINT( 5 ) NOT NULL DEFAULT '0'";
		$sql13="RENAME TABLE `{$database}`.`{$dbprefix}categories` TO `{$database}`.`{$dbprefix}nodes`";
		$sql14="ALTER TABLE `{$dbprefix}users` DROP `token`";
		$sql15="ALTER TABLE `{$dbprefix}users` ADD `salt` CHAR( 6 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '混淆码' AFTER `password`";
		$sql16="ALTER TABLE `{$dbprefix}users` CHANGE `avatar` `avatar` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'uploads/avatar/default/'";
		$sql17="UPDATE `{$dbprefix}users` SET `avatar`=REPLACE(`avatar`,'avatar_middle.jpg','')";
		$sql18="UPDATE `{$dbprefix}users` SET `avatar`=REPLACE(`avatar`,'/uploads','uploads')";
		$sql19="UPDATE `{$dbprefix}users` SET `avatar`='uploads/avatar/default/' WHERE LENGTH(avatar)=0";

		$this->db->query($sql1);
		$this->db->query($sql2);
		$this->db->query($sql3);
		$this->db->query($sql4);
		$this->db->query($sql5);
		$this->db->query($sql6);
		$this->db->query($sql7);
		$this->db->query($sql8);
		$this->db->query($sql9);
		$this->db->query($sql10);
		$this->db->query($sql11);
		$this->db->query($sql12);
		$this->db->query($sql13);
		$this->db->query($sql14);
		$this->db->query($sql15);
		$this->db->query($sql16);
		$this->db->query($sql17);
		$this->db->query($sql18);
		$this->db->query($sql19);
		
		$users=$this->db->select('uid,username,password,avatar')->get('users')->result_array();
		foreach($users as $k=>$v)
		{
			$salt=get_salt();
			$this->db->where('uid',$v['uid'])->update('users',array('salt'=>$salt,'password'=>md5($v['password'].$salt)));
			if(!$v['password'] || !preg_match('/^(?!_)(?!.*?_$)[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u',$v['username']) || str_len($v['username'])<3 || str_len($v['username'])>15){
				$this->db->where('uid',$v['uid'])->delete('users');
				$this->db->where('uid',$v['uid'])->or_where('follow_uid',$v['uid'])->delete('user_follow');
				$this->db->where('suid',$v['uid'])->or_where('nuid',$v['uid'])->delete('notifications');
				$this->db->where('uid',$v['uid'])->delete('topics');
				$this->db->where('uid',$v['uid'])->delete('comments');
				$this->db->where('uid',$v['uid'])->delete('favorites');
				$path=FCPATH.'/'.$v['avatar'];
				@unlink($path.'avatar_small.jpg');
				@unlink($path.'avatar_big.jpg');
				@unlink($path.'avatar_middle.jpg');
				//$uids[]=$v['uid'];
			}
			//if($v['avatar']!='uploads/avatar/default/'){
			//	$path2=FCPATH.'/'.$v['avatar'];
			//	@rename($path2.'avatar_small.jpg',$path2.'small.png');
			//	@rename($path2.'avatar_big.jpg',$path2.'big.png');
			//	@rename($path2.'avatar_middle.jpg',$path2.'normal.png');
			//}
		}
		sleep(2);
		$users2=$this->db->select('uid,avatar')->get('users')->result_array();
		foreach($users as $k=>$v)
		{
			if($v['avatar']!='uploads/avatar/default/'){
				$path2=FCPATH.'/'.$v['avatar'];
				@rename($path2.'avatar_small.jpg',$path2.'small.png');
				@rename($path2.'avatar_big.jpg',$path2.'big.png');
				@rename($path2.'avatar_middle.jpg',$path2.'normal.png');
			}
		}
		//echo var_dump($uids2);
		$sql20="CREATE TABLE IF NOT EXISTS `{$dbprefix}message` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `dialog_id` int(11) NOT NULL,
		  `sender_uid` int(11) NOT NULL,
		  `receiver_uid` int(11) NOT NULL,
		  `content` text NOT NULL,
		  `create_time` int(10) NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `dialog_id` (`dialog_id`),
		  KEY `sender_uid` (`sender_uid`),
		  KEY `create_time` (`create_time`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";


		$sql21="CREATE TABLE IF NOT EXISTS `{$dbprefix}message_dialog` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `sender_uid` int(11) NOT NULL,
		  `receiver_uid` int(11) NOT NULL,
		  `last_content` text NOT NULL,
		  `create_time` int(10) NOT NULL,
		  `update_time` int(10) NOT NULL,
		  `sender_remove` tinyint(1) NOT NULL DEFAULT '0',
		  `receiver_remove` tinyint(1) NOT NULL DEFAULT '0',
		  `messages` int(11) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`),
		  KEY `uid` (`sender_uid`,`receiver_uid`),
		  KEY `update_time` (`update_time`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

		$sql22="ALTER TABLE `{$dbprefix}nodes` CHANGE `ico` `ico` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'uploads/ico/default.png'";
		$sql23="UPDATE `{$dbprefix}nodes` SET `ico`='uploads/ico/default.png' WHERE ico IS NULL";
		$sql24="ALTER TABLE `{$dbprefix}topics` ADD FULLTEXT (`title`)";

		$sql25="DELETE FROM `{$dbprefix}users` WHERE 'uid' IN (SELECT a.did FROM (SELECT MAX(uid) as did FROM `{$dbprefix}users` GROUP BY username HAVING count(username)>1) a)";


		$this->db->query($sql20);
		$this->db->query($sql21);
		$this->db->query($sql22);
		$this->db->query($sql23);
		$this->db->query($sql24);
		$this->db->query($sql25);


		echo "生级完成!!";
	}

}