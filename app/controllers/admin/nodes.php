<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nodes extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->model('cate_m');
	}

	public function index ()
	{
		$data['title'] = '节点分类管理';
		$pid=0;
		$data['cates'] = $this->cate_m->get_cates_by_pid($pid);
		$this->load->view('nodes', $data);
		
	}
	public function del($cid)
	{
		$data['title'] = '删除分类';
		$this->myclass->notice('alert("确定再删除吗！");');
		$this->cate_m->del_cate($cid);
		$this->myclass->notice('alert("删除分类成功！");window.location.href="'.site_url('admin/nodes').'";');		

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
				'ico'=>$this->input->post('ico'),
				'master'=>$this->input->post('master'),
				'permit'=>@$permit,
			);
			return $str;
	}
	public function add()
	{
		$data['title'] = '添加分类';
	
		if($_POST){
			$str=$this->data_post($_POST);//引用
			$this->cate_m->add_cate($str);
			$this->myclass->notice('alert("添加分类成功");window.location.href="'.site_url('admin/nodes').'";');
		}
		$pid=0;
		$data['cates']=$this->cate_m->get_cates_by_pid($pid);
		$this->load->model('group_m');
		$data['group_list'] = $this->group_m->group_list();
		$this->load->view('nodes_add', $data);
	}

	public function move($cid)
	{
		$data['title'] = '移动分类';
		if($_POST){
			$pid = $this->input->post('pid');
			$this->cate_m->move_cate($cid,$pid);
			$this->myclass->notice('alert("移动分类成功");window.location.href="'.site_url('admin/nodes').'";');
		}
		$pid=0;
		$data['cid']=$this->uri->segment(4);
		$data['cates']=$this->cate_m->get_cates_by_pid($pid);
		$this->load->view('nodes_move', $data);
	}

	public function edit($cid)
	{
		$data['title'] = '修改分类';
		if($_POST){
			$str = $this->data_post($_POST);//引用
			if($this->cate_m->update_cate($cid, $str)){
				$this->myclass->notice('alert("修改分类成功");window.location.href="'.site_url('admin/nodes').'";');
			} else
			{
				$this->myclass->notice('alert("分类未做修改");window.location.href="'.site_url('admin/nodes').'";');
			}

		}

		$pid=0;
		$data['cates']=$this->cate_m->get_cates_by_pid($pid);
		$data['cateinfo']=$this->cate_m->get_category_by_cid($cid);
		$data['pcateinfo']=$this->cate_m->get_category_by_cid($data['cateinfo']['pid']);
		if($data['cateinfo']['pid']==0){
			$data['pcateinfo']['cid']='0';
			$data['pcateinfo']['cname']='根目录';
		}

		//$data['cates']=$this->cate_m->get_cates_by_pid($cid);
		$this->load->model('group_m');
		$data['group_list'] = $this->group_m->group_list();
		$data['permit_selected']=explode(',',$data['cateinfo']['permit']);
		$this->load->view('nodes_edit', $data);
	}


	
}