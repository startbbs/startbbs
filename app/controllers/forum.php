<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Forum
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Forum extends SB_controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model('forum_m');
		$this->load->model('cate_m');
		$this->load->library('myclass');
	}
	public function flist ($cid, $page=1)
	{
		//权限
		if(!$this->auth->user_permit($cid)){
			$this->myclass->notice('alert("您无限访问此节点");window.location.href="'.site_url('/').'";');
		} else {
			//分页
			$limit = 10;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('forum/flist/'.$cid);
			$config['total_rows'] = $this->forum_m->count_forums($cid);
			$config['per_page'] = $limit;
			$config['first_link'] ='首页';
			$config['last_link'] ='尾页';
			$config['num_links'] = 10;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();

			//获取列表
			$data['list'] = $this->forum_m->get_forums_list($start, $limit, $cid);

			//自定义url
			$data['view_url']=array_keys($this->router->routes,'forum/view/$1');
			$data['flist_url']=array_keys($this->router->routes,'forum/flist/$1');
			if(is_array($data['list'])){
				foreach($data['list'] as $k=>$v)
				{
					$data['list'][$k]['view_url']=str_replace('(:num)',$v['fid'],$data['view_url'][0]);
					$data['list'][$k]['flist_url']=str_replace('(:num)', $v['cid'], $data['flist_url'][0]);
				}
			}
			
			$data['category'] = $this->cate_m->get_category_by_cid($cid);
			$data['title'] = strip_tags($data['category']['cname']);
			

			$this->load->view('flist', $data);
		}

	}

	public function view ($fid=1,$page=1)
	{
		
		$content = $this->forum_m->get_forum_by_fid($fid);
		if(!$content){
			$this->myclass->notice('alert("贴子不存在");window.location.href="'.site_url('/').'";');
			exit;
		} elseif(!$this->auth->user_permit($content['cid'])){//权限
			$this->myclass->notice('alert("您无限访问此节点中的贴子");history.back();');
		} else {
			//$this->output->cache(1);
			$content = $this->forum_m->get_forum_by_fid($fid);
			//取出处理
			$content['content']=stripslashes($content['content']);
			$content['content']=str_replace('&lt;pre&gt;','<pre>',$content['content']);
			$content['content']=str_replace('&lt;/pre&gt;','</pre>',$content['content']);
			
			$data['content'] = $content;
			
			//if(!$content){
			//	$this->myclass->notice('alert("贴子不存在");window.location.href="'.site_url('/').'";');
			//	exit;
			//}
			

			//更新浏览数
			$this->db->where('fid',$content['fid'])->update('forums',array('views'=>$content['views']+1));
			
			//评论分页
			$limit = 10;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('forum/view/'.$fid);
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
			$data['comment']= $this->comment_m->get_comment ($start,$limit,$fid,$this->config->item('comment_order'));

			//获取当前分类
			$data['cate']=$this->db->get_where('categories',array('cid'=>$content['cid']))->row_array();

			//上下主题
			$data['content']['previous'] = $this->forum_m->get_near_id($fid,$data['cate']['cid'],0);
			$data['content']['next'] = $this->forum_m->get_near_id($fid,$data['cate']['cid'],1);
			$data['content']['previous']=$data['content']['previous']['fid'];
			$data['content']['next']=$data['content']['next']['fid'];
			
			// 判断是不是已被收藏
			$data['in_favorites'] = '';
			$uid = $this->session->userdata('uid');
			if($uid){
				$user_fav = $this->db->get_where('favorites',array('uid'=>$uid))->row_array();
			
				if($user_fav && $user_fav['content']){
					if(strpos(' ,'.$user_fav['content'].',', ','.$fid.',') ){
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
			$data['tag_url']=array_keys($this->router->routes,'tag/index/$1');

			if(is_array(@$data['tags'])){
				foreach($data['tags'] as $k=>$v){
					$data['tag_list'][$k]['tag_title']=$v;
					$data['tag_list'][$k]['tag_url']=str_replace('(:any)',urlencode($v),$data['tag_url'][0]);
				}
			}
			
			//相关贴子
			if(isset($data['tags'])){
				$this->load->model('tag_m');
				$data['related_forum_list'] = $this->tag_m->get_related_forums_by_tag($data['tags'],10);
				
			}
			//set top
			if(@$_GET['act']=='set_top'){
				if($this->auth->is_admin() || $this->auth->is_master($content['cid'])){
					$this->forum_m->set_top($content['fid'],$content['is_top']);
					redirect('forum/view/'.$content['fid']);	
				} else {
					$this->myclass->notice('alert("你无权置顶贴子");history.go(-1);');
				}
			}
			//开启storage config
			$this->load->config('qiniu');
			$this->load->view('view', $data);
		}
	}

	public function add()
	{
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		//获取已选择过的分类名称
		$cid=($this->input->post ('cid'))?$this->input->post ('cid'):$this->uri->segment(3);
		$data['cate']=$this->db->get_where('categories',array('cid'=>$cid))->row_array();
		
		$data['title'] = '发表话题';
		$uid = $this->session->userdata('uid');
		$user = $this->user_m->get_user_by_id($uid);
		if(!$this->auth->is_login()) {
			redirect('user/login/');
		} elseif(!$this->auth->user_permit($cid)) {//权限
			$this->session->set_flashdata('error', '您无权在此节点发表话题!请重新选择节点');
		} elseif(time()-$user['lastpost']<$this->config->item('timespan')){
			$this->session->set_flashdata('error', '发帖最小间隔时间是'.$this->config->item('timespan').'秒!');
			//exit;
		} else {
			if($_POST && $this->validate_add_form()){
				$data = array(
					'title' => $this->input->post ('title',true),
					'content' => $this->input->post ('content'),
					'cid' => $cid,
					'uid' => $uid,
					'addtime' => time(),
					'updatetime' => time(),
					'lastreply' => time(),
					'views' => 0,
					'ord'=>time()
				);
				//开启审核时
				if($this->config->item('is_approve')=='on'){
					$data['is_hidden'] = 1;	
				}
				//无编辑器时的处理
				if($this->config->item('show_editor')=='off'){
					$data['content'] = filter_check($data['content']);
					$this->load->helper('format_content');
					$data['content'] = format_content($data['content']);
					
				}
				//标签
				$this->load->model('tag_m');
				if($this->config->item('auto_tag') =='on'){
					//自动获取关键词tag
					$data['keywords'] = $this->tag_m->get_tag_auto(strip_tags($data['title']), strip_tags($data['content']));
				} else{
					$data['keywords'] = $this->input->post ('keywords', true);
				}
				
				
				if($this->forum_m->add($data)){
					//最新贴子id
					$new_fid = $this->db->insert_id();
					
					//入tag表
					$this->tag_m->insert_tag($data['keywords'], $new_fid);
					
					//更新贴子数
					$cid = $this->input->post ('cid');
					$category = $this->cate_m->get_category_by_cid($cid);
					$this->db->where('cid',$cid)->update('categories',array('listnum'=>$category['listnum']+1));

					//更新数据库缓存
					$this->db->cache_delete('/default', 'index');
					//更新发贴人的贴子数/最后发贴时间
					$this->db->set('lastpost',time(),false)->set('forums','forums+1',false)->where('uid',$uid)->update('users');
				//审核未开启时
				if($this->config->item('is_approve')=='off'){
					redirect('forum/view/'.$new_fid);	
				} else {
					$this->myclass->notice('alert("贴子通过审核才能在前台显示");window.location.href="'.site_url().'";');	
				}
				exit;
				}

			}
		}
		$data['category'] = $this->cate_m->get_all_cates();
		//开启storage config
		$this->load->config('qiniu');
		$this->load->view('add',$data);
		
	}

	
	private function validate_add_form(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', '标题' , 'trim|required|strip_tags|htmlspecialchars|min_length[4]|max_length[80]');
		$this->form_validation->set_rules('content', '内容' , 'trim|required|min_length[6]|max_length['.$this->config->item('words_limit').']');
		$this->form_validation->set_rules('cid', '栏目' , 'trim|required');
		
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
	public function edit($fid)
	{
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		$data['title'] = '编辑话题';
		$data['item'] = $this->forum_m->get_forum_by_fid($fid);

		//权限修改判断
		if(!$this->auth->is_login()) {
			$this->myclass->notice('alert("请登录后再编辑");window.location.href="'.site_url('user/login').'";');
		} elseif($this->auth->is_user($data['item']['uid']) || $this->auth->is_admin() || $this->auth->is_master($data['item']['cid'])){
			//对内容进行br转换
			$this->load->helper('br2nl');
			$data['item']['content']=br2nl($data['item']['content']);
			//反转义
			$data['item']['content']=stripslashes($data['item']['content']);

			if($_POST && $this->validate_add_form()){
				$str = array(
					'title' => $this->input->post('title',true),
					'content' => $this->input->post('content'),
					'cid' => $this->input->post('cid'),
					'updatetime' => time(),
				);

				//无编辑器时的处理
				if($this->config->item('show_editor')=='off'){
					$str['content'] = filter_check($str['content']);
					$this->load->helper('format_content');
					$str['content'] = format_content($str['content']);
				}
				if($this->forum_m->update_forum($fid,$str)){
					$this->myclass->notice('alert("修改成功");window.location.href="'.site_url('forum/view/'.$fid).'";');
				}
			}
		} else {
			$this->myclass->notice('alert("你无权修改此贴子");history.go(-1);');
		}
		//获取所有分类
		$data['cates'] = $this->cate_m->get_all_cates();
		//获取当前分类(包括已选择)
		$cid = ($this->input->post ('cid'))?$this->input->post ('cid'):$data['item']['cid'];
		$data['cate']=$this->db->get_where('categories',array('cid'=>$cid))->row_array();
		//标题编辑(包括已输入)
		$data['item']['title'] = ($this->input->post ('title'))?$this->input->post ('title'):$data['item']['title'];
		//内容编辑(包括已输入)
		$data['item']['content'] = ($this->input->post ('content'))?$this->input->post ('content'):$data['item']['content'];
		$this->load->view('edit', $data);
	}
	public function del($fid,$cid,$uid)
	{
		$data['title'] = '删除贴子';
		//权限修改判断
		if($this->auth->is_admin() || $this->auth->is_master($cid)){
			$this->myclass->notice('alert("确定要删除此话题吗！");');
			//删除贴子及它的回复
			if($this->forum_m->del_forum($fid,$cid,$uid)){
			$this->load->model('comment_m');
			$this->comment_m->del_comments_by_fid($fid,$uid);
			//更新数据库缓存
			$this->db->cache_delete('/default', 'index');

			$this->myclass->notice('alert("删除贴子成功！");window.location.href="'.site_url('/forum/flist/'.$cid).'";');
			}
		}else{
			$this->myclass->notice('alert("您无权删除此贴");window.location.href="'.site_url('/forum/view/'.$fid).'";');
			exit;
			}
		}

}