<?php
namespace app\install\controller;
use think\Controller;
use think\Db;
use Env;

class Index extends Controller{

    protected function initialize(){
        if(is_file('./public/static/install/install.lock')){
            $this->error('已经成功安装了startbbs，重新安装,请删除install.lock文件','/index.php');
        }
    }
    //安装首页
    public function index(){
        $this->assign('step','layui-this');
        return $this->fetch();
    }
    //安装第一步，检测运行所需的环境设置
    public function step1(){
	    session('error', false,'install');
        //环境检测
        $env = check_env() ?: null;
        //目录文件读写检测
       $dirfile=check_dirfile() ?: null;
        //函数检测
        $func = check_func() ?: null;
        if(!session('error','','install')){
        	session('step', 1);
        }else {
        	session('step', null);
        }
        $this->assign('step1', 'layui-this');
        $this->assign('env', $env);
        $this->assign('func', $func);
		$this->assign('dirfile', $dirfile);
        return $this->fetch();
    }

    //安装第二步，创建数据库
    public function step2(){
	    if(session('step')!=1){
		    $this->error('环境检测没有通过，请调整环境后重试！','step');
	    }
        if($this->request->isPost()){
	        $admin = $this->request->param('admin/a');
			$db = $this->request->param('db/a');
            //检测管理员信息
            if(!is_array($admin) || empty($admin[0]) || empty($admin[1]) || empty($admin[3])){
                $this->error('请填写完整管理员信息');
            } else if($admin[1] != $admin[2]){
                $this->error('确认密码和密码不一致');
            } else {
                $info = array();
                list($info['username'], $info['password'], $info['repassword'], $info['email'])
                = $admin;
                //缓存管理员信息
                session('admin_info', $info);
            }
            //检测数据库配置
            if(!is_array($db) || empty($db[0]) ||  empty($db[1]) || empty($db[2]) || empty($db[3])){
                $this->error('请填写完整的数据库配置');
            } else {
                $DB = array();
                list($DB['type'], $DB['hostname'], $DB['database'], $DB['username'], $DB['password'], $DB['hostport'], $DB['prefix']) = $db;
                //缓存数据库配置
                session('db_config', $DB);

                //创建数据库
                $dbname = $DB['database'];
                unset($DB['database']);
                $db  = Db::connect($DB);//Db::getInstance($DB);
                $sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8";
                $db->execute($sql) || $this->error($db->getError());
				session('step', 2);
            }
            //跳转到数据库安装页面
            $this->redirect('step3');
        } else {
            $this->assign('step2','layui-this');
            return $this->fetch();
        }
    }

    //安装第三步，安装数据表，创建配置文件
    public function step3(){
        if(session('step') != 2){
            $this->redirect('step2');
        }
        //连接数据库
        $dbconfig = session('db_config');
        $db = Db::connect($dbconfig);
        //创建数据表
        create_tables($db, $dbconfig['prefix']);
        //注册创始人帐号
        $admin = session('admin_info');
        register_administrator($db, $dbconfig['prefix'], $admin);
        //创建配置文件
        $conf   =   write_config($dbconfig);
        session('config_file',$conf);
        if(!session('error','','install')){
            session('step', 3);
            $this->success('安装成功', 'Index/complete');
        }
        return $this->fetch();
    }
    //安装完成
    public function complete(){
        $step = session('step');

        if(!$step){
            $this->redirect('index');
        } elseif($step != 3) {
            $this->redirect("Install/step{$step}");
        }

        // 写入安装锁定文件 
        file_put_contents(Env::get('root_path') . 'public/static/install/install.lock', 'lock'); 
        if(!session('update')){
            //创建配置文件
            $this->assign('info',session('config_file'));
        }
        session('step', null);
        session('error', null);
        session('update',null);
        return $this->fetch();
    }
}
