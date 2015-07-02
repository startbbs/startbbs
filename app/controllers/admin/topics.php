<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topics extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('cate_m');
		$this->load->model('topic_m');
		$this->load->model('comment_m');
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('非管理员或未登录',site_url('admin/login/do_login'));
		}

	}

	public function index ($page=1)
	{
		$data['title'] = '话题管理';
		//分页
		$limit = 20;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('admin/topics/index/');
		$config['total_rows'] = $this->db->count_all('topics');
		$config['per_page'] = $limit;
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li class=\'prev\'>';
		$config['prev_tag_close'] = '</li';
		$config['cur_tag_open'] = '<li class=\'active\'><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li class=\'next\'>';
		$config['next_tag_close'] = '</li>';
        $config['first_link'] = '首页';
		$config['first_tag_open'] = '<li class=\'first\'>';
		$config['first_tag_close'] = '</li>';
        $config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li class=\'last\'>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 10;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		$data['topics'] = $this->topic_m->get_all_topics($start, $limit);
		
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('topics', $data);
		
	}
	public function del($topic_id,$node_id,$uid)
	{
		$data['title'] = '删除贴子';
		//$this->myclass->notice('alert("确定要删除此话题吗！");');
		//删除贴子及它的回复
		if($this->topic_m->del_topic($topic_id,$node_id,$uid)){
		$this->comment_m->del_comments_by_topic_id($topic_id,$uid);
		show_message('删除贴子成功！',site_url('admin/topics'),1);
		}

	}

	public function edit($topic_id)
	{
		$data['title'] = '修改话题';
		if($_POST){
			$str = array(
				'pid'=>$this->input->post('pid'),
				'cname'=>$this->input->post('cname'),
				'content'=>$this->input->post('content'),
				'keywords'=>$this->input->post('keywords')
			);
			if($this->cate_m->update_cate($node_id, $str)){
				show_message('修改分类成功！',site_url('admin/nodes'),1);
			}

		}
		$pid=0;
		$data['cates']=$this->cate_m->get_cates_by_pid($pid);
		$data['cateinfo']=$this->cate_m->get_category_by_node_id($node_id);
		$this->load->view('nodes_edit', $data);
	}
	public function set_top($topic_id,$is_top)
	{
		if($this->topic_m->set_top($topic_id,$is_top)){
			redirect('admin/topics/');
		}
	}

	public function batch_process()
	{
		$topic_ids = array_slice($this->input->post(), 0, -1);
		if($this->input->post('batch_del')){
			if($this->db->where_in('topic_id',$topic_ids)->delete('topics')){
				show_message('批量删除贴子成功！',site_url('admin/topics'),1);
			}
		}
		if($this->input->post('batch_approve')){
			if($this->db->where_in('topic_id',$topic_ids)->update('topics', array('is_hidden'=>0))){
				show_message('批量审核贴子成功！',site_url('admin/topics'),1);
			}
		}
	}

	public function approve($topic_id)
	{
		if($this->db->where('topic_id',$topic_id)->update('topics', array('is_hidden'=>0))){
			show_message('审核贴子成功！',site_url('admin/topics'),1);
		} else {
			return false;
		}
	}

	
}