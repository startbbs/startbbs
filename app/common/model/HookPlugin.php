<?php
namespace app\common\model;

use think\Model;
use Session;
use app\common\model\Hook as HookModel;

class HookPlugin extends Model
{
	protected $autoWriteTimestamp = true;
    //protected $insert = ['create_time'];

    /**
     * 添加钩子-插件对照
     * @param array $hooks 钩子
     * @param string $plugin_name 插件名称
     * @return bool
     */
    public static function addHookPlugin($hooks = [], $plugin_name = '')
    {
        if ($hooks && is_array($hooks)) {
            // 添加钩子
            if (!HookModel::addHooks($hooks)) {
                return false;
            }
            $data=[];
            foreach ($hooks as $name => $description) {
                if (is_numeric($name)) {
                    $name = $description;
                }
                $data[] = [
                    'hook'        => $name,
                    'plugin'      => $plugin_name,
                    'create_time' => request()->time(),
                    'update_time' => request()->time(),
                ];
            }
            return self::insertAll($data);
        }
        return false;
    }

    /**
     * 删除插件钩子索引
     * @param string $plugins 插件名称
     * @return bool
     */
    public static function del($plugin = '')
    {
	    if (!empty($plugin)) {
		    $hooks = self::where('plugin',$plugin)->column('hook');
		    cache('hooks', array_unique($hooks), 60);
		    // 删除索引
            if (self::where('plugin', $plugin)->delete() === false) {
                return false;
            }
            $new_hooks = self::where('plugin',$plugin)->column('hook');
		    foreach(cache('hooks') as $v)
		    {
		    	if(!in_array($v,$new_hooks)){
		            // 删除插件钩子
		            if (!HookModel::delHook($v)) {
		                return false;
		            }
		    	}
		    }

        }
        return true;
    }

    /**
     * 话题作者
     * @param $value
     * @return mixed
     */
    protected function setAuthorAttr($value)
    {
        return $value ? $value : Session::get('admin_name');
    }

    /**
     * 反转义HTML实体标签
     * @param $value
     * @return string
     */
    protected function setContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }

    /**
     * 序列化photo图集
     * @param $value
     * @return string
     */
    protected function setPhotoAttr($value)
    {
        return serialize($value);
    }

    /**
     * 反序列化photo图集
     * @param $value
     * @return mixed
     */
    protected function getPhotoAttr($value)
    {
        return unserialize($value);
    }

    /**
     * 创建时间
     * @return bool|string
     */
    //protected function setCreateTimeAttr()
    //{
    //    return date('Y-m-d H:i:s');
    //}
}