<?php

/**
 * The base controller which is used by the Front and the Admin controllers
 */
class Base_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
/*		// load the migrations class
		$this->load->library('migration');
	
		// Migrate to the latest migration file found
		if ( ! $this->migration->latest())
		{
			log_message('error', 'The migration failed');
		}*/
		
	}//end __construct()
	
}//end Base_Controller

class SB_Controller extends Base_Controller
{
	
	//we collect the categories automatically with each load rather than for each function
	//this just cuts the codebase down a bit
	var $categories	= '';
	
	//load all the pages into this variable so we can call it from all the methods
	var $pages = '';
	
	// determine whether to display gift card link on all cart pages
	//  This is Not the place to enable gift cards. It is a setting that is loaded during instantiation.
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
		$data['user']=$this->db->select('uid,username,avatar')->where('uid',$this->session->userdata('uid'))->get('users')->row_array();
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

/*		//load GoCart library
		$this->load->library('Go_cart');
		//load needed models
		$this->load->model(array('Page_model', 'Product_model', 'Digital_Product_model', 'Gift_card_model', 'Option_model', 'Order_model', 'Settings_model'));
		
		//load helpers
		$this->load->helper(array('form_helper', 'formatting_helper'));
		
		//fill in our variables
		$this->categories	= $this->Category_model->get_categories_tierd(0);
		$this->pages		= $this->Page_model->get_pages();
		
		// check if giftcards are enabled
		$gc_setting = $this->Settings_model->get_settings('gift_cards');
		if(!empty($gc_setting['enabled']) && $gc_setting['enabled']==1)
		{
			$this->gift_cards_enabled = true;
		}			
		else
		{
			$this->gift_cards_enabled = false;
		}
		
		//load the theme package
		$this->load->add_package_path(APPPATH.'themes/'.$this->config->item('theme').'/');*/
	}	
	/*
	This works exactly like the regular $this->load->view()
	The difference is it automatically pulls in a header and footer.
	*/
/*	function view($view, $vars = array(), $string=false)
	{
		if($string)
		{
			$result	 = $this->load->view('header', $vars, true);
			$result	.= $this->load->view($view, $vars, true);
			$result	.= $this->load->view('footer', $vars, true);
			
			return $result;
		}
		else
		{
			$this->load->view('header', $vars);
			$this->load->view($view, $vars);
			$this->load->view('footer', $vars);
		}
	}
	
	/*
	This function simple calls $this->load->view()
	*/
	/*
	function partial($view, $vars = array(), $string=false)
	{
		if($string)
		{
			return $this->load->view($view, $vars, true);
		}
		else
		{
			$this->load->view($view, $vars);
		}
	}*/


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
		/** 加载验证库 */
		$this->load->library('auth');
		/** 检查登陆 */	
		$group_type = $this->session->userdata('group_type');
		$this->load->library('myclass');
		if(!$this->auth->is_login())
		{
			$this->myclass->notice('alert("管理员未登录或非管理员");window.location.href="'.site_url('user/login').'";');
			exit;
		}
		if(!$this->auth->is_admin())
		{
			$this->myclass->notice('alert("无权访问此页");window.location.href="/";');
			exit;
		}
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