<?php
namespace app\index\validate;

use think\Validate;

class Topic extends Validate
{
    protected $rule = [
        'cid'   => 'require',
        'title' => 'require',
        'content'  => 'require'
    ];

    protected $message = [
        'cid.require'   => '请选择所属栏目',
        'title.require' => '请输入标题',
        'content.require'  => '请输入内容',
    ];
}