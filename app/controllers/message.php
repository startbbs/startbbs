<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Tag
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Message extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('message_m');
		$uid = $this->session->userdata('uid');
		if(!$this->auth->is_user($uid)){
			show_message('非法用户uid');
		}	}



	public function index($page=1)
	{
		$limit = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('message/index/'.$page);
		$config['total_rows'] = $this->db->count_all('message');
		$config['per_page'] = $limit;
		$config['first_link'] ='首页';
		$config['last_link'] ='尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] ='尾页';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();
		$uid = $this->session->userdata('uid');
		$data['dialog_list']=$this->message_m->get_dialog_list($uid,$start,$limit);

		foreach((array)$data['dialog_list'] as $k=>$v)
		{
			if($v['receiver_uid']==$uid){
				$data['dialog_list'][$k]['receiver_username']=$v['sender_username'];
				$data['dialog_list'][$k]['receiver_avatar']=$v['sender_avatar'];
				$data['dialog_list'][$k]['receiver_uid']=$v['receiver_uid'];
			}
		}

		$data['title']='私信列表';
		$this->load->view('message_index',$data);
		
	}
	public function show($dialog_id='',$page=1){
		$data['dialog']=$this->db->where('id',$dialog_id)->get('message_dialog')->row_array();
		if(!$data['dialog']){
			show_message('不存在的会话');
		}
		//分页
		$limit = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('message/show/'.$dialog_id.'/'.$page);
		$config['total_rows'] = @$data['dialog']['messages'];
		$config['per_page'] = $limit;
		$config['first_link'] ='首页';
		$config['last_link'] ='尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] ='尾页';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();
		$data['message_list']=$this->message_m->get_message_list($dialog_id,$start,$limit);

		$data['uid'] = $this->session->userdata('uid');
		if($data['uid']==$data['message_list'][0]['receiver_uid']){
			$data['dialog']['receiver_uid']=$data['message_list'][0]['sender_uid'];
			$data['dialog']['receiver_username']=$data['message_list'][0]['sender_username'];
		}else{
			$data['dialog']['receiver_username']=$data['message_list'][0]['receiver_username'];
		}

		//echo var_dump($data['message_list']);
		$data['title']='私信对话';
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('message_show',$data);
	}

	public function send()
	{
		if($_POST){
			$my_uid=$this->session->userdata('uid');
			$receiver_uid=(int)$this->input->post('receiver_uid');
			if($my_uid==$receiver_uid){
				exit;
			}
			//$receiver_uid=9;
			$content=htmlentities(trim($this->input->post('content',true)));
			//$content='testsssssssssssssssss';
			$dialog_list=$this->message_m->get_dialog_by_uid($my_uid,$receiver_uid);
			//echo var_dump($message_list);
			if(!$dialog_list){
	            $dialog_data = array(
	                'sender_uid' => $my_uid,
	                'receiver_uid' => $receiver_uid,
	                'last_content'  => $content,
	                'create_time'=>time(),
	                'update_time'=>time(),
	                'messages'=>1
	            );
	            $this->db->insert('message_dialog',$dialog_data);
	            $dialog_id=$this->db->insert_id();
			}else{
				$dialog_id = $dialog_list['id'];
	            $dialog_data = array(
	                'sender_uid' => $my_uid,
	                'receiver_uid' => $receiver_uid,
	                'last_content'  => $content,
	                'update_time'=>time(),
	                'messages' =>$dialog_list['messages']+1
	            );
	            $this->db->where('id',$dialog_id)->update('message_dialog',$dialog_data);
			}
			$message_data=array(
				'dialog_id'=>$dialog_id,
                'sender_uid' => $my_uid,
                'receiver_uid' => $receiver_uid,
				'content'=>$content,
				'create_time'=>time()
			);
			if($this->db->insert('message',$message_data)){
				$callback=array(
					'dialog_id'=>$dialog_id,
				);
				echo json_encode($callback);
				//redirect('message/show/'.$message_id);
			}

		}
				

	}
	


}
