<?php if (!defined('BASEPATH')) exit('No direct access allowed.');


class MY_Loader extends CI_Loader
{
	public function __construct()
	{
		parent::__construct();
		//配置模板路径
        $this->_ci_view_paths = array('themes/' => TRUE);
	}
	public function set_front_theme($theme='default')
	{
		$this->_ci_view_paths = array(FCPATH.'themes/'.$theme.'/'	=> TRUE);
	}
	public function set_admin_theme()
	{
		$this->_ci_view_paths = array(FCPATH.'themes/admin/'	=> TRUE);
	}
	public function plugin($name)
	{
		$this->add_package_path(APPPATH.'plugin/'.$name.'/');
		$this->library($name);
		//$ci= &get_instance();
		//$ci->config->load($config);
	}
}