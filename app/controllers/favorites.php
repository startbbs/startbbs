<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Favorites
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Favorites extends SB_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$uid = $this->session->userdata('uid');
		if(!$this->auth->is_user($uid)){
			show_message('请登录后再查看',site_url('user/login'));
		}
	}

	public function index ($page=1)
	{

		//分页
		$limit = 10;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('favorites/index');
		$uid = $this->session->userdata('uid');
		$user_fav = $this->db->get_where('favorites',array('uid'=>$uid))->row_array();
		$config['total_rows'] = @$user_fav['favorites'];
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

		//获取列表

		$to = $start+$limit;
		if(@$user_fav['favorites'] > 1){
	        $id_arr = array_slice(explode(',', $user_fav['content']),$start,10);
	    }else{
	        $id_arr = array(@$user_fav['content']);
	    }
		$topic_ids = implode(',', $id_arr);

		$this->load->model('favorites_m');
		if(@$user_fav['content']){
			$data['fav_list'] = $this->favorites_m->get_favorites_list($start, $limit, $topic_ids);
		}


		$data['title'] = '贴子收藏';
		$this->load->view('favorites',$data);
	}
	public function add($topic_id)
	{
		//获取收藏数据
		$uid = $this->session->userdata('uid');
		$user_fav = $this->db->get_where('favorites',array('uid'=>$uid))->row_array();
		
//		var_dump($user_fav);
		//收藏操作
		if(@$user_fav['uid']){
			if($user_fav['content']){
				$ids_arr = explode(",", @$user_fav['content']);
				if(!in_array($topic_id, $ids_arr)){
					array_unshift($ids_arr, $topic_id);
					//$topics = count($ids_arr);
					$content = implode(',', $ids_arr);
					$this->db->where('uid', $uid)->update('favorites',array('content'=>$content));
					$this->db->where('uid', $uid)->set('favorites','favorites+1',FALSE)->update('favorites');
					$this->db->where('uid', $uid)->set('favorites','favorites+1',FALSE)->update('users');
					$this->db->where('topic_id', $topic_id)->set('favorites','favorites+1',FALSE)->update('topics');
				}
				unset($ids_arr);
			} else {
				$data['content'] = $topic_id;
				$data['favorites'] =1;
				$this->db->where('uid', $uid)->update('favorites',$data);
				$this->db->where('uid', $uid)->set('favorites','favorites+1',FALSE)->update('users');
				$this->db->where('topic_id', $topic_id)->set('favorites','favorites+1',FALSE)->update('topics');
			}
		} else{
			$data['content'] = $topic_id;
            $data['favorites'] = 1;
            $data['uid'] = $uid;
            $this->db->insert('favorites', $data);
            $this->db->where('uid', $uid)->set('favorites','favorites+1',FALSE)->update('users');
            $this->db->set('favorites','favorites+1',FALSE)->where('topic_id', $topic_id)->update('topics');
            
		}
		$userinfo=$this->db->select('favorites')->get_where('users',array('uid'=>$uid))->row_array();
		$this->session->set_userdata('favorites', @$userinfo['favorites']);
		redirect('topic/show/'.$topic_id);
	}

	public function del($topic_id)
	{
		$uid = $this->session->userdata('uid');
		$user_fav = $this->db->get_where('favorites',array('uid'=>$uid))->row_array();
        $ids_arr = explode(",", $user_fav['content']);
        if(in_array($topic_id, $ids_arr)){
            foreach($ids_arr as $k=>$v){
                if($v == $topic_id){
                    unset($ids_arr[$k]);
                    break;
                }
            }
            //$topics = count($ids_arr);
            $content = implode(',', $ids_arr);
            if($this->db->where('uid', $uid)->update('favorites',array('content'=>$content)) && $this->db->where('uid', $uid)->set('favorites','favorites-1',FALSE)->update('favorites') && $this->db->where('uid', $uid)->set('favorites','favorites-1',FALSE)->update('users') && $this->db->set('favorites','favorites-1',FALSE)->where('topic_id', $topic_id)->update('topics')){
				$userinfo=$this->db->select('favorites')->get_where('users',array('uid'=>$uid))->row_array();
				$this->session->set_userdata('favorites', @$userinfo['favorites']);
				redirect($this->input->server('HTTP_REFERER'));	            
            }
            
        }
        unset($ids_arr);
	}


}
