<?php
namespace app\index\validate;

use think\Validate;

class Post extends Validate
{
    protected $rule = [
        'content'  => 'require',
        'topic_id'   => 'require'
    ];

    protected $message = [
        'content.require'  => '请输入内容',
        'topic_id.require' => '缺少topic_id'
    ];
}