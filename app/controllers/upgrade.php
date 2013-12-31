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