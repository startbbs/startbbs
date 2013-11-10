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
		$this->upload_path_temp = FCPATH.'uploads/files/tmp';
		$this->upload_path = FCPATH.'uploads/files/';
		$this->upload_path_url = base_url().'uploads/files/'.date('Ym').'/';
		$this->path = $this->upload_path.'/'.date('Ym').'/';//这里使用“年-月”格式，可根据需要改为“年-月-日”格式
		if(!file_exists($this->path)){
			mkdir($this->path,0777,true);
		}
	}
	
	function images() {
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
	
	
}
