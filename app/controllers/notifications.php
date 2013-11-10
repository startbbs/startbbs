<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Notifications
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Notifications extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('notifications_m');
		$uid = $this->session->userdata('uid');
		if(!$this->auth->is_user($uid)){
			$this->myclass->notice('alert("非法用户uid");window.location.href="'.site_url('/').'";');
			exit;
		}
	}

	public function index ()
	{
		$data['notices_list'] = $this->notifications_m->get_notifications_list($this->session->userdata('uid'),20);
		$data['title'] = '提醒用户';
		$this->load->view('notifications',$data);
		//删除数据
		if($data['notices_list']){
			$this->db->where('nuid',$this->session->userdata('uid'))->delete('notifications');
			$this->db->where('uid',$this->session->userdata('uid'))->update('users',array('notices'=>0));
		}

	}

	public function del($fid)
	{
		$uid = $this->session->userdata('uid');
		$user_fav = $this->db->get_where('favorites',array('uid'=>$uid))->row_array();
        $ids_arr = explode(",", $user_fav['content']);
        if(in_array($fid, $ids_arr)){
            foreach($ids_arr as $k=>$v){
                if($v == $fid){
                    unset($ids_arr[$k]);
                    break;
                }
            }
            $forums = count($ids_arr);
            $content = implode(',', $ids_arr);
            $data['content'] = $content;
            $data['favorites'] = $forums;
            if($this->db->where('uid', $uid)->update('favorites', $data) && $this->db->set('favorites','favorites-1',FALSE)->where('fid', $fid)->update('forums')){
				redirect($this->input->server('HTTP_REFERER'));	            
            }
            
        }
        unset($ids_arr);
	}


}
