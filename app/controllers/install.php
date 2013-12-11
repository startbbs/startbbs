<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#doc
#	classname:	Install
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Install extends Install_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->library('myclass');
		$file=FCPATH.'install.lock';
		if (file_exists($file)){
			$this->myclass->notice('alert("系统已安装过");window.location.href="'.site_url().'";');
			exit;
		}

	}
	public function index ()
	{
		redirect('install/step/1');
	}

	public function step($step)
	{
		$data['step']=$step;
		if($step==1 || $step==2){
			$data['permission'] = $this->_checkFileRight();
			$this->load->view('install',$data);
		}
		if($step==3){
			$this->_install_do();
		}
	}

	function _install_do()
	{
		$data['step']=3;
		if($_POST){	
				$dbhost = $this->input->post('dbhost');
				$dbport = $this->input->post('dbport');
				$dbname = $this->input->post('dbname');
				$dbuser = $this->input->post('dbuser');
				$dbpwd = $this->input->post('dbpwd')?$this->input->post('dbpwd'):'';
				$dbprefix = $this->input->post('dbprefix');
				$userid = $this->input->post('admin');
				$pwd = md5($this->input->post('pwd'));
				$email = $this->input->post('email');
				$sub_folder = '/'.$this->input->post('base_url').'/';
				$conn = mysql_connect($dbhost.':'.$dbport,$dbuser,$dbpwd);
				if (!$conn) {
					die('无法连接到数据库服务器，请检查用户名和密码是否正确');
				}
				if($this->input->post('creatdb')){
					if(!@mysql_query('CREATE DATABASE IF NOT EXISTS '.$dbname)){
						die('指定的数据库('.$dbname.')系统尝试创建失败，请通过其他方式建立数据库');
					}
				}
				if(!mysql_select_db($dbname,$conn)){
					die($dbname.'数据库不存在，请创建或检查数据名.');

				}
					$sql = file_get_contents(FCPATH.'app/config/startbbs.sql');
					$sql = str_replace("stb_",$dbprefix,$sql);
					$explode = explode(";",$sql);
					$data['msg1']="创建表".$dbname."成功，请稍后……<br/>";
				 	foreach ($explode as $key=>$value){
				    	if(!empty($value)){
				    		if(trim($value)){
					    		mysql_query($value.";");
				    		}
				    	}
				  	}
					$password = $pwd;
				  	$ip=$this->myclass->get_ip();
				  	$insert= "INSERT INTO ".$dbprefix."users (group_type,gid,is_active,username,password,email,regtime,ip) VALUES ('0','1','1','".$userid."','".$password."','".$email."','".time()."','".$ip."')";
				  	mysql_query($insert);
					mysql_close($conn);
					$data['msg2']="安装完成，正在保存配置文件，请稍后……"; 
					$dbconfig = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n"
					."\$active_group = 'default';\n"
					."\$active_record = TRUE;\n"
					."\$db['default']['hostname'] = '".$dbhost."';\n"
					."\$db['default']['port'] = '".$dbport."';\n"
					."\$db['default']['username'] = '".$dbuser."';\n"
					."\$db['default']['password'] = '".$dbpwd."';\n"
					."\$db['default']['database'] = '".$dbname."';\n"
					."\$db['default']['dbdriver'] = 'mysql';\n"
					."\$db['default']['dbprefix'] = '".$dbprefix."';\n"
					."\$db['default']['pconnect'] = TRUE;\n"
					."\$db['default']['db_debug'] = TRUE;\n"
					."\$db['default']['cache_on'] = FALSE;\n"
					."\$db['default']['cachedir'] = 'app/cache';\n"
					."\$db['default']['char_set'] = 'utf8';\n"
					."\$db['default']['dbcollat'] = 'utf8_general_ci';\n"
					."\$db['default']['swap_pre'] = '';\n"
					."\$db['default']['autoinit'] = TRUE;\n"
					."\$db['default']['stricton'] = FALSE;";
					$file = FCPATH.'/app/config/database.php';
					file_put_contents($file,$dbconfig);
			 
					//保存config文件
					if($sub_folder){
						$this->config->update('myconfig','sub_folder', $sub_folder);
					}
					$encryption_key = md5(uniqid());
					if($encryption_key){
						$this->config->update('myconfig','encryption_key', $encryption_key);
					}

					$data['msg3']="保存配置文件完成！";
					touch(FCPATH.'install.lock'); 
					$data['msg4']="创建锁定安装文件install.lock成功";
					$data['msg5']="安装startbbs成功！";
		}
		$this->load->view('install',$data);

	}

	/**
	 * 检查数据库连接
	 */
	public function check(){
		$dbhost = $_REQUEST["dbhost"];
		$dbport = $_REQUEST["dbport"];
		$dbname = $_REQUEST["dbname"];
		$dbuser = $_REQUEST["dbuser"];
		$dbpwd = $_REQUEST["dbpwd"];
		$res = array("msg"=>"");		
		$conn = mysql_connect($dbhost.":".$dbport,$dbuser,$dbpwd);
		$db = mysql_select_db($dbname,$conn);
		if($db){
			$res["code"] = 1;
			$res["msg"] = "数据库连接成功！";
			mysql_close($conn);
		}else{
			$res["code"] = 0;
			$res["msg"] = "数据库连接失败";
		}
		echo json_encode($res);
	}
	

	/**
	 * 检查目录权限
	 *
	 * @return array
	 */
	private function _checkFileRight() {
	
		$files_writeble[] = FCPATH . '/';
		$files_writeble[] = FCPATH . 'app/config/';
		$files_writeble[] = FCPATH . 'app/config/config.php';
		$files_writeble[] = FCPATH . 'app/config/myconfig.php';
		$files_writeble[] = FCPATH . 'app/config/database.php';
		$files_writeble[] = FCPATH . 'data/';
		$files_writeble[] = FCPATH . 'data/backup/';
		$files_writeble[] = FCPATH . 'uploads/';
		$files_writeble[] = FCPATH . 'uploads/avatar/';
		$files_writeble[] = FCPATH . 'uploads/avatar/tmp/';
		$files_writeble[] = FCPATH . 'uploads/files/';
		$files_writeble[] = FCPATH . 'uploads/image/';
		
		$files_writeble = array_unique($files_writeble);
		sort($files_writeble);
		$writable = array();
		
		foreach ($files_writeble as $file) {
			$key = str_replace(FCPATH, '', $file);
			$isWritable = $this->_checkWriteAble($file) ? true : false;
			if ($isWritable) {
				$flag = false;
				foreach ($writable as $k=>$v) {
					if (0 === strpos($key, $k)) $flag = true;
				}
				$flag || $writable[$key] = $isWritable;
			} else {
				$writable[$key] = $isWritable;
			}
		}
		return $writable;
	}
	/**
	 * 检查目录可写
	 *
	 * @param string $pathfile
	 * @return boolean
	 */
	private function _checkWriteAble($pathfile) {
		if (!$pathfile) return false;
		$isDir = in_array(substr($pathfile, -1), array('/', '\\')) ? true : false;
		if ($isDir) {
			if (is_dir($pathfile)) {
				mt_srand((double) microtime() * 1000000);
				$pathfile = $pathfile . 'stb_' . uniqid(mt_rand()) . '.tmp';
			} elseif (@mkdir($pathfile)) {
				return self::_checkWriteAble($pathfile);
			} else {
				return false;
			}
		}
		@chmod($pathfile, 0777);
		$fp = @fopen($pathfile, 'ab');
		if ($fp === false) return false;
		fclose($fp);
		$isDir && @unlink($pathfile);
		return true;
	}
}