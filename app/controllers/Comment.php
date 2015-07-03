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
		$this->config->load('topicset');
		$this->load->library('session');
		$this->load->library('myclass');
		$this->load->library('form_validation');

		$models = array('topic_m', 'comment_m', 'user_m', 'stat_m');
		$this->load->model($models);
		$this->uid = $this->session->userdata('uid');
	}

    /**
     * 添加评论
     */
	public function add_comment ()
	{
		if (empty($this->uid)) {
			show_message('请登录后再发表',site_url('user/login/'));
		}
		if ($this->form_validation->run() === TRUE) {
			header("Content-Type: application/json; charset=utf-8;");

			if (time() - $this->input->post('lastpost') < $this->config->item('timespan')) {
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
			$query = $this->topic_m->get_info_by_topic_id($data['topic_id'], 'comments');
			$callback = array(
				//'content' => stripslashes(format_content(filter_check($data['content']))),
				'content' => $this->comment_m->member_call($data['content'], $this->input->post('topic_id')),
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

			$this->comment_m->add_comment($data);
			$r_time = array(
				'replies' => 'replies+1',
				'lastpost' => time()
			);
			$this->user_m->set_uid_val($this->uid, $r_time);
			//返回callback
			$user = $this->user_m->get_user_by_uid($this->uid, 'lastpost');
			$callback['lastpost'] = @$user['lastpost'];
			echo json_encode($callback);

			//更新回复数,最后回复用户,最后回复时间,更新时间,ord时间
			$this->topic_m->set_top($this->input->post('topic_id'), $this->input->post('is_top'), 1);//已更新时间
			$this->topic_m->set_reply($this->input->post('topic_id'), $this->session->userdata('uid'));

			//回复提醒作者
			$topic = $this->topic_m->get_info_by_topic_id($data['topic_id'], 'uid');
			if ($this->uid != $topic['uid']){
				$this->load->model('notifications_m');
				$this->notifications_m->notice_insert($data['topic_id'], $this->uid,$topic['uid'], 0);
				//更新作者的提醒数
				$this->user_m->set_uid_val($topic['uid'], array('notices' => 'notices+1'));
			}
			//更新统计
			$this->stat_m->set_item_val('total_comments');
			$stats = $this->stat_m->get_item('today_topics');
			if (! is_today(@$stats['update_time'])) {
				$set_val = array(
					'value' => array(@$stats['value']),
					'update_time' => array(time())
				);
				$this->stat_m->set_item_val('yesterday_topics', $set_val);
				$value = 1;
			} else {
				$value='value+1';
			}
			$set_val2 = array(
				'value' => array($value),
				'update_time' => array(time())
			);
			$this->stat_m->set_item_val('today_topics', $set_val2);

			//更新会员积分
			$this->config->load('userset');
			$this->user_m->set_uid_val($this->uid, array('credit' => 'credit+'.$this->config->item('credit_reply')));
			$this->user_m->set_uid_val($topic['uid'], array('credit' => 'credit+'.$this->config->item('credit_reply_by')));

			//更新数据库缓存
			$this->db->cache_delete('/default', 'index');
		}
	}

	/**
	 * 删除评论
	 * @param $node_id 版块id
	 * @param $topic_id 帖子id
	 * @param $id 评论id
	 */
	public function del($node_id, $topic_id, $id)
	{
		$result = array('code' => 4001, 'msg' => "权限不足");
		if ($this->auth->is_admin() || $this->auth->is_master($node_id)){
			if ($this->comment_m->del_comment_by_id($topic_id, $id, $this->uid)){
				//redirect('topic/show/'.$topic_id);
				$result['code'] = 2001;
				$result['msg'] = "删除评论成功";
			} else {
				$result['code'] = 4002;
				$result['msg'] = "删除评论失败";
			}
		}
		header('Content-Type: application/json; charset=utf-8;');
		echo json_encode($result);
	}

	/**
	 * 编辑评论
	 * @param $node_id 版块id
	 * @param $topic_id  主题id
	 * @param $id 评论id
	 */
	public function edit($node_id, $topic_id, $id)
	{
		if(empty($node_id) || empty($topic_id) || empty($id)){
			show_message('缺少参数哟',site_url('topic/show/'.$topic_id));
		}

		$data['comment'] = $this->comment_m->get_comment_by_id($id);
		if ($this->auth->is_admin() || $this->auth->is_master($node_id) ||
			$this->auth->is_user($data['comment']['uid'])) {
			//无编辑器时的处理
			//if($this->config->item('show_editor')=='off'){
			//	$data['comment']['content'] = filter_check($data['comment']['content']);
			//	$this->load->helper('format_content');
			//	$data['comment']['content'] = format_content($data['comment']['content']);
			//	$data['comment']['content'] =br2nl($data['comment']['content'] );
			//}
			$data['comment']['content'] = br2nl($data['comment']['content'] );
			$data['comment']['content'] = $this->input->post('content') ? $this->input->post('content') : $data['comment']['content'];
			$data['comment']['node_id'] = $node_id;
			//加载form类，为调用错误函数,需view前加载
			$this->load->helper('form');
			if ($this->form_validation->run('comment/edit') === TRUE) {
				$this->load->helper('format_content');
				//数据处理
				$comment=array(
					'content'=>$this->input->post('content',true),
					'replytime'=>time()
				);
				$comment['content'] = format_content($comment['content']);
				//更新评论
				if ($this->comment_m->update_comment($id, $comment)) {
					//更新最后评论时间
					$this->topic_m->update_topic($topic_id, array('lastreply' => time()));
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
