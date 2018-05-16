<?php
namespace app\admin\model;

use think\Model;

/**
 * 钩子模型
 * @package app\admin\model
 */
class Hook extends Model
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

}