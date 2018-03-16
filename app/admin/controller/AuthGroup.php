<?php
namespace app\admin\controller;

use app\common\model\AuthGroup as AuthGroupModel;
use app\common\model\AuthRule as AuthRuleModel;
use app\common\controller\AdminBase;
use think\Db;
use Cache;

/**
 * 权限组
 * Class AuthGroup
 * @package app\admin\controller
 */
class AuthGroup extends AdminBase
{
    protected $auth_group_model;
    protected $auth_rule_model;

    protected function initialize()
    {
        parent::initialize();
        $this->auth_group_model = new AuthGroupModel();
        $this->auth_rule_model  = new AuthRuleModel();
    }

    /**
     * 权限组
     * @return mixed
     */
    public function index()
    {
        $auth_group_list = $this->auth_group_model->select();

        return $this->fetch('index', ['auth_group_list' => $auth_group_list]);
    }

    /**
     * 添加权限组
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存权限组
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if ($this->auth_group_model->save($data) !== false) {
		        $group_list=Db::name('auth_group')->select();
				Cache::set('group_list',$group_list);
                $this->success('保存成功');
            } else {
                $this->error('保存失败');
            }
        }
    }

    /**
     * 编辑权限组
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $auth_group = $this->auth_group_model->find($id);

        return $this->fetch('edit', ['auth_group' => $auth_group]);
    }

    /**
     * 更新权限组
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();

            if ($id == 1 && $data['status'] != 1) {
                $this->error('超级管理组不可禁用');
            }
            if ($this->auth_group_model->save($data, $id) !== false) {
                $this->success('更新成功');
            } else {
                $this->error('更新失败');
            }
        }
    }

    /**
     * 删除权限组
     * @param $id
     */
    public function delete($id)
    {
        if ($id == 1) {
            $this->error('超级管理组不可删除');
        }
        if ($this->auth_group_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 授权
     * @param $id
     * @return mixed
     */
    public function auth($id)
    {
        $auth_group_data = $this->auth_group_model->find($id)->toArray();
        $auth_rules      = explode(',', $auth_group_data['rules']);
        $auth_rule_list  = $this->auth_rule_model->field('id,pid,title')->select();
        //var_dump($auth_rules);
		$auth_rule_list=$auth_rule_list->toArray();
        foreach ($auth_rule_list as $key => $value) {
            if(in_array($value['id'], $auth_rules)){
            	$auth_rule_list[$key]['checked'] = ' checked="checked"';
            }else {
            	$auth_rule_list[$key]['checked'] = '';
            }
            
        }
		

        $this->assign('auth_rule_list',array2tree($auth_rule_list));
//var_dump(array2tree($auth_rule_list));
        $this->assign('id',$id);
        $this->assign('rules',$auth_group_data['rules']);
        return $this->fetch();
    }

    /**
     * AJAX获取规则数据
     * @param $id
     * @return mixed
     */
    public function getJson($id)
    {
        $auth_group_data = $this->auth_group_model->find($id)->toArray();
        $auth_rules      = explode(',', $auth_group_data['rules']);
        $auth_rule_list  = $this->auth_rule_model->field('id,pid,title')->select();

        foreach ($auth_rule_list as $key => $value) {
            in_array($value['id'], $auth_rules) && $auth_rule_list[$key]['checked'] = true;
        }

        return $auth_rule_list;
    }

    /**
     * 更新权限组规则
     * @param $id
     * @param $auth_rule_ids
     */
    public function updateAuthGroupRule()
    {
        if ($this->request->isPost()) {
	        $id = $this->request->param('id');
            if ($id) {
                $group_data['id']    = $id;
                $auth_rule_ids = $this->request->param('rules/a');
                
                $group_data['rules'] = is_array($auth_rule_ids) ? implode(',', $auth_rule_ids) : '';

                if ($this->auth_group_model->save($group_data, $id) !== false) {
                    $this->success('授权成功');
                } else {
                    $this->error('授权失败');
                }
            }
        }
    }
}