<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 后台钩子验证
 * Class Hook
 * @package app\admin\validate
 */
class Hook extends Validate
{
    protected $rule = [
        'name' => 'require|alphaDash|unique:hook',
    ];

    protected $message = [
        'name.require' => '请输入钩子名称',
        'name.alphaDash' => '钩子名称只能为为字母和数字，下划线_及破折号',
        'name.unique' => '钩子名称已存在',
    ];
    public function sceneAdd()
    {
    	return $this->only(['name']);
    }
    public function sceneEdit()
    {
    	return $this->only(['name'])
    			->remove('name', 'unique');
    }
}