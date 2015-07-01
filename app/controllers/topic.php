<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	topic
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

/**
 * Class topic
 * @author: Skiychan <dev@skiy.net>
 * @website: www.skiy.net
 * @QQ: 1005043848
 */
class topic extends SB_controller
{
	public function __construct ()
	{
		parent::__construct();
		$models = array('topic_m', 'cate_m', 'nodes_m', 'tag_m', 'user_m', 'comment_m', 'stat_m');
		$this->load->model($models);
		$this->load->library('myclass');
		$this->load->library('form_validation');
	}

	/**
	 * 转跳
	 */
	public function index() {
		show_message('贴子不存在',site_url('/'));
	}

	/**
	 * @param int $topic_id 主题
	 * @param int $page 页码
	 */
	public function show($topic_id=1 ,$page=1)
	{

		$content = $this->topic_m->get_topic_by_topic_id($topic_id);
		if (! $content) {
			show_message('贴子不存在',site_url('/'));
		} else if(! $this->auth->user_permit($content['node_id'])) {//权限
			show_message('您无权访问此节点中的贴子');
		} else {
			//$this->output->cache(1);
			$content = $this->topic_m->get_topic_by_topic_id($topic_id);
			//取出处理
			$content['content'] = stripslashes($content['content']);
			$data['content'] = $content;
			
			//if(!$content){
			//	$this->myclass->notice('alert("贴子不存在");window.location.href="'.site_url('/').'";');
			//	exit;
			//}

			//更新浏览数
			$this->topic_m->set_views($content['topic_id']);

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
			//$this->pagination->initialize($config);
			
			$start = ($page - 1) * $limit;
			$data['page'] = $page;
			$data['pagination'] = $this->pagination->create_links();
			//获取评论
			$data['comment']= $this->comment_m->get_comment($start,$limit,$topic_id,$this->config->item('comment_order'));

			//获取当前分类
			$data['cate'] = $this->nodes_m->get_cat($content['node_id']);

			//上下主题
			$data['content']['previous'] = $this->topic_m->get_near_id($topic_id,$data['cate']['node_id'], 0);
			$data['content']['next'] = $this->topic_m->get_near_id($topic_id,$data['cate']['node_id'], 1);
			$data['content']['previous'] = $data['content']['previous']['topic_id'];
			$data['content']['next'] = $data['content']['next']['topic_id'];
			
			// 判断是不是已被收藏
			$data['in_favorites'] = '';
			$uid = $this->session->userdata('uid');
			if ($uid) {
				$user_fav = $this->db->get_where('favorites',array('uid'=>$uid))->row_array();
				if ($user_fav && $user_fav['content']) {
					if (strpos(' ,'.$user_fav['content'].',', ','.$topic_id.',')) {
						$data['in_favorites'] = '1';
					}
				}
			}
			//关键字tag
			if ($content['keywords']) {
				$data['tags'] = explode(',',$content['keywords']);
				$data['content']['keywords'] = $content['keywords'];
			} else {
				$data['content']['keywords'] = $content['title'];
			}
			//描述
			$data['content']['description'] = sb_substr(cleanhtml($content['content']), 200);

			//自定义tag_url
			$data['tag_url'] = array_keys($this->router->routes, 'tag/show/$1');

			if (is_array(@$data['tags'])) {
				foreach($data['tags'] as $k => $v) {
					$data['tag_list'][$k]['tag_title'] = $v;
					$data['tag_list'][$k]['tag_url'] = str_replace('(:any)',urlencode($v),$data['tag_url'][0]);
				}
			}
			
			//标签
			if (isset($data['tags'])) {
				$data['related_topic_list'] = $this->tag_m->get_related_topics_by_tag($data['tags'], 10);
			}
			//置顶
			if (@$_GET['act'] == 'set_top') {
				if ($this->auth->is_admin() || $this->auth->is_master($content['node_id'])) {
					$this->topic_m->set_top($content['topic_id'], $content['is_top']);
					redirect('topic/show/'.$content['topic_id']);	
				} else {
					show_message('你无权置顶贴子');
				}
			}
			//开启storage config
			$this->load->config('qiniu');
			$data['catelist'] =$this->cate_m->get_all_cates();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('topic_show', $data);
		}
	}

	/**
	 * 添加
	 */
	public function add()
	{
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		//获取已选择过的分类名称
		$node_id = $this->input->post('node_id') ? $this->input->post ('node_id') : $this->uri->segment(3);
		$data['cate'] = $this->nodes_m->get_cat($node_id);
		
		$data['title'] = '发表话题';
		$uid = $this->session->userdata('uid');
		$user = $this->user_m->get_user_by_uid($uid);
		//未登陆
		if (! $this->auth->is_login()) {
			redirect('user/login/');
		}
		//权限
		if (! $this->auth->user_permit($node_id)) {
			$this->session->set_flashdata('error', '您无权在此节点发表话题!请重新选择节点');
			exit;
		}
		if ($_POST && $this->form_validation->run() === TRUE){
			if (time() - $user['lastpost'] < $this->config->item('timespan')){
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
			$data['content'] = format_content($data['content']);
			//开启审核时
			if($this->config->item('is_approve')=='on'){
				$data['is_hidden'] = 1;	
			}
			//自动获取关键词tag
			if($this->config->item('auto_tag') =='on'){
				$data['keywords'] = $this->tag_m->get_tag_auto(strip_tags($data['title']), strip_tags($data['content']));
			} else{
				$data['keywords'] = $this->input->post('keywords', true);
			}
			//主题添加
			if ($this->topic_m->add($data)) {
				//最新贴子id
				$new_topic_id = $this->db->insert_id();
				//入tag表
				$this->tag_m->insert_tag($data['keywords'], $new_topic_id);
				//贴子数递增
				$this->nodes_m->set_increase($node_id, 'listnum');
				//更新统计
				$this->stat_m->set_item_val('total_topics');
				$stats = $this->stat_m->get_item('today_topics');
				//今天
				if(! is_today(@$stats['update_time'])){
					$set_val1 = array(
						'value' => array(@$stats['value']),
						'update_time' => array(time())
					);
					$this->stat_m->set_item_val('yesterday_topics', $set_val1);
					$value = 1;
				} else{
					$value = 'value+1';
				}
				$set_val2 = array(
					'value' => array($value),
					'update_time' => array(time())
				);
				$this->stat_m->set_item_val('today_topics', $set_val2);
				//更新数据库缓存
				$this->db->cache_delete('/default', 'index');
				$this->config->load('userset');
				$set_u_val = array(
					'lastpost' => time(),
					'topics' => 'topics+1',
					'credit' => 'credit+'.$this->config->item('credit_post')
				);
				//更新发贴人的贴子数/最后发贴时间/会员积分
				$this->user_m->set_uid_val($uid, $set_u_val);
				//审核未开启时
				if ($this->config->item('is_approve') == 'off') {
					redirect('topic/show/'.$new_topic_id);	
				} else {
					show_message('主题通过审核才能在前台显示',site_url());
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

	/**
	 * 编辑
	 * @param $topic_id
	 */
	public function edit($topic_id)
	{
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		$data['title'] = '编辑主题';
		$data['item'] = $this->topic_m->get_topic_by_topic_id($topic_id);

		//用户登陆判断
		if (! $this->auth->is_login()) {
			show_message('请登录后再编辑',site_url('user/login'));
		}
		//主题权限判断
		if ($this->auth->is_user($data['item']['uid']) ||
			$this->auth->is_admin() ||
			$this->auth->is_master($data['item']['node_id'])) {

			//对内容进行br转换
			$this->load->helper('br2nl');
			$data['item']['content'] = br2nl($data['item']['content']);
			//反转义
			$data['item']['content'] = stripslashes($data['item']['content']);
			//反format
			$data['item']['content'] = decode_format($data['item']['content']);	
			//获取所有分类
			$data['cates'] = $this->cate_m->get_all_cates();
			//获取当前分类(包括已选择)
			$node_id = $this->input->post('node_id') ? $this->input->post ('node_id') : $data['item']['node_id'];
			//取分类
			$data['cate'] = $this->nodes_m->get_cat($node_id);
			//标题编辑(包括已输入)
			$data['item']['title'] = $this->input->post ('title') ? $this->input->post ('title') : $data['item']['title'];
			//内容编辑(包括已输入)
			$data['item']['content'] = $this->input->post ('content') ? $this->input->post ('content') : $data['item']['content'];

			//表单验证
			if ($this->form_validation->run('topic/add') === TRUE){
				$str = array(
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'node_id' => $this->input->post('node_id'),
					'updatetime' => time(),
				);

				$this->load->helper('format_content');
				$str['content'] = format_content($str['content']);
				if ($this->topic_m->update_topic($topic_id, $str)) {
					show_message('修改成功',site_url('topic/show/'.$topic_id), 1);
				}
			}
			//开启storage config
			$this->load->config('qiniu');
	        $data['csrf_name'] = $this->security->get_csrf_token_name();
	        $data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('topic_edit', $data);
		} else {
			show_message('你无权修改此主题');
		}
	}

	/**
	 * 删除主题
	 * @param $topic_id
	 * @param $node_id
	 * @param $uid
	 */
	public function del($topic_id,$node_id,$uid) {
		$data['title'] = '删除主题';
		//权限修改判断
		if ($this->auth->is_admin() || $this->auth->is_master($node_id)) {

			//$this->myclass->notice('alert("确定要删除此话题吗！");');
			//删除贴子及它的回复
			if ($this->topic_m->del_topic($topic_id, $node_id, $uid)) {
				$this->comment_m->del_comments_by_topic_id($topic_id, $uid);
				//更新统计
				$this->stat_m->set_item_val('total_topics', array('value' => 'value-1'));
				$stats = $this->stat_m->get_item('today_topics');
				$value = is_today(@$stats['update_time']) ? 'value-1' : 0;
				$this->stat_m->set_item_val('today_topics', array('value' => array($value), 'update_time' => array(time())));
				//更新会员积分
				$this->config->load('userset');
				$this->user_m->set_uid_val($uid, array('credit' => 'credit+'.$this->config->item('credit_del')));
				//更新数据库缓存
				$this->db->cache_delete('/default', 'index');
				show_message('删除主题成功', site_url('/node/show/' . $node_id));
			}
		} else {
			show_message('您无权删除此主题', site_url('/topic/show/' . $topic_id));
		}
	}
}