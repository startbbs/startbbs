<?php
/**
 * The base controller which is used by the Front and the Admin controllers
 */
class Base_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();	
	}
}
class SB_Controller extends Base_Controller
{
	var $nodes	= '';
	var $pages = '';
	var $gift_cards_enabled;
	function __construct(){
		parent::__construct();
		//判断关闭
		if($this->config->item('site_close')=='off'){
			show_error($this->config->item('site_close_msg'),500,'网站关闭');
		}		
		//载入前台模板
		$this->load->set_front_theme($this->config->item('themes'));
		//判断安装
		$file=FCPATH.'install.lock';
		if (!is_file($file)){
			redirect(site_url('install'));
		}
		$this->load->database();
	 	//网站设定
		$data['items']=$this->db->get('settings')->result_array();
		$data['settings']=array(
			'site_name'=>$data['items'][0]['value'],
			'welcome_tip'=>$data['items'][1]['value'],
			'short_intro'=>$data['items'][2]['value'],
			'show_captcha'=>$data['items'][3]['value'],
			'site_run'=>$data['items'][4]['value'],
			'site_stats'=>$data['items'][5]['value'],
			'site_keywords'=>$data['items'][6]['value'],
			'site_description'=>$data['items'][7]['value'],
			'money_title'=>$data['items'][8]['value'],
			'per_page_num'=>$data['items'][9]['value'],
			'logo'=>$this->config->item('logo')
		 );
		 //取一个用户信息
		$data['user']=$this->db->select('uid,username,avatar,credit')->where('uid',$this->session->userdata('uid'))->get('users')->row_array();
		//一个用户的用户组
		$data['group'] = $this->db->select('group_name')->get_where('user_groups',array('gid'=>$this->session->userdata('gid')))->row_array();
		$data['group']['group_name']=($data['group'])?$data['group']['group_name']:'普通会员';
		//获取二级目录
		$data['base_folder'] = $this->config->item('base_folder');
		//获取头像
		$this->load->model('upload_m');
		$data['user']['big_avatar']=$this->upload_m->get_avatar_url($this->session->userdata('uid'), 'big');
		$data['user']['big_avatar']=(file_exists($data['user']['big_avatar']))?$data['user']['big_avatar']:'uploads/avatar/avatar_large.jpg';
		$data['user']['middle_avatar']=$this->upload_m->get_avatar_url($this->session->userdata('uid'), 'middle');
		$data['user']['middle_avatar']=(file_exists($data['user']['middle_avatar']))?$data['user']['middle_avatar']:'uploads/avatar/default.jpg';
		//获取分类
		$this->load->model('cate_m');
		$data['catelist'] =$this->cate_m->get_all_cates();
		//右侧登录调用收藏贴子数
			$favorites=$this->db->select('favorites')->where('uid',$this->session->userdata('uid'))->get('favorites')->row_array();
			if(!@$favorites['favorites']){
				@$favorites['favorites'] =0;
			}
		//右侧登录处调用提醒数
		$notices= $this->db->select('notices')->where('uid',$this->session->userdata('uid'))->get('users')->row_array();
		$data['users'] = array('favorites'=>@$favorites['favorites'],'notices'=>@$notices['notices']);
		//右侧调用关注数
		$follows= $this->db->select('follows')->where('uid',$this->session->userdata('uid'))->get('users')->row_array();
		$data['users']['follows'] = @$follows['follows'];
		//底部菜单(单页面)
		$this->load->model('page_m');
		$data['page_links'] = $this->page_m->get_page_menu(10,0);
		//模板目录
		$data['themes']=base_url('static/'.$this->config->item('themes').'/');
		//全局输出
		$this->load->vars($data);
	}	
}
class Admin_Controller extends Base_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		//载入后台模板
		$this->load->set_admin_theme();
	 	//网站设定
		$data['items']=$this->db->get('settings')->result_array();
		$data['settings']=array(
			'site_name'=>$data['items'][0]['value'],
			'welcome_tip'=>$data['items'][1]['value'],
			'short_intro'=>$data['items'][2]['value'],
			'show_captcha'=>$data['items'][3]['value'],
			'site_run'=>$data['items'][4]['value'],
			'site_stats'=>$data['items'][5]['value'],
			'site_keywords'=>$data['items'][6]['value'],
			'site_description'=>$data['items'][7]['value'],
			'money_title'=>$data['items'][8]['value'],
			'per_page_num'=>$data['items'][9]['value']
		 );
		$this->load->vars($data);
	}
}
class Install_Controller extends Base_Controller 
{
	function __construct()
	{
		parent::__construct();
		//载入前台模板
		$this->load->set_front_theme('default');
	}
}
class Other_Controller extends Base_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		//载入前台模板
		$this->load->set_front_theme('default');
	}
}