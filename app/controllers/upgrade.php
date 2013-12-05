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
		$data['old_version'] = 'V1.1.2';
		$data['new_version'] = 'V1.1.3';
		if($data['new_version']==$data['old_version']){
			$data['msg'] = '您的版本为最新版，无需升级';
		} else{
			$data['msg'] = '开始升级';
		}
		$data['log'] = '';
		$this->load->view('upgrade',$data);
	}

	public function do_upgrade ()
	{
		$del1=unlink(FCPATH.'/static/common/css/bootstrap-responsive.min.css');
		$del2=unlink(FCPATH.'/static/common/js/jquery-1.9.1.min.js');
		$del3=unlink(FCPATH.'/themes/default/install_step.php');
		$del4=unlink(FCPATH.'/system/core/Startbbs.php');
		$del5=unlink(FCPATH.'/uploads/files');
		if($del1 && $del2 && $del3 && $del4){
			$data['msg_1'] = '删除无用文件';
		}
		$encryption_key= md5(uniqid());
		if($this->config->update('myconfig','encryption_key',$encryption_key)){
			$data['msg_2'] = '生成安全码成功';
		}
		if($this->config->update('version','sys_version','V1.1.3')){
			$data['msg_v'] = '版本号更新成功';
		}
		if(unlink(FCPATH.'/app/controllers/upgrade.php')){
			$data['msg_del'] = '删除升级文件';
			$data['msg_done'] = '升级完成...';
		} 
		$data['msg_error'] = '升级失败';

		exit(json_encode($data));		
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