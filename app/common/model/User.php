<?php
namespace app\common\model;

use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     * 创建时间
     * @return bool|string
     */
    //protected function setCreateTimeAttr()
    //{
    //    return date('Y-m-d H:i:s');
    //}
}