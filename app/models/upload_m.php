<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Comment_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Upload_m extends SB_Model {
	
	var $avatar_path;
	var $avatar_path_temp;
	var $avatar_path_url;
	var $path;
	var $avatar_url;
	var $uid;

	function __construct ()
	{
		parent::__construct();
		$this->avatar_path_temp = FCPATH.'uploads/avatar/tmp';
		$this->avatar_path = FCPATH.'uploads/avatar/';
		$this->uid = $this->session->userdata('uid');
		if($this->uid){
			$this->path = $this->avatar_path.$this->get_dir($this->uid);
			$this->avatar_path_url = base_url('uploads/avatar/'.$this->get_dir($this->uid));
			if(!file_exists($this->path)){
				mkdir($this->path,0777,true);
			}	
		}
		
	}
	//

	
	/**
	 * 设置目录
	 * @param int $uid
	 */
	function get_dir($uid) {
		$uid = sprintf ( "%02d", $uid );
		$dir1 = substr ( $uid, -1, 1 );
		$dir2 = substr ( $uid, -2, 2 );
		return $dir1 . '/' . $dir2. '/';
	}
	
	function get_avatar_url($uid, $size = 'big') {
		$size = in_array ( $size, array ('big', 'middle', 'small' ) ) ? $size : 'big';
		$uid = abs ( intval ( $uid ) );
		$newuid = sprintf ( "%09d", $uid );
		$dir1 = substr ( $newuid, -1, 1 );
		$dir2 = substr ( $newuid, -2, 2 );
		//return 'uploads/avatar/'.$dir1. '/' . $dir2 . '/'.$uid. '_avatar_'.$size.'.jpg';
		return 'uploads/avatar/'.$this->get_dir($uid).$uid. '_avatar_'.$size.'.jpg';
	}
	function do_avatar() {
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->avatar_path_temp,
			'encrypt_name' => true,
			'max_size' => '1024'
		);
		
		$this->load->library('upload', $config);
		$this->upload->do_upload();

		
		$image_data_temp = $this->upload->data();
		//return var_export($image_data_temp);
		if(@$image_data_temp['full_path']){
			
			$this->resizeimg($image_data_temp['full_path'],100,100,'big');
			$this->resizeimg($image_data_temp['full_path'],48,48,'middle');
			$this->resizeimg($image_data_temp['full_path'],24,24,'small');
			//删除原图
			unlink($image_data_temp['full_path']);
			return true;
		}
	
	}

	function resizeimg($source,$width,$height,$size) {
		$this->load->library('image_lib');
		$config['image_library'] = 'GD2';
		$config['source_image'] = $source;
		$config['new_image'] = $this->path.'/'.$this->uid.'_avatar_'.$size.'.jpg';
		$config['create_thumb'] = false;
		$config['maintain_ratio'] = true;
		$config['width'] = $width;
		$config['height'] = $height;
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		$this->image_lib->clear();
	}

	function get_avatars() {
		
		$files = scandir($this->path);
		$files = array_diff($files, array('.', '..', 'thumbs'));
		
		$avatars = array();
		
		foreach ($files as $file) {
			$avatars []= array (
				'avatar_url' => $this->avatar_path_url.'/'.$file
			);
		}
		
		return $avatars;
	}
	
}