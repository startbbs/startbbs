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
		$this->load->library('myclass');

	}
	public function index ()
	{
		$data['title']='升级程序';
		
		$data['new_version'] = 'V1.1.4';
		$data['version_msg'] = '当前最新版本为：'.$data['new_version'].',升级前一定要备份数据！！';
		$data['post']=$this->input->post('do_upgrade');
		if($data['post']){
			$data['msg_status']=1;
			$this->_do_upgrade ();
			$data['msg'] = '<span class="red">升级完成</a>';
			unlink(FCPATH.'/app/controllers/upgrade.php');
			$this->load->view('upgrade',$data);
			exit;
		} else{
			$data['msg'] = '开始升级';
			$this->load->view('upgrade',$data);
		}
		
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
		
		$sql16="DELETE FROM `{$dbprefix}users` WHERE password IS NULL";

		$sql17="CREATE TABLE IF NOT EXISTS `{$dbprefix}message` (
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


		$sql18="CREATE TABLE IF NOT EXISTS `{$dbprefix}message_dialog` (
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
		$sql19="ALTER TABLE `{$dbprefix}users` CHANGE `avatar` `avatar` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'uploads/avatar/default/'";
		$sql20="UPDATE `{$dbprefix}users` SET `avatar`=REPLACE(`avatar`,'avatar_middle.jpg','')";
		$sql21="UPDATE `{$dbprefix}users` SET `avatar`=REPLACE(`avatar`,'/uploads','uploads')";
		$sql22="UPDATE `{$dbprefix}users` SET `avatar`='uploads/avatar/default/' WHERE LENGTH(avatar)=0";
		$sql23="ALTER TABLE `{$dbprefix}nodes` CHANGE `ico` `ico` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'uploads/ico/default.png'";
		$sql24="UPDATE `{$dbprefix}nodes` SET `ico`='uploads/ico/default.png' WHERE ico IS NULL";
		$sql25="ALTER TABLE `{$dbprefix}topics` ADD FULLTEXT (`title`)";

		$sql26="DELETE FROM `{$dbprefix}users` WHERE 'uid' IN (SELECT a.did FROM (SELECT MAX(uid) as did FROM `{$dbprefix}users` GROUP BY username HAVING count(username)>1) a)";

		for ( $i=1; $i<27; $i++ )
		{ 
			$this->db->query('sql'.$i);
		}
		$users=$this->db->select('uid,username,password')->get('users')->result_array();
		foreach($users as $k=>$v)
		{
			$salt=get_salt();
			$this->db->where('uid',$v['uid'])->update('users',array('salt'=>$salt,'password'=>md5($v['password'].$salt)));
			if(!preg_match('/^(?!_)(?!.*?_$)[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u',$v['username']) || str_len($v['username'])<3 || str_len($v['username'])>15){
				$this->db->where('username',$v['username'])->delete('users');
				$this->db->where('uid',$v['uid'])->or_where('follow_uid',$v['uid'])->delete('user_follow');
				$this->db->where('suid',$v['uid'])->or_where('nuid',$v['uid'])->delete('notifications');
				$this->db->where('uid',$v['uid'])->delete('topics');
				$this->db->where('uid',$v['uid'])->delete('comments');
				$this->db->where('uid',$v['uid'])->delete('favorites');				
			}
		}
}
	function _do_upgrade ()
	{
		$file1=FCPATH.'static/common/css/bootstrap-responsive.min.css';
		if(file_exists($file1))
		$del1=unlink($file1);
		$file2=FCPATH.'static/common/js/jquery-1.9.1.min.js';
		if(file_exists($file2))
		$del2=unlink($file2);
		$file3=FCPATH.'themes/default/install_step.php';
		if(file_exists($file3))
		$del3=unlink($file3);
		$file4=FCPATH.'system/core/Startbbs.php';
		if(file_exists($file4))
		$del4=unlink($file4);
		$file5=FCPATH.'uploads/files';
		if(file_exists($file5))
		$del5=rmdir($file5);
		$file6=FCPATH.'static/common/css/ie.css';
		if(file_exists($file6))
		$del1=unlink($file6);

		if(@$del1 || @$del2 || @$del3 || @$del4 || @$del5 || @$del6){
			$data['msg_1']='删除无用文件';
		}

		$encryption_key= md5(uniqid());
		if($this->config->update('myconfig','encryption_key',$encryption_key)){
			$data['msg_2']='生成安全码成功';
		}

		//$this->session->set_flashdata('msg_error', '升级失败');
		$data['msg_done']='升级成功';

		//exit(json_encode($data));		
	}

	function deldir($dir) { 
	//先删除目录下的文件： 
	$dh=opendir($dir); 
	while ($file=readdir($dh)) { 
	if($file!="." && $file!="..") { 
	$fullpath=$dir."/".$file; 
	if(!is_dir($fullpath)) { 
	unlink($fullpath); 
	} else { 
	deldir($fullpath); 
	} 
	} 
	} 
	closedir($dh); 
	//删除当前文件夹： 
	if(rmdir($dir)) { 
	return true; 
	} else { 
	return false; 
	} 
	}

	//function write_config($data)
	//{
	//	$filepath=FCPATH.'/app/config/myconfig.php';
	//	$file=read_file($filepath);
	//	$newdata=',\n'.$data.',\n);';
	//	$newfile=str_replace(',\n);',$newdata,$file);
	//	if(write_file($filepath,$newfile)){
	//		return true;
	//	}
		
	//}
}