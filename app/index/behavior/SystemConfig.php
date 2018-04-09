<?php
namespace app\index\behavior;
use app\common\model\System as ConfigModel;
/**
 * 初始化基础配置行为
 * 将扩展的行为本地化
*/
class SystemConfig {
	public function run(){
		if(!is_file('./public/static/install/install.lock')){
			header("location:/install.php");
			exit;
	    }
        // 设置系统配置
        $this->configmodel=new ConfigModel();
        $this->configmodel->getConfig();
    }
	
}