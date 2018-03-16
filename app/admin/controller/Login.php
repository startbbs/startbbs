<?php
namespace app\admin\controller;

use Config;
use think\Controller;
use think\Db;
use Session;

/**
 * 后台登录
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    /**
     * 后台登录
     * @return mixed
     */
    public function index()
    {
	    if(Session::get('group_id')==1){
		    $this->redirect('/admin.php');
	    }
        return $this->fetch();
    }

    /**
     * 登录验证
     * @return string
     */
    public function login()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->only(['username', 'password', 'verify']);
            $validate_result = $this->validate($data, 'Login');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $where['username'] = $data['username'];
                //$where['password'] = md5($data['password'] . Config::get('salt'));

                $admin_user = Db::name('user')->field('id,group_id,username,password,avatar,status')->where($where)->find();
                if($admin_user['group_id']!=1){
	                $this->error('非管理员用户');
                }
                if (password_verify($data['password'], $admin_user['password'])) {
                    if ($admin_user['status'] != 1) {
                        $this->error('当前用户已禁用');
                    } else {
                        Session::set('group_id', $admin_user['group_id']);
                        Session::set('user_id', $admin_user['id']);
                        Session::set('user_name', $admin_user['username']);
                        Session::set('group_name',get_group_name($admin_user['group_id']));
                        Session::set('avatar', $admin_user['avatar'].'_small.png');
                        Db::name('user')->update(
                            [
                                'last_login_time' => time(),
                                'last_login_ip'   => $this->request->ip(),
                                'id'              => $admin_user['id']
                            ]
                        );
                        $this->success('登录成功', 'admin/index/index');
                    }
                } else {
                    $this->error('用户名或密码错误');
                }
            }
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Session::delete('group_id');
        Session::delete('user_id');
        Session::delete('user_name');
        Session::delete('group_name');
        Session::delete('avatar');
        $this->success('退出成功', 'admin/login/index');
    }
}
