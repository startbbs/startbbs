<?php
namespace app\admin\controller;

use app\common\model\User as UserModel;
use app\common\model\Topic;
use app\common\model\Post;
use app\common\controller\AdminBase;
use Config;
use Db;

/**
 * 用户管理
 * Class AdminUser
 * @package app\admin\controller
 */
class User extends AdminBase
{
    protected $user_model;

    protected function initialize()
    {
        parent::initialize();
        $this->user_model = new UserModel();
    }

    /**
     * 用户管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
        $map = [];
        if ($keyword) {
            $map[] = ['username|mobile|email','like', "%{$keyword}%"];
        }
        $user_list = $this->user_model->where($map)->order('id DESC')->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', ['user_list' => $user_list, 'keyword' => $keyword]);
    }

    /**
     * 添加用户
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存用户
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'User');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $data['password'] =password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->user_model->allowField(true)->save($data)) {
                    $this->success('添加成功','user/index');
                } else {
                    $this->error('保存失败');
                }
            }
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
                    $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                if ($user->save() !== false) {
                    $this->success('更新成功','user/index');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除用户
     * @param $id
     */
    public function delete($id)
    {
        if ($this->user_model->destroy($id)) {
	        Topic::where('uid',$id)->delete();
	        Post::where('uid',$id)->delete();
	        //将来需要更新栏目统计和话题统计
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}