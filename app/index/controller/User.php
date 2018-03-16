<?php
namespace app\index\controller;

use app\common\model\User as UserModel;
use app\common\model\Topic as TopicModel;
use app\common\model\Post as PostModel;
use app\common\controller\HomeBase;
use Config;
use think\Db;
use Session;

/**
 * 前台用户
 * Class HomeUser
 * @package app\admin\controller
 */
class User extends HomeBase
{
    protected $user_model;

    protected function initialize()
    {
        parent::initialize();
        $this->user_model = new UserModel();
    }
	/**
	 * 用户中心
	 * @param string $
	 * @return
	 */
	public function index()
	{
	    $topic_model=new TopicModel();
	    $id=Session::get('user_id');
	    $user_topic = $topic_model->where('uid',$id)->field('id,title,views,posts,update_time')->order('update_time','desc')->limit(10)->select();
	    $post_model=new PostModel();
	    $user_post = $topic_model->where('uid',$id)->field('id,title,views,posts,update_time')->limit(10)->select();
	    
	    $this->assign('user_topic', $user_topic);
	    $this->assign('user_post', $user_post);
		$this->assign('title','用户中心');
		$this->assign('action','index');
		
		return $this->fetch();
	}
    /**
     * 用户注册
     * @return mixed
     */
    public function register()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'User.register');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->user_model->allowField(true)->save($data)) {
                    $this->success('注册成功','user/login');
                } else {
                    $this->error('注册失败');
                }
            }
        } else {
		    $this->assign('title', '用户注册');
	        return $this->fetch();
        }

    }
	/**
	 * 用户登录
	 * @return string
	 */
    public function login()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->only(['username', 'password', 'verify']);
            $validate_result = $this->validate($data, 'User.login');
            
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $where['username'] = $data['username'];
                $user = Db::name('user')->field('id,group_id,username,password,avatar,status')->where($where)->find();
                if (password_verify($data['password'], $user['password'])) {
                    if ($user['status'] != 1) {
                        $this->error('当前用户已禁用');
                    } else {
                        Session::set('user_id', $user['id']);
                        Session::set('group_id', $user['group_id']);
                        Session::set('group_name',get_group_name($user['group_id']));
                        Session::set('user_name', $user['username']);
                        Session::set('avatar', $user['avatar'].'_small.png');
                        Db::name('user')->update(
                            [
                                'last_login_time' => time(),
                                'last_login_ip'   => $this->request->ip(),
                                'id'              => $user['id']
                            ]
                        );
                        $this->success('登录成功','index/index');
                    }
                } else {
                    $this->error('用户名或密码错误');
                }
            }
        } else {
	        $this->assign('title', '用户登录');
	        return $this->fetch();
        }
    }
    
    /**
     * 退出登录
     */
    public function logout()
    {
        Session::delete('user_id');
        Session::delete('group_id');
        Session::delete('group_name');
        Session::delete('user_name');
        Session::delete('avatar');  
        $this->success('退出成功', 'user/login');
    }
	/**
	 * 用户主页
	 * @param int $id 用户id
	 * @return mixed
	 */
    public function home($id)
    {
	    $user = $this->user_model->find($id);
	    if(!$user){
		    $this->error('用户不存在','index/index');
	    }
	    $topic_model=new TopicModel();
	    $user_topic = $topic_model->where('uid',$id)->limit(10)->select();
	    $post_model=new PostModel();
	    $user_post = $post_model->alias('p')->field('p.content,p.update_time,p.topic_id,t.title')->where('p.is_first!=1 AND p.uid='.$id)->join('topic t','p.topic_id = t.id')->limit(5)->order('update_time','desc')->select();

	    $this->assign('title', '用户主页');
	    $this->assign('user', $user);
	    $this->assign('user_topic', $user_topic);
	    $this->assign('user_post', $user_post);
		$this->assign('action','home');
	    return $this->fetch();
    }
	/**
	 * 修改用户信息
	 * @param string $
	 * @return
	 */
	public function set(){
	   	!is_login() && $this->error('没有登录', 'user/login');
	   	$user_id = session('user_id');
	   	if($this->request->isPost()){
		   	$data = $this->request->post();
		   	$validate_result = $this->validate($data, 'User.'.$data['tag']);
		   	//$validate_result = $this->scene('set')->check($data);
		   	if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->user_model->allowField(true)->save($data,['id' => $user_id])) {
                    $this->success('更新成功');
                } else {
                    $this->error('未更新');
                }
            }
	   	} else {
		   	$user = $this->user_model->find($user_id);
		   	$this->assign('title', '用户信息设定');
		   	$this->assign('user',$user);
		   	$this->assign('action','set');
		   	return $this->fetch();
	   	}
	}
    /**
     * 编辑用户
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = $this->user_model->find($id);

        return $this->fetch('edit', ['user' => $user]);
    }

    /**
     * 更新用户
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'User');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $user           = $this->user_model->find($id);
                $user->id       = $id;
                $user->username = $data['username'];
                $user->mobile   = $data['mobile'];
                $user->email    = $data['email'];
                $user->status   = $data['status'];
                if (!empty($data['password']) && !empty($data['confirm_password'])) {
                    $user->password = md5($data['password'] . Config::get('salt'));
                }
                if ($user->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

}