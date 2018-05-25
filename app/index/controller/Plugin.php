<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use app\common\model\Plugin as PluginModel;


class Plugin extends HomeBase
{
    public function _empty()
    {
        /**
         * 支持以下两种URL模式
         * URL模式1 [/plugin/插件名/控制器/[方法]?参数1=参数值&参数2=参数值]
         * URL模式2 [/plugin.php?p=插件名&c=控制器&a=方法&参数1=参数值&参数2=参数值] 推荐
         */
        $path = $this->request->path();
        $path = explode('/', $path);
        if (isset($path[1]) && !empty(($path[1]))) {
            $plugin = $_GET['p'] = $path[1];
        } else {
            return $this->error('参数传递错误！');
        }
        if (isset($path[2]) && !empty(($path[2]))) {
            $controller = $_GET['c'] = $path[2];
        } else {
            $controller = $_GET['c'] = input('param.c', 'Index');
        }
        $controller = ucfirst($controller);
        
        if (isset($path[3]) && !empty(($path[3]))) {
            $action = $_GET['a'] = $path[3];
        } else {
            $action = $_GET['a'] = input('param.a', 'index');
        }
        
        $params = $this->request->except(['p', 'c', 'a'], 'param');

        if (empty($plugin)) {
            return $this->error('插件参数传递错误！');
        }            
        if (!PluginModel::where(['name' => $plugin, 'status' => 2])->find() ) {
            return $this->error("插件可能不存在或者未安装！");
        }
        if (!plugin_action_exist($plugin.'/'.$controller.'/'.$action, 'home')) {
            return $this->error("插件方法不存在[".$plugin.'/'.$controller.'/'.$action."]！");
        }
        return plugin_action($plugin.'/'.$controller.'/'.$action, $params, 'home');
    }
}
