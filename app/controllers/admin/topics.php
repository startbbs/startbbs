<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topics extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('cate_m');
		$this->load->model('forum_m');
		$this->load->model('comment_m');

	}

	public function index ($page=1)
	{
		$data['title'] = '话题管理';
		//分页
		$limit = 20;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('admin/topics/index/');
		$config['total_rows'] = $this->db->count_all('forums');
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

		$data['topics'] = $this->forum_m->get_all_forums($start, $limit);

		$this->load->view('topics', $data);
		
	}
	public function del($fid,$cid,$uid)
	{
		$data['title'] = '删除贴子';
		$this->myclass->notice('alert("确定要删除此话题吗！");');
		//删除贴子及它的回复
		if($this->forum_m->del_forum($fid,$cid,$uid)){
		$this->comment_m->del_comments_by_fid($fid,$uid);
		$this->myclass->notice('alert("删除贴子成功！");window.location.href="'.site_url('admin/topics').'";');
		}

	}

	public function edit($fid)
	{
		$data['title'] = '修改话题';
		if($_POST){
			$str = array(
				'pid'=>$this->input->post('pid'),
				'cname'=>$this->input->post('cname'),
				'content'=>$this->input->post('content'),
				'keywords'=>$this->input->post('keywords')
			);
			if($this->cate_m->update_cate($cid, $str)){
				$this->myclass->notice('alert("修改分类成功");window.location.href="'.site_url('admin/nodes').'";');
			}

		}
		$pid=0;
		$data['cates']=$this->cate_m->get_cates_by_pid($pid);
		$data['cateinfo']=$this->cate_m->get_category_by_cid($cid);
		$this->load->view('nodes_edit', $data);
	}
	public function set_top($fid,$is_top)
	{
		if($this->forum_m->set_top($fid,$is_top)){
			redirect('admin/topics/');
		}
	}

	public function batch_process()
	{
		$fids = array_slice($this->input->post(), 0, -1);
		if($this->input->post('batch_del')){
			if($this->db->where_in('fid',$fids)->delete('forums')){
				$this->myclass->notice('alert("批量删除贴子成功！");window.location.href="'.site_url('admin/topics').'";');
			}
		}
		if($this->input->post('batch_approve')){
			if($this->db->where_in('fid',$fids)->update('forums', array('is_hidden'=>0))){
				$this->myclass->notice('alert("批量审核贴子成功！");window.location.href="'.site_url('admin/topics').'";');
			}
		}
	}

	public function approve($fid)
	{
		if($this->db->where('fid',$fid)->update('forums', array('is_hidden'=>0))){
			$this->myclass->notice('alert("审核贴子成功！");window.location.href="'.site_url('admin/topics').'";');
		} else {
			return false;
		}
	}

	
}