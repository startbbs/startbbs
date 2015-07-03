<?php

#doc
#	classname:	Comment_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Comment_m extends SB_Model
{

	const TB_COMMENTS = "comments";
	const TB_TOPICS = "topics";
	const TB_USERS = "users";
	const TB_STAT = "site_stats";

	function __construct ()
	{
		parent::__construct();
	}

	public function add_comment ($data)
	{
		$this->db->insert(self::TB_COMMENTS, $data);
	}

    /**
     * 获取评论
     * @param $page
     * @param $limit
     * @param $topic_id
     * @param string $order
     * @return mixed
     */
	function get_comment($page,$limit,$topic_id,$order='desc'){
		$this->db->select('comments.*, u.uid, u.username, u.avatar, u.signature');
		$query=$this->db->from('comments')
		->where('topic_id',$topic_id)
		->join ( 'users u', "u.uid=comments.uid" )
		->order_by('comments.replytime',$order)
		->limit($limit,$page)
		->get();
		$comment_list = $query->result_array();

        //@提醒功能
        if (! empty($comment_list)) {
            $tmp = $comment_list;
            $comment_list = array();
            foreach ($tmp as $comment) {
                $comment['content'] = $this->comment_m->member_call($comment['content']);
                $comment_list[] = $comment;
            }
        }
        return $comment_list;
	}
	
	public function get_comments_by_uid($uid,$num)
	{
		$this->db->select('c.*, t.topic_id, t.title, t.addtime, u.uid, u.username');
		$this->db->from('comments c');
		$this->db->where('c.uid',$uid);
		$this->db->join('topics t', 't.topic_id = c.topic_id','left');
		$this->db->join('users u', 'u.uid = t.uid');
		$this->db->limit($num);
		$this->db->order_by('replytime','desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function del_comments_by_topic_id($topic_id,$uid)
	{
		//更新用户中的回复数
		$comments=$this->db->select('uid')->where('topic_id',$topic_id)->get('comments')->result_array();
		if($comments){
			$uids=array_count_values(array_column($comments, 'uid'));
			foreach($uids as $k =>$v)
			{
				$user[$k]['uid']=$k;
				$user[$k]['replies']=$v;
			}
			$this->db->update_batch('users', $user, 'uid');
			
			$this->db->where('topic_id', $topic_id)->delete('comments');
			$rnum = $this->db->affected_rows();
			$this->db->set('value','value-'.$rnum,FALSE)->where('item','total_comments')->update('site_stats');
		}
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	/**
	 * 通过评论id获取评论
	 * @param $id
	 * @return mixed
	 */
	function get_comment_by_id ($id)
	{
		$this->db->select('id,topic_id,content,uid')->where('id',$id);
		$query = $this->db->get(self::TB_COMMENTS);
		return $query->row_array();
	}

	/**
	 * 更新主题评论数，用户评论数，统计
	 * @param $tid 主题id
	 * @param $id 评论id
	 * @param $uid 用户id
	 * @return bool
	 */
	public function del_comment_by_id($tid, $id, $uid) {
		$this->db->where('id',$id)->delete(self::TB_COMMENTS);
		if ($this->db->affected_rows() == 0) return FALSE;

		$this->db->set('comments', 'comments-1', FALSE)->where('topic_id',$tid)->update(self::TB_TOPICS);
		$this->db->set('replies', 'replies-1', FALSE)->where('uid', $uid)->update(self::TB_USERS);
		$this->db->set('value', 'value-1', FALSE)->where('item','total_comments')->update(self::TB_STAT);

		return TRUE;
	}

	/**
	 * 更新评论
	 * @param $id 评论id
	 * @param $comment 评论内容
	 * @return mixed
	 */
	public function update_comment($id, $comment) {
		return $this->db->where('id',$id)->update(self::TB_COMMENTS, $comment);
	}

    /**
     * @会员功能
     * @param $content 评论内容
     * @param $topic_id 文章编号(带此参数则为添加并提醒)
     * @return mixed|string
     */
    public function member_call($content, $topic_id = '') {
        $content = stripslashes($content);
        $pattern = "/@([^@^\\s^:]{1,})([\\s\\:\\,\\;]{0,1})/";
        preg_match_all($pattern, $content, $matches);
        $matches[1] = array_unique($matches[1]);
        foreach ($matches [1] as $u) {
            if ($u) {
                $res = $this->user_m->get_user_msg('', $u) ;
                if ($res['uid']) {
                    $search[] = '@'.$u;
                    $replace[] = '<a target="_blank" href="'.site_url('user/profile/'.$res['uid']).'" >@' . $u . '</a>';
                    //私信提醒
                    if (! empty($topic_id)) {
                        if ($this->uid != $res['uid']) {
                            //@提醒someone
                            $this->load->model('notifications_m');
                            $this->notifications_m->notice_insert($topic_id, $this->uid, $res['uid'],1);
                            //更新接收人的提醒数
                            $this->user_m->set_uid_val($res['uid'], array('notices' => 'notices+1'));
                        }
                    }
                }
            }
        }
        $content = str_replace(@$search, @$replace, $content);
        return $content;
    }
}

	
