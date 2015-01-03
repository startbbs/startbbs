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
		$this->config->load('topicset');
		$this->load->library('form_validation');
	}

	public function add_comment ()
	{
		if(empty($this->uid)) {
			show_message('请登录后再发表',site_url('user/login/'));
		}
		if($this->form_validation->run() === TRUE){
			if(time()-$this->input->post('lastpost')<$this->config->item('timespan')){
				$callback['error']='发帖最小间隔时间是'.$this->config->item('timespan').'秒!';
				echo json_encode($callback);
				exit;
			}
			//数据提交
			$data = array(
				'content' => $this->input->post('comment'),
				'topic_id' => $this->input->post('topic_id'),
				'uid' => $this->uid,
				'replytime' => time()
			);
			//if (!isset($data['content']{4})) exit;
			$this->load->helper('format_content');
			$data['content'] = format_content($data['content']);
			//数据返回
			$query=$this->db->select('comments')->get_where('topics', array('topic_id'=>$data['topic_id']))->row_array();
			$callback = array(
				//'content' => stripslashes(format_content(filter_check($data['content']))),
				'content' => $data['content'],
				'topic_id' => $data['topic_id'],
				'uid' => $data['uid'],
				'replytime' => $this->myclass->friendly_date($data['replytime']),
				'username' => $this->input->post('username'),
				'avatar' => $this->input->post('avatar'),
				'layer' => @$query['comments']+1
			);

			
			//无编辑器时的处理
			//if($this->config->item('show_editor')=='off'){
				//$data['content'] = filter_check($data['content']);
				//$data['content'] = format_content($data['content']);
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
						$replace [] = '<a target="_blank" href="'.site_url('user/profile/'.$res['uid']).'" >@' . $u . '</a>';
						if($this->uid!=$res['uid']){
							//@提醒someone
							$this->load->model('notifications_m');
							$this->notifications_m->notice_insert($data['topic_id'],$this->uid,$res['uid'],1);
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
			//更新用户的回复数/最后发贴时间
			$this->db->set('replies','replies+1',FALSE)->set('lastpost',time(),false)->where('uid',$this->uid)->update('users');
			//返回callback
			$user=$this->db->select('lastpost')->where('uid',$this->uid)->get('users')->row_array();
			$callback['lastpost']=@$user['lastpost'];
			echo json_encode($callback);

			//更新回复数,最后回复用户,最后回复时间,更新时间,ord时间
			$this->load->model('topic_m');
			$this->topic_m->set_top($this->input->post('topic_id'),$this->input->post('is_top'),1);//已更新时间
			$this->db->set('ruid',$this->session->userdata('uid'),FALSE)->set('comments','comments+1',FALSE)->set('lastreply',time(),FALSE)->where('topic_id',$this->input->post('topic_id'))->update('topics');
			////回复提醒作者
			$topic = $this->db->select('uid')->where('topic_id',$data['topic_id'])->get('topics')->row_array();
			if($this->uid!=$topic['uid']){
				$this->load->model('notifications_m');
				$this->notifications_m->notice_insert($data['topic_id'],$this->uid,$topic['uid'],0);
				//更新作者的提醒数
				$this->db->set('notices','notices+1',FALSE)->where('uid', $topic['uid'])->update('users');
			}
			//更新会员积分
			$this->config->load('userset');
			$this->user_m->update_credit($this->uid,$this->config->item('credit_reply'));
			$this->user_m->update_credit($topic['uid'],$this->config->item('credit_reply_by'));

			//更新数据库缓存
			$this->db->cache_delete('/default', 'index');
		}
		
//		$this->load->library('myclass');
//		$this->myclass->notice('window.history.go(-1);');
	}
	
	//删除回复
	public function del($node_id,$topic_id,$id)
	{
		if($this->auth->is_admin() || $this->auth->is_master($node_id)){
			if($this->db->where('id',$id)->delete('comments')){
				//更新贴子回复数
				$this->db->set('comments','comments-1',FALSE)->where('topic_id',$topic_id)->update('topics');
				//更新用户的回复数
				$this->db->set('replies','replies-1',FALSE)->where('uid',$this->uid)->update('users');
				
				redirect('topic/show/'.$topic_id);
			}
		} else {
			show_message('非管理员或非本版块版主不能操作',site_url('topic/show/'.$topic_id));
		}

	}


	//编辑回复
	public function edit($node_id,$topic_id,$id)
	{
		if(empty($node_id) || empty($topic_id) || empty($id)){
			show_message('缺少参数哟',site_url('topic/show/'.$topic_id));
		}
		if($this->auth->is_admin() || $this->auth->is_master($node_id) || $this->auth->is_user($this->uid)){
			$this->load->model('comment_m');
			$data['comment']=$this->comment_m->get_comment_by_id ($id);
			//无编辑器时的处理
			//if($this->config->item('show_editor')=='off'){
			//	$data['comment']['content'] = filter_check($data['comment']['content']);
			//	$this->load->helper('format_content');
			//	$data['comment']['content'] = format_content($data['comment']['content']);
			//	$data['comment']['content'] =br2nl($data['comment']['content'] );
			//}
			$data['comment']['content'] =br2nl($data['comment']['content'] );
			$data['comment']['content'] = $this->input->post ('content')?$this->input->post ('content'):$data['comment']['content'];
			$data['comment']['node_id']=$node_id;
			//加载form类，为调用错误函数,需view前加载
			$this->load->helper('form');
			if($this->form_validation->run('comment/edit') === TRUE){
				//数据处理
				$comment=array(
					'content'=>$this->input->post('content',true),
					'replytime'=>time()
				);
				$this->load->helper('format_content');
				$comment['content']=format_content($comment['content']);
				if($this->db->where('id',$id)->update('comments',$comment)){
					//更新贴子回复时间
					$this->load->model('topic_m');
					$this->db->set('lastreply',time(),FALSE)->where('topic_id',$topic_id)->update('topics');
					redirect('topic/show/'.$topic_id);
					exit;
				}	
			}
			$data['title'] = '编辑回贴';
	        $data['csrf_name'] = $this->security->get_csrf_token_name();
	        $data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('comment_edit',$data);
		} else {
			show_message('非本人或管理员或本版块版主不能操作',site_url('topic/show/'.$topic_id));
		}

	}


	
}
