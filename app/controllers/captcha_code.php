<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_code extends Other_Controller {

	function __construct()
    {
        parent::__construct();
	}
	function index()
	{
		$conf['name']='yzm';
		$this->load->library('captcha',$conf);
		$this->captcha->show();
	}
}