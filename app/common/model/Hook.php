<?php
namespace app\common\model;

use think\Model;
use Session;

class Hook extends Model
{
	protected $autoWriteTimestamp = true;
    //protected $insert = ['create_time'];
    /**
     * 添加钩子
     * @param array $hooks 钩子
     * @param string $addon_name 插件名称
     * @return bool
     */
    public static function addHooks($hooks = [])
    {
        if ($hooks && is_array($hooks)) {
            $data = [];
            foreach ($hooks as $name => $description) {
                if (is_numeric($name)) {
                    $name = $description;
                    $description = '';
                }
                if (self::where('name', $name)->find()) {
                    continue;
                }
                $data[] = [
                    'name'        => $name,
                    'description' => $description,
                    'create_time' => request()->time(),
                    'update_time' => request()->time(),
                ];
            }
            if ($data && false === self::insertAll($data)) {
                return false;
            }
        }
        return true;
    }
    /**
     * 删除钩子
     * @param string $name 标识
     * @return bool
     */    
    public static function delHook($name = '')
    {
        if (empty($name)) {
            return false;
        }

        if (self::where('name', $name)->delete() === false) {
            return false;
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