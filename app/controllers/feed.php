<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends SB_Controller {
  
  function __construct ()
	{
		parent::__construct();
		$this->load->model('topic_m');
		$this->load->model('cate_m');
		$this->load->library('myclass');
	}
	public function index ()
	{
		header("Content-Type: text/xml; charset=utf-8");
		//获取列表
		$data['list'] = $this->topic_m->get_latest_topics(30);
		//links

		$this->load->view('feed',$data);

	}
}