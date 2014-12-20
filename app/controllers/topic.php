<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	topic
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class topic extends SB_controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model('topic_m');
		$this->load->model('cate_m');
		$this->load->library('myclass');
		$this->load->library('form_validation');
	}

	public function show ($topic_id=1,$page=1)
	{
		
		$content = $this->topic_m->get_topic_by_topic_id($topic_id);
		if(!$content){
			show_message('贴子不存在',site_url('/'));
		} elseif(!$this->auth->user_permit($content['node_id'])){//权限
			show_message('您无权访问此节点中的贴子');
		} else {
			//$this->output->cache(1);
			$content = $this->topic_m->get_topic_by_topic_id($topic_id);
			//取出处理
			$content['content']=stripslashes($content['content']);

			
			$data['content'] = $content;
			
			//if(!$content){
			//	$this->myclass->notice('alert("贴子不存在");window.location.href="'.site_url('/').'";');
			//	exit;
			//}
			

			//更新浏览数
			$this->db->where('topic_id',$content['topic_id'])->update('topics',array('views'=>$content['views']+1));
			
			//评论分页
			$limit = 10;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('topic/show/'.$topic_id);
			$config['total_rows'] = @$content['comments'];
			$config['per_page'] = $limit;
			$config['prev_link'] = '&larr;';
			$config['first_link'] ='首页';
			$config['last_link'] ='尾页';
			$config['prev_tag_open'] = '<li class=\'prev\'>';
			$config['prev_tag_close'] = '</li';
			$config['cur_tag_open'] = '<li class=\'active\'><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li class=\'next\'>';
			$config['next_tag_close'] = '</li>';
	        $config['last_link'] = '尾页';
			$config['last_tag_open'] = '<li class=\'last\'>';
			$config['last_tag_close'] = '</li>';
			$config['num_links'] = 10;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['page'] = $page;
			$data['pagination'] = $this->pagination->create_links();
			//获取评论
			$this->load->model ( 'comment_m' );
			$data['comment']= $this->comment_m->get_comment ($start,$limit,$topic_id,$this->config->item('comment_order'));

			//获取当前分类
			$data['cate']=$this->db->get_where('nodes',array('node_id'=>$content['node_id']))->row_array();

			//上下主题
			$data['content']['previous'] = $this->topic_m->get_near_id($topic_id,$data['cate']['node_id'],0);
			$data['content']['next'] = $this->topic_m->get_near_id($topic_id,$data['cate']['node_id'],1);
			$data['content']['previous']=$data['content']['previous']['topic_id'];
			$data['content']['next']=$data['content']['next']['topic_id'];
			
			// 判断是不是已被收藏
			$data['in_favorites'] = '';
			$uid = $this->session->userdata('uid');
			if($uid){
				$user_fav = $this->db->get_where('favorites',array('uid'=>$uid))->row_array();
			
				if($user_fav && $user_fav['content']){
					if(strpos(' ,'.$user_fav['content'].',', ','.$topic_id.',') ){
						$data['in_favorites'] = '1';
					}
				}
			}
			//关键字tag
			if($content['keywords']){
				$data['tags'] = explode(',',$content['keywords']);
				$data['content']['keywords'] = $content['keywords'];
			} else{
				$data['content']['keywords'] = $content['title'];
			}
			//描述
			$data['content']['description']= sb_substr(cleanhtml($content['content']),200);

			//自定义tag_url
			$data['tag_url']=array_keys($this->router->routes,'tag/show/$1');

			if(is_array(@$data['tags'])){
				foreach($data['tags'] as $k=>$v){
					$data['tag_list'][$k]['tag_title']=$v;
					$data['tag_list'][$k]['tag_url']=str_replace('(:any)',urlencode($v),$data['tag_url'][0]);
				}
			}
			
			//相关贴子
			if(isset($data['tags'])){
				$this->load->model('tag_m');
				$data['related_topic_list'] = $this->tag_m->get_related_topics_by_tag($data['tags'],10);
				
			}
			//set top
			if(@$_GET['act']=='set_top'){
				if($this->auth->is_admin() || $this->auth->is_master($content['node_id'])){
					$this->topic_m->set_top($content['topic_id'],$content['is_top']);
					redirect('topic/show/'.$content['topic_id']);	
				} else {
					show_message('你无权置顶贴子');
				}
			}
			//开启storage config
			$this->load->config('qiniu');
			//获取分类
			$this->load->model('cate_m');
			$data['catelist'] =$this->cate_m->get_all_cates();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('topic_show', $data);
		}
	}

	public function add()
	{
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		//获取已选择过的分类名称
		$node_id=($this->input->post ('node_id'))?$this->input->post ('node_id'):$this->uri->segment(3);
		$data['cate']=$this->db->get_where('nodes',array('node_id'=>$node_id))->row_array();
		
		$data['title'] = '发表话题';
		$uid = $this->session->userdata('uid');
		$this->load->model ('user_m');
		$user = $this->user_m->get_user_by_id($uid);
		if(!$this->auth->is_login()) {
			redirect('user/login/');
		}
		if(!$this->auth->user_permit($node_id)) {//权限
			$this->session->set_flashdata('error', '您无权在此节点发表话题!请重新选择节点');
			exit;
		}
		if($_POST && $this->form_validation->run() === TRUE){
			if(time()-$user['lastpost']<$this->config->item('timespan')){
				$this->session->set_flashdata('error', '发帖最小间隔时间是'.$this->config->item('timespan').'秒!');
				redirect('topic/add');
			}
			$data = array(
				'title' => $this->input->post ('title'),
				'content' => $this->input->post ('content'),
				'node_id' => $node_id,
				'uid' => $uid,
				'addtime' => time(),
				'updatetime' => time(),
				'lastreply' => time(),
				'views' => 0,
				'ord'=>time()
			);
			$this->load->helper('format_content');
			$data['content']=format_content($data['content']);
			//开启审核时
			if($this->config->item('is_approve')=='on'){
				$data['is_hidden'] = 1;	
			}
			
			//标签
			$this->load->model('tag_m');
			if($this->config->item('auto_tag') =='on'){
				//自动获取关键词tag
				$data['keywords'] = $this->tag_m->get_tag_auto(strip_tags($data['title']), strip_tags($data['content']));
			} else{
				$data['keywords'] = $this->input->post ('keywords', true);
			}
			
			
			if($this->topic_m->add($data)){
				//最新贴子id
				$new_topic_id = $this->db->insert_id();
				
				//入tag表
				$this->tag_m->insert_tag($data['keywords'], $new_topic_id);
				
				//更新贴子数
				$node_id = $this->input->post ('node_id');
				$category = $this->cate_m->get_category_by_node_id($node_id);
				$this->db->where('node_id',$node_id)->update('nodes',array('listnum'=>$category['listnum']+1));

				//更新数据库缓存
				$this->db->cache_delete('/default', 'index');
				//更新发贴人的贴子数/最后发贴时间
				$this->db->set('lastpost',time(),false)->set('topics','topics+1',false)->where('uid',$uid)->update('users');
				//更新会员积分
				$this->config->load('userset');
				$this->user_m->update_credit($uid,$this->config->item('credit_post'));
				//审核未开启时
				if($this->config->item('is_approve')=='off'){
					redirect('topic/show/'.$new_topic_id);	
				} else {
					show_message('贴子通过审核才能在前台显示',site_url());	
				}
			}

		}
		$data['category'] = $this->cate_m->get_all_cates();

		//action
		$data['action'] = 'add';
		//开启storage config
		$this->load->config('qiniu');
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('topic_add',$data);
		
	}

	public function edit($topic_id)
	{
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		$data['title'] = '编辑话题';
		$data['item'] = $this->topic_m->get_topic_by_topic_id($topic_id);

		//权限修改判断
		if(!$this->auth->is_login()) {
			show_message('请登录后再编辑',site_url('user/login'));
		}
		if($this->auth->is_user($data['item']['uid']) || $this->auth->is_admin() || $this->auth->is_master($data['item']['node_id'])){
			//对内容进行br转换
			$this->load->helper('br2nl');
			$data['item']['content']=br2nl($data['item']['content']);
			//反转义
			$data['item']['content']=stripslashes($data['item']['content']);
			//反format
			$data['item']['content'] = decode_format($data['item']['content']);	
			//获取所有分类
			$data['cates'] = $this->cate_m->get_all_cates();
			//获取当前分类(包括已选择)
			$node_id = ($this->input->post ('node_id'))?$this->input->post ('node_id'):$data['item']['node_id'];
			$data['cate']=$this->db->get_where('nodes',array('node_id'=>$node_id))->row_array();
			//标题编辑(包括已输入)
			$data['item']['title'] = ($this->input->post ('title'))?$this->input->post ('title'):$data['item']['title'];
			//内容编辑(包括已输入)
			$data['item']['content'] = ($this->input->post ('content'))?$this->input->post ('content'):$data['item']['content'];

			if($this->form_validation->run('topic/add') === TRUE){
				$str = array(
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'node_id' => $this->input->post('node_id'),
					'updatetime' => time(),
				);

				$this->load->helper('format_content');
				$str['content'] = format_content($str['content']);
				if($this->topic_m->update_topic($topic_id,$str)){
					show_message('修改成功',site_url('topic/show/'.$topic_id),1);
				}
			}
			//开启storage config
			$this->load->config('qiniu');
	        $data['csrf_name'] = $this->security->get_csrf_token_name();
	        $data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('topic_edit', $data);
		}else{
			show_message('你无权修改此贴子');
		}
	}
	public function del($topic_id,$node_id,$uid)
	{
		$data['title'] = '删除贴子';
		//权限修改判断
		if($this->auth->is_admin() || $this->auth->is_master($node_id)){

			//$this->myclass->notice('alert("确定要删除此话题吗！");');
			//删除贴子及它的回复
			if($this->topic_m->del_topic($topic_id,$node_id,$uid)){
				$this->load->model('comment_m');
				$this->comment_m->del_comments_by_topic_id($topic_id,$uid);
				//更新会员积分
				$this->config->load('userset');
				$this->load->model ('user_m');
				$this->user_m->update_credit($uid,$this->config->item('credit_del'));
				//更新数据库缓存
				$this->db->cache_delete('/default', 'index');
				show_message('删除贴子成功！',site_url('/node/show/'.$node_id));
			}
		}else{
			show_message('您无权删除此贴',site_url('/topic/show/'.$topic_id));
			}
		}

}