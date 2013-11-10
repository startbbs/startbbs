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
		$data['old_version'] = $this->config->item('version');
		$data['new_version'] = 'V1.1.2';
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
		
		if($this->config->update('myconfig','version','V1.1.2')){
			$data['msg_v'] = '版本号更新成功';
		}
		
		$data['finish'] = '升级完成...';
		$data['error'] = '升级失败';
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