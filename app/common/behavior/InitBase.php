<?php
namespace app\common\behavior;
use Env;
use think\Loader;
/**
 * 初始化基础配置行为
 * 将扩展的行为本地化
*/
class InitBase {
	public function run(){
		define('ROOT_PATH',Env::get('root_path'));
		// 注册插件根命名空间
        Loader::addNamespace('plugin', ROOT_PATH . 'plugin'.'/');
    }
}