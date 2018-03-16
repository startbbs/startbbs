<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use Session;

/**
 * 修改密码
 * Class ChangePassword
 * @package app\admin\controller
 */
class ChangePassword extends AdminBase
{
    /**
     * 修改密码
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('system/change_password');
    }

    /**
     * 更新密码
     */
    public function updatePassword()
    {
        if ($this->request->isPost()) {
            $admin_id    = Session::get('user_id');
            $data   = $this->request->param();
            $result = Db::name('user')->find($admin_id);

            if (password_verify($data['old_password'], $result['password'])) {
                if ($data['password'] == $data['confirm_password']) {
                    $new_password = password_hash($data['password'], PASSWORD_DEFAULT);
                    $res          = Db::name('user')->where(['id' => $admin_id])->setField('password', $new_password);

                    if ($res !== false) {
                        $this->success('修改成功');
                    } else {
                        $this->error('修改失败');
                    }
                } else {
                    $this->error('两次密码输入不一致');
                }
            } else {
                $this->error('原密码不正确');
            }
        }
    }
}