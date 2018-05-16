<?php
// +----------------------------------------------------------------------
// | HisiPHP框架[基于ThinkPHP5开发]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 http://www.hisiphp.com
// +----------------------------------------------------------------------
// | HisiPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
// +----------------------------------------------------------------------
// | Author: 烧饼 <858292510@qq.com>，开发者QQ群：50304283
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;
use app\admin\model\Hook as HookModel;

/**
 * 钩子插件索引模型
 * @package app\admin\model
 */
class HookPlugin extends Model
{

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 索引入库
     * @param array $hooks 钩子
     * @param string $plugins 插件名称
     * @author 烧饼 <858292510@qq.com>
     * @return bool
     */
    public static function storage($hooks = [], $plugins = '')
    {
        if (!empty($hooks) && is_array($hooks)) {
            $hook_mod = new HookModel();
            // 添加钩子
            foreach ($hooks as $k => $v) {
                if (is_numeric($k)) {
                    $k = $v;
                }
                if (!$hook_mod->storage(['name' => $k, 'source' => 'plugins.'.$plugins, 'intro' => $v])) {
                    return false;
                }
            }

            $data = [];
            foreach ($hooks as $k => $v) {
                if (is_numeric($k)) {
                    $k = $v;
                }
                // 清除重复数据
                if (self::where(['hook' => $k, 'plugins' => $plugins])->find()) {
                    continue;
                }
                $data[] = [
                    'hook'      => $k,
                    'plugins'   => $plugins,
                    'ctime'     => request()->time(),
                    'mtime'     => request()->time(),
                ];
            }
            
            if (empty($data)) {
                return true;
            }

            return self::insertAll($data);
        }
        return false;
    }

    /**
     * 删除插件钩子索引
     * @param string $plugins 插件名称
     * @author 烧饼 <858292510@qq.com>
     * @return bool
     */
    public static function del($plugins = '')
    {
        if (!empty($plugins)) {
            // 删除插件钩子
            if (!HookModel::delHook('plugins.'.$plugins)) {
                return false;
            }
            // 删除索引
            if (self::where('plugins', $plugins)->delete() === false) {
                return false;
            }
        }
        return true;
    }
}