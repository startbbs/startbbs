<?php

namespace app\common\behavior;
use app\common\model\Hook as HookModel;
use app\common\model\HookPlugin as HookPluginModel;
use app\common\model\Plugin as PluginModel;
use Hook;
/**
 * 注册钩子
 * @package app\common\behavior
 */
class InitHook
{
	
    public function run()
    {
        // 安装操作直接return
        if(defined('BIND_MODULE') && BIND_MODULE == 'install') return;
        $hook_plugin = cache('hook_plugin');
        $hook        = cache('hook');
        $plugin      = cache('plugin');

        if (!$hook_plugin) {
            $hook = HookModel::where('status', 1)->column('status', 'name');
            $plugin = PluginModel::where('status', 2)->column('status', 'name');
            $hook_plugin = HookPluginModel::where('status', 1)->field('hook,plugin')->order('sort')->select();
            // 非开发模式，缓存数据
            //if (config('app_debug') === 1) {
                cache('hook_plugin', $hook_plugin);
                cache('hook', $hook);
                cache('plugin', $plugin);
            //}
        }
        // 全局插件
        if ($hook_plugin) {
            foreach ($hook_plugin as $value) {
                if (isset($hook[$value->hook]) && isset($plugin[$value->plugin])) {
                    Hook::add($value->hook, get_plugin_class($value->plugin));
                }
            }
        }
    }
}