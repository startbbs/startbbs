<?php
namespace app\common\behavior;
use app\common\model\System as ConfigModel;
/**
 * 初始化基础配置行为
 * 将扩展的行为本地化
*/
class Base {
	public function run(){
        // 设置系统配置
        $this->configmodel=new ConfigModel();
        $this->configmodel->getConfig();
    }
	
}