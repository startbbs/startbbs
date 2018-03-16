<?php
namespace app\index\validate;

use think\Validate ;
use Db;
use Session;

class User extends Validate
{
    protected $rule = [
		'username' => 'require|min:3|unique:user|chsAlphaNum',
		'password' => 'require|length:6,20',
		'confirm_password' => 'confirm:password',
		'email' => 'email|unique:user',
		'verify' => 'require|captcha',
		'old_password' => 'require|check_password:1',
		
    ];
    protected $message  =   [
        'name.require' => '请输入用户名',
        'name.min' => '用户名最小长度3',
        'name.unique' => '用户名已存在',
        'name.chsAlphaNum' => '用户名只能为字母、数字、中文',
        'password.require'     => '请输入密码',
        'password.length'     => '密码长度6-20位',
        'confirm_password.confirm'   => '两次输入密码不一致',
        'email.email'  => '邮箱格式错误',
        'email.unique'  => '邮箱已存在',    
        'verify.require'  => '请输入验证码',    
        'verify.captcha'  => '验证码不正确',    
        'old_password.require'  => '原密码不能为空',    
        'old_password.check_password'  => '原密码不正确',    
    ];
    // register验证场景定义
    public function sceneRegister()
    {
    	return $this->only(['username','password','confirm_password','email','verify']);
    }
    public function sceneLogin()
    {
    	return $this->only(['username','password','verify'])
    			->remove('username', 'unique');
    }
    public function sceneSet_info()
    {
    	return $this->only(['email'])
    			->append('email', 'unique:user,email^id');
    }
    public function sceneSet_pass()
    {
    	return $this->only(['old_password','password','confirm_password']);
    }

	protected function check_password($value, $rule){
		$user_id=Session::get('user_id');
		$password=Db::name('user')->where('id',$user_id)->value('password');
		if(password_verify($value,$password)){
			return true;
		}else{
			return false;
		}
		
	}
	//protected function check_username($value, $rule){
	//	if(preg_match('/^(?!_)(?!.*?_$)[A-Za-z0-9]+$/',$value)){
	//		return true;
	//	}else{
	//		return false;
	//	}
		
	//}
}