<?php
namespace app\common\model;

use think\Model;
use Session;

class Topic extends Model
{
	protected $autoWriteTimestamp = true;
    //protected $insert = ['create_time'];

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