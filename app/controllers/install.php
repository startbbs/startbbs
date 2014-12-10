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
			show_message('系统已安装过,请删除／intall.lock再重新安装',site_url());
		}

	}
	public function index ()
	{
		$this->load->view('install_agreement');
		//redirect('install/step/1');
	}

    /**
     * 环境检测
     */
    public function check()
    {
        $do_next = true;
        $environmentItems = $this->_getEnvironmentItems();
        $lowestEnvironment = $this->_getLowestEnvironment();
        $recommendEnvironment = $this->_getRecommendEnvironment();
        $currentEnvironment = $this->_getCurrentEnvironment();

        foreach ($environmentItems as $key => $value) {
            $environment_item['name'] = $value;
            $environment_item['lowest'] = $lowestEnvironment[$key];
            $environment_item['recommend'] = $recommendEnvironment[$key];
            $environment_item['current'] = $currentEnvironment[$key];
            $environment_item['isok'] = $currentEnvironment[$key.'_isok'];
            if (!$currentEnvironment[$key.'_isok']) {
                $do_next = false;
            }
            $environment[] = $environment_item;
        }

        $filemod = $this->_getFileMOD();
        foreach ($filemod as $item) {
            if (!$item['mod']) {
                $do_next = false;
            }
        }

        $data['environment'] = $environment;
        $data['filemod'] = $filemod;
        $data['do_next'] = $do_next;
        $this->load->view('install_check', $data);
    }
    /**
     * 获取环境检测项目
     *
     * @return array
     */
    private function _getEnvironmentItems() {
        return array(
            'os' => '操作系统',
            'php' => 'PHP版本',
            'mysql' => 'Mysql版本（client）',
            'gd' => 'GD图像库',
            'upload' => '附件上传',
            'space' => '磁盘空间'
        );
    }

    /**
     * 获取环境的最低配置要求
     *
     * @return array
     */
    private function _getLowestEnvironment() {
        return array(
            'os' => '不限制',
            'php' => '5.1.6',
            'mysql' => '4.1',
            'gd' => '2.0',
            'upload' => '不限制',
            'space' => '50M'
        );
    }

    /**
     * 获取推荐的环境配置信息
     *
     * @return array
     */
    private function _getRecommendEnvironment() {
        return array(
            'os' => 'Linux',
            'php' => '> 5.3.x',
            'mysql' => '> 5.x.x',
            'gd' => '> 2.0',
            'upload' => '> 2M',
            'space' => '> 50M'
        );
    }

    /**
     * 获得当前的环境信息
     *
     * @return array
     */
    private function _getCurrentEnvironment() {
        $lowestEnvironment = $this->_getLowestEnvironment();
        $mysql_isok = true;

        if (function_exists('mysql_get_client_info')) {
            $mysql = mysql_get_client_info();
        } elseif (function_exists('mysqli_get_client_info')) {
            $mysql = mysqli_get_client_info();
        } else {
            $mysql = 'unknow';
            $mysql_isok = false;
        }
        if (function_exists('gd_info')) {
            $gdinfo = gd_info();
            $gd = $gdinfo['GD Version'];
            $gd_isok = version_compare($lowestEnvironment['gd'], $gd) < 0 ? false : true;
        } else {
            $gd = 'unknow';
            $gd_isok = false;
        }
        $upload = ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
        $space = floor(@disk_free_space(FCPATH) / (1024 * 1024));
        $space = $space ? $space . 'M': 'unknow';

        return array(
            'os' => PHP_OS,
            'php' => phpversion(),
            'mysql' => $mysql,
            'gd' => $gd,
            'upload' => $upload,
            'space' => $space,

            'os_isok' => true,
            'php_isok' => version_compare(phpversion(), $lowestEnvironment['php']) < 0 ? false : true,
            'mysql_isok' => $mysql_isok,
            'gd_isok' => $gd_isok,
            'upload_isok' => intval($upload) >= intval($lowestEnvironment['upload']) ? true : false,
            'space_isok' => intval($space) >= intval($lowestEnvironment['space']) ? true : false
        );
    }

    /**
     * 检查目录权限
     *
     * @return array
     */
    private function _getFileMOD() {

        $files_writeble[] = FCPATH . 'app/cache/';
        $files_writeble[] = FCPATH . 'uploads/';
        $files_writeble[] = FCPATH . 'app/config/database.php';
        $files_writeble[] = FCPATH . 'data/db/startbbs.sql';
        
        foreach ($files_writeble as $item) {
            $fileMOD_item['mod'] =  is_really_writable($item);
            $fileMOD_item['name'] = str_replace(FCPATH, '', $item);
            $fileMOD_item['needmod'] =  '可写';
            $fileMOD[] = $fileMOD_item;
        }

        return $fileMOD;
    }
    /**
     * 安装过程
     */
    public function process()
    {
        $this->load->helper('form');
		$this->load->library('form_validation');
		$data['item']['dbhost']=($this->input->post ('dbhost'))?$this->input->post ('dbhost'):'localhost';
		$data['item']['port']=($this->input->post ('port'))?$this->input->post ('port'):'3306';
		$data['item']['dbprefix']=($this->input->post ('dbprefix'))?$this->input->post ('dbprefix'):'stb_';
		$data['item']['username']=($this->input->post ('username'))?$this->input->post ('username'):'admin';
		$data['item']['email']=($this->input->post ('email'))?$this->input->post ('email'):'startbbs@126.com';
        if($this->form_validation->run() === TRUE) {
            $dbhost = $this->input->post('dbhost');
            $dbuser = $this->input->post('dbuser');
            $dbpsw = $this->input->post('dbpsw');
            $dbname = $this->input->post('dbname');
            $port =$this->input->post('port');
            $dbprefix = $this->input->post('dbprefix');
			$salt =get_salt();
			$password= password_dohash($this->input->post('password'),$salt);
            $admin = array(
            	'group_type'=>0,
            	'gid'=>1,
            	'is_active'=>1,
                'username' => $this->input->post('username'),
                'password' => $password,
                'salt' => $salt,
                'email' =>$this->input->post('email'),
                'regtime' => time(),
                'ip' => get_onlineip()
                );
			$con=mysqli_connect($dbhost, $dbuser, $dbpsw, $dbname,$port);
            //检查数据库信息是否正确
            if (!$con) {
                $string='
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <script>
                alert("无法访问数据库，请重新安装！");
                top.location="'.site_url('install').'";
                </script>
                ';
                exit($string);
            }

            //写入数据库配置文件
            $this->_writeDBConfig($dbhost, $dbuser, $dbpsw, $dbname, $port,$dbprefix);

            //创建数据表
            $this->_createTables($dbhost, $dbuser, $dbpsw, $dbname, $port, $dbprefix,$con);

            //禁止安装的文件
            file_put_contents(FCPATH.'install.lock', time());
            //写入config文件
            $sub_folder=$this->input->post('base_url');
            if($sub_folder){
				$this->config->update('myconfig','sub_folder', $sub_folder);
			}
			$encryption_key = md5(uniqid());
			if($encryption_key){
				$this->config->update('myconfig','encryption_key', $encryption_key);
			}
            sleep(1);
            //添加管理员
            $this->load->database();
            $this->load->model('user_m');
            $this->user_m->register($admin);
            $this->user_m->login($admin);

            $this->load->view('install_done');
        }else{
	        $this->load->view('install_process',$data);
        }
        
    }

    /**
     * 写入数据库配置文件
     */
    private function _writeDBConfig($dbhost, $dbuser, $dbpsw, $dbname, $port,$dbprefix)
    {
        $config = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $config .= "\$active_group = 'default';".PHP_EOL;
        $config .= "\$active_record = TRUE;".PHP_EOL.PHP_EOL;

        $config .= "\$db['default']['hostname'] = '".$dbhost."';".PHP_EOL;
        $config .= "\$db['default']['port'] = '".$port."';".PHP_EOL;
        $config .= "\$db['default']['username'] = '".$dbuser."';".PHP_EOL;
        $config .= "\$db['default']['password'] = '".$dbpsw."';".PHP_EOL;
        $config .= "\$db['default']['database'] = '".$dbname."';".PHP_EOL;
        $config .= "\$db['default']['dbdriver'] = 'mysql';".PHP_EOL;
        $config .= "\$db['default']['dbprefix'] = '".$dbprefix."';".PHP_EOL;
        $config .= "\$db['default']['pconnect'] = TRUE;".PHP_EOL;
        $config .= "\$db['default']['db_debug'] = TRUE;".PHP_EOL;
        $config .= "\$db['default']['cache_on'] = FALSE;".PHP_EOL;
        $config .= "\$db['default']['cachedir'] = '';".PHP_EOL;
        $config .= "\$db['default']['char_set'] = 'utf8';".PHP_EOL;
        $config .= "\$db['default']['dbcollat'] = 'utf8_general_ci';".PHP_EOL;
        $config .= "\$db['default']['swap_pre'] = '';".PHP_EOL;
        $config .= "\$db['default']['autoinit'] = TRUE;".PHP_EOL;
        $config .= "\$db['default']['stricton'] = FALSE;".PHP_EOL.PHP_EOL.PHP_EOL;
        $config .= "/* End of file database.php */".PHP_EOL;
        $config .= "/* Location: ./application/config/database.php */";

        // 保存配置文件
        if (!file_put_contents(FCPATH.'app/config/database.php', $config)) {
            $string='
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <script>
            alert("数据库配置文件保存失败，请检查文件app/config/database.php权限！");
            top.location="'.site_url('install').'";
            </script>
            ';
            exit($string);
        }
    }

    /**
     * 导入数据表
     */
    private function _createTables($dbhost, $dbuser, $dbpsw, $dbname, $port,$dbprefix,$con)
    {
        $sql = file_get_contents(FCPATH.'data/db/startbbs.sql'); 
        $sql = str_replace('stb_', $dbprefix, $sql);
        
        if (!mysqli_multi_query($con,$sql)) {
            $string='
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <script>
            alert("创建数据表失败，请重试式！");
            top.location="'.site_url('install').'";
            </script>
            ';
            exit($string);
        }
    }

    /**
     * 测试数据库连接
     */
    public function testdb($dbhost='host', $dbuser='user', $dbpsw='psw', $dbname='name',$port='3306')
    {
        $con = @mysqli_connect($dbhost, $dbuser, $dbpsw, $dbname,$port);

        if ($con) {
            echo "<font color=green><b>数据库连接成功！</b></font>";
        } else {
            echo "<font color=red><b>数据库连接失败，请重新输入数据库信息！</b></font>";
        }
    }

}