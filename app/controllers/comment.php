<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	Classname:	Comment
#	Scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Comment extends SB_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->library('session');
		$this->uid = $this->session->userdata('uid');
	}

	public function add_comment ()
	{
		if(empty($this->uid)) {
			$this->myclass->notice('alert("请登录后再发表");window.location.href="'.site_url('user/login/').'";');
		} else {
		//数据提交
		$data = array(
			'content' => clearxss($this->input->post('comment')),
			'fid' => $this->input->post('fid'),
			'uid' => $this->uid,
			'replytime' => time()
		);
		//数据返回
		$query=$this->db->select('comments')->get_where('forums', array('fid'=>$data['fid']))->row_array();
		$this->load->helper('format_content');
		$callback = array(
			'content' => stripslashes(format_content(filter_check($data['content']))),
			'fid' => $data['fid'],
			'uid' => $data['uid'],
			'replytime' => $this->myclass->friendly_date($data['replytime']),
			'username' => $this->input->post('username'),
			'avatar' => $this->input->post('avatar'),
			'layer' => @$query['comments']+1
		);

		echo json_encode($callback);
		//无编辑器时的处理
		//if($this->config->item('show_editor')=='off'){
			$data['content'] = filter_check($data['content']);
			$data['content'] = format_content($data['content']);
		//}
		//@会员功能
		$comment= $data['content'];
		$pattern = "/@([^@^\\s^:]{1,})([\\s\\:\\,\\;]{0,1})/";
		preg_match_all ( $pattern, $comment, $matches );
		$matches [1] = array_unique($matches [1]);
		foreach ( $matches [1] as $u ) {
			if ($u) {
				//var_dump($u);
				$res =$this->user_m->get_user_msg('',$u) ;
				if ($res['uid']) {
					$search [] = '@'.$u;
					$replace [] = '<a target="_blank" href="'.site_url('user/info/'.$res['uid']).'" >@' . $u . '</a>';
					if($this->uid!=$res['uid']){
						//@提醒someone
						$this->load->model('notifications_m');
						$this->notifications_m->notice_insert($data['fid'],$this->uid,$res['uid'],1);
						//更新接收人的提醒数
						$this->db->set('notices','notices+1',FALSE)->where('uid', $res['uid'])->update('users');
					}
				}
			}
		}
		$data['content'] = str_replace( @$search, @$replace, $comment);

		//入库
		$this->load->model('comment_m');
		$this->comment_m->add_comment($data);
		//更新回复数,最后回复用户,最后回复时间,更新时间,ord时间
		$this->load->model('forum_m');
		$this->forum_m->set_top($this->input->post('fid'),$this->input->post('is_top'),1);//已更新时间
		$this->db->set('ruid',$this->session->userdata('uid'),FALSE)->set('comments','comments+1',FALSE)->set('lastreply',time(),FALSE)->where('fid',$this->input->post('fid'))->update('forums');
		//更新用户的回复数
		$this->db->set('replies','replies+1',FALSE)->where('uid',$this->uid)->update('users');

		//回复提醒作者
		$user = $this->db->select('uid')->where('fid',$data['fid'])->get('forums')->row_array();
		if($this->uid!=$user['uid']){
			$this->load->model('notifications_m');
			$this->notifications_m->notice_insert($data['fid'],$this->uid,$user['uid'],0);
			//更新作者的提醒数
			$this->db->set('notices','notices+1',FALSE)->where('uid', $user['uid'])->update('users');
		}
		
		//更新数据库缓存
		$this->db->cache_delete('/default', 'index');
	}
		
//		$this->load->library('myclass');
//		$this->myclass->notice('window.history.go(-1);');
	}
	
	//删除回复
	public function del($cid,$fid,$id)
	{
		if($this->auth->is_admin() || $this->auth->is_master($cid)){
			if($this->db->where('id',$id)->delete('comments')){
				//更新贴子回复数
				$this->db->set('comments','comments-1',FALSE)->where('fid',$fid)->update('forums');
				//更新用户的回复数
				$this->db->set('replies','replies-1',FALSE)->where('uid',$this->uid)->update('users');
				
				redirect('forum/view/'.$fid);
			}
		} else {
			$this->myclass->notice('alert("非管理员或非本版块版主不能操作");window.location.href="'.site_url('forum/view/'.$fid).'";');
		}

	}


	//编辑回复
	public function edit($cid,$fid,$id)
	{
		if(empty($cid) || empty($fid) || empty($id)){
			$this->myclass->notice('alert("缺少参数哟")');
			redirect('forum/view/'.$fid);
			exit;
		}
		if($this->auth->is_admin() || $this->auth->is_master($cid) || $this->auth->is_user($this->uid)){
			$this->load->model('comment_m');
			$data['comment']=$this->comment_m->get_comment_by_id ($id);
			//无编辑器时的处理
			if($this->config->item('show_editor')=='off'){
				$data['comment']['content'] = filter_check($data['comment']['content']);
				$this->load->helper('format_content');
				$data['comment']['content'] = format_content($data['comment']['content']);
				$data['comment']['content'] =br2nl($data['comment']['content'] );
				
			}
			$data['comment']['cid']=$cid;
			//加载form类，为调用错误函数,需view前加载
			$this->load->helper('form');
			if($this->input->post('commit') && $this->_validate_add_form()){
				//数据处理
				$this->load->library('typography');
				$content=$this->typography->nl2br_except_pre($this->input->post('content',true),true);
				//$content=$this->input->post('content',true);
				$comment=array(
					'content'=>clearxss($content),
					'replytime'=>time()
				);
				if($this->db->where('id',$id)->update('comments',$comment)){
					//更新贴子回复时间
					$this->load->model('forum_m');
					$this->db->set('lastreply',time(),FALSE)->where('fid',$fid)->update('forums');
					redirect('forum/view/'.$fid);
					exit;
				}	
			}
			$data['title'] = '编辑回贴';
			$this->load->view('comment_edit',$data);
		} else {
			$this->myclass->notice('alert("非本人或管理员或本版块版主不能操作");window.location.href="'.site_url('forum/view/'.$fid).'";');
			exit;
		}

	}

		function _validate_add_form(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('content', '内容' , 'trim|required|min_length[6]|max_length['.$this->config->item('words_limit').']');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('xss_clean', "%s 非法字符！");
		$this->form_validation->set_message('max_length', "%s 字数最大长度不多于 %s 个字符！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}


	
}
