<?php
namespace app\common\model;

use think\Model;

class Attachment extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    /**
     * 创建时间
     * @return bool|string
     */
    //protected function setCreateTimeAttr()
    //{
    //    return date('Y-m-d H:i:s');
    //}
}