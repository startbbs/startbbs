<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nodes extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('cate_m');
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('非管理员或未登录',site_url('admin/login/do_login'));
		}
	}

	public function index ()
	{
		$data['title'] = '节点分类管理';
		$pid=0;
		$data['cates'] = $this->cate_m->get_cates_by_pid($pid);
		$this->load->view('nodes', $data);
		
	}
	public function del($node_id)
	{
		$data['title'] = '删除分类';
		//$this->myclass->notice('alert("确定再删除吗！");');
		$this->cate_m->del_cate($node_id);
		show_message('删除分类成功！',site_url('admin/nodes'),1);	

	}
	private function data_post($arr)
	{
			foreach($arr as $key => $a) {
			    if(preg_match("/^permit_\\d+$/i",$key)) {
				    $permit[$key]=$a;
			    }
			}
			if(is_array(@$permit))
			$permit=implode(',',@$permit);
			$str = array(
				'pid'=>$this->input->post('pid'),
				'cname'=>$this->input->post('cname'),
				'content'=>cleanhtml($this->input->post('content')),
				'keywords'=>$this->input->post('keywords'),
				'master'=>$this->input->post('master'),
				'permit'=>@$permit,
			);
			if($this->input->post('ico'))
			$str['ico']=$this->input->post('ico');
			return $str;
	}
	public function add()
	{
		$data['title'] = '添加分类';
	
		if($_POST){
			$str=$this->data_post($_POST);//引用
			$this->cate_m->add_cate($str);
			show_message('添加分类成功',site_url('admin/nodes'),1);
		}
		$pid=0;
		$data['cates']=$this->cate_m->get_cates_by_pid($pid);
		$this->load->model('group_m');
		$data['group_list'] = $this->group_m->group_list();
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('nodes_add', $data);
	}

	public function move($node_id)
	{
		$data['title'] = '移动分类';
		if($_POST){
			$pid = $this->input->post('pid');
			$this->cate_m->move_cate($node_id,$pid);
			show_message('移动分类成功',site_url('admin/nodes'),1);
		}
		$pid=0;
		$data['node_id']=$this->uri->segment(4);
		$data['cates']=$this->cate_m->get_cates_by_pid($pid);
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('nodes_move', $data);
	}

	public function edit($node_id)
	{
		$data['title'] = '修改分类';
		if($_POST){
			$str = $this->data_post($_POST);//引用
			if($this->cate_m->update_cate($node_id, $str)){
				show_message('修改分类成功',site_url('admin/nodes'),1);
			} else
			{
				show_message('分类未做修改',site_url('admin/nodes'));
			}

		}

		$pid=0;
		$data['cates']=$this->cate_m->get_cates_by_pid($pid);
		$data['cateinfo']=$this->cate_m->get_category_by_node_id($node_id);
		$data['pcateinfo']=$this->cate_m->get_category_by_node_id($data['cateinfo']['pid']);
		if($data['cateinfo']['pid']==0){
			$data['pcateinfo']['node_id']='0';
			$data['pcateinfo']['cname']='根目录';
		}

		//$data['cates']=$this->cate_m->get_cates_by_pid($node_id);
		$this->load->model('group_m');
		$data['group_list'] = $this->group_m->group_list();
		$data['permit_selected']=explode(',',$data['cateinfo']['permit']);
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('nodes_edit', $data);
	}


	
}