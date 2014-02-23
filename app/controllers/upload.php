<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Home
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class upload extends SB_Controller {

	function __construct(){
		parent::__construct();
		$this->upload_path_temp = FCPATH.'uploads/file/tmp';
		$this->upload_path = FCPATH.'uploads/file/';
		$this->upload_path_url = base_url().'uploads/file/'.date('Ym').'/';
		$this->path = $this->upload_path.'/'.date('Ym').'/';//这里使用“年-月”格式，可根据需要改为“年-月-日”格式
		if(!file_exists($this->path)){
			mkdir($this->path,0777,true);
		}
	}
	
	function images() {
				if(!$this->auth->is_admin())
		{
			die('无权访问此页');
		}
		//if($this->input->post('submit')) {
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->path,
			'encrypt_name' => true,
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($this->input->post('file'))){
			$data['info'] = $this->upload->display_errors();
			exit(json_encode($data));
		} else {
			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['info']  = '上传成功!';
            $data['img']  = $upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			$size = GetImageSize($config['source_image']);
			if ( $size[0] >600){
				$config['width'] = 600;
				$ra=number_format((600/$size[0]),1);
	  			$config['height']=round($size[1]*$ra);
			}

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        $datas['result_field'] = 'up_name';

			exit(json_encode($data));
			
		}

		//}
		
	}

	function upload_pic($cid='') {

		if(!$this->auth->is_admin())
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
			
		$path = 'uploads/ico/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>$cid.'.jpg',
			'overwrite'=>true,
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('img')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {
			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			$size = GetImageSize($config['source_image']);
			if ( $size[0] >72){
				$config['width'] = 72;
				$ra=number_format((72/$size[0]),1);
	  			$config['height']=round($size[1]*$ra);
			}

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}

		//}
		
		
	}

	
	function get_images() {
		
		
		//return $images;
	}

	
//	function get_images() {
//		
//		$files = scandir($this->path);
//		$files = array_diff($files, array('.', '..', 'thumbs'));
//		
//		$images = array();
//		
//		foreach ($files as $file) {
//			$images []= array (
//				'url' => $this->upload_path_url . $file,
//				'thumb_url' => $this->upload_path_url . 'thumbs/' . $file
//			);
//		}
//		
//		return $images;
//	}
	

	public function qiniu()
	{
		//定义允许上传的文件扩展名
		$ext_arr = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png','tiff'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'txt', 'zip', 'rar', 'gz', 'bz2'),
		);
		//获得文件扩展名
		$info = pathinfo(@$_FILES['file']['name']);
		$file_ext = @$info['extension'];
		//新文件名
		$new_file_name = date("YmdHis") . '_' . rand(1, 99999) . '.' . $file_ext;
		if(in_array($file_ext, $ext_arr['image']))
		$file_path='uploads/image/'.$new_file_name;
		if(in_array($file_ext, $ext_arr['media']))
		$file_path='uploads/media/'.$new_file_name;
		if(in_array($file_ext, $ext_arr['file']))
		$file_path='uploads/file/'.$new_file_name;
		$this->config->load('qiniu');
		$params =array(
			'accesskey'=>$this->config->item('accesskey'),
			'secretkey'=>$this->config->item('secretkey'),
			'bucket'=>$this->config->item('bucket'),
			'file_domain'=>$this->config->item('file_domain').'/',	
		);
		$this->load->library('qiniu_lib',$params);
		$new=$this->qiniu_lib->uploadfile(@$file_path);
		if (!empty($_FILES)) {
			echo json_encode($new);
		}else{
			$data['title'] = '七牛上传图片测试';
			$this->load->view('qiniu_v',$data);
		}
	}


}
