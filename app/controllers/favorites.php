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
			$this->myclass->notice('alert("请登录后再查看");window.location.href="'.site_url('user/login').'";');
			exit;
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
		$fids = implode(',', $id_arr);

		$this->load->model('favorites_m');
		if(@$user_fav['content']){
			$data['fav_list'] = $this->favorites_m->get_favorites_list($start, $limit, $fids);
		}


		$data['title'] = '贴子收藏';
		$this->load->view('favorites',$data);
	}
	public function add($fid)
	{
		//获取收藏数据
		$uid = $this->session->userdata('uid');
		$user_fav = $this->db->get_where('favorites',array('uid'=>$uid))->row_array();
		
//		var_dump($user_fav);
		//收藏操作
		if(@$user_fav['uid']){
			if($user_fav['content']){
				$ids_arr = explode(",", @$user_fav['content']);
				if(!in_array($fid, $ids_arr)){
					array_unshift($ids_arr, $fid);
					//$forums = count($ids_arr);
					$content = implode(',', $ids_arr);
					if($this->db->where('uid', $uid)->update('favorites',array('content'=>$content)) && $this->db->where('uid', $uid)->set('favorites','favorites+1',FALSE)->update('favorites') && $this->db->where('fid', $fid)->set('favorites','favorites+1',FALSE)->update('forums')){
						redirect('forum/view/'.$fid);
					}
				}
				unset($ids_arr);
			} else {
				$data['content'] = $fid;
				$data['favorites'] =1;
				if($this->db->where('uid', $uid)->update('favorites',$data) && $this->db->where('fid', $fid)->set('favorites','favorites+1',FALSE)->update('forums')){
					redirect('forum/view/'.$fid);
				}
			}
		} else{
			$data['content'] = $fid;
            $data['favorites'] = 1;
            $data['uid'] = $uid;
            if($this->db->insert('favorites', $data) && $this->db->set('favorites','favorites+1',FALSE)->where('fid', $fid)->update('forums')){
				redirect('forum/view/'.$fid);
            }
            
		}
		$data['title'] = '贴子收藏';
		$this->load->view('favorites',$data);
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
            //$forums = count($ids_arr);
            $content = implode(',', $ids_arr);
            if($this->db->where('uid', $uid)->update('favorites',array('content'=>$content)) && $this->db->where('uid', $uid)->set('favorites','favorites-1',FALSE)->update('favorites') && $this->db->set('favorites','favorites-1',FALSE)->where('fid', $fid)->update('forums')){
				redirect($this->input->server('HTTP_REFERER'));	            
            }
            
        }
        unset($ids_arr);
	}


}
