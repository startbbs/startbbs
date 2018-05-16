<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;

use app\common\model\Hook as HookModel;
use app\common\model\HookPlugin as HookPluginModel;

/**
 * 钩子控制器
 * @package app\admin\controller
 */
class Hook extends AdminBase
{

    /**
     * 首页
     * @author 烧饼 <858292510@qq.com>
     * @return mixed
     */
    public function index($q = '')
    {
        $map = [];
        if ($q) {
            $map['name'] = ['like', '%'.$q.'%'];
        }
        
        $data_list = HookModel::where($map)->paginate();
        // 分页
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }

    /**
     * 添加钩子
     * @author 烧饼 <858292510@qq.com>
     * @return mixed
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->only(['name', 'description']);
            $validate_result = $this->validate($data, 'Hook.add');
            if ($validate_result !== true) {
                $this->error($validate_result);
            }
            $mod = new HookModel();
            if (!$mod->save($data)) {
                return $this->error('添加没有成功');
            }
            return $this->success('保存成功。','admin/hook/index');
        }
        $this->assign('hook_plugin', '');
        return $this->fetch();
    }

    /**
     * 修改钩子
     * @author 烧饼 <858292510@qq.com>
     * @return mixed
     */
    public function edit($id = 0)
    {
        if ($this->request->isPost()) {

            $data            = $this->request->only(['name', 'description','plugin']);
            	        //var_dump($data['plugin']);
            $validate_result = $this->validate($data, 'Hook.edit');
            if ($validate_result !== true) {
                $this->error($validate_result);
            }

            $hookmodel = new HookModel();
            if (!$hookmodel->allowField(true)->save($data,['id'=>$id])) {
                return $this->error('更新失败');
            }
            $hookpluginmodel = new HookPluginModel();
            foreach($data['plugin'] as $k=>$v){
	            $hookpluginmodel->where(['hook'=>$data['name'],'plugin'=>$k])->update(['sort'=>$v]);
            }
            return $this->success('保存成功。');
        }
        $hook = HookModel::where('id', $id)->field('id,name,description,system')->find()->toArray();
        if ($hook['system'] == 1) {
            return $this->error('禁止编辑系统钩子！');
        }
        // 关联的插件
        $hook_plugin = HookPluginModel::where('hook', $hook['name'])->order('sort')->column('id,plugin,sort');
        $this->assign('hook', $hook);
        $this->assign('hook_plugin', $hook_plugin);
        return $this->fetch();
    }

    /**
     * 删除钩子
     * @author 烧饼 <858292510@qq.com>
     * @return mixed
     */
    public function delete($id)
    {
	    $id=(int)$id;
	    $data=HookModel::where('id',$id)->field('name,system')->find();
	    if($data){
		    if($data['system']==1){
			    $this->error('禁止删除系统钩子！');
		    }
		    HookPluginModel::where('hook',$data['name'])->delete();
		    $data->delete();
	    	$this->success('钩子删除成功');
	    } else {
		    $this->error('钩子不存在！');
	    }
    }

    /**
     * 状态设置
     * @author 烧饼 <858292510@qq.com>
     * @return mixed
     */
    public function status()
    {
        $id     = input('param.ids/d');
        $val    = input('param.val/d');
        $map = [];
        $map['id'] = $id;
        $system = HookModel::where('id', $id)->value('system');
        // 排除系统钩子
        if ($system == 1) {
            return $this->error('禁止操作系统钩子！');
        }
        $res = HookModel::where('id', $id)->setField('status', $val);;
        if ($res === false) {
            return $this->error('操作失败！');
        }
        return $this->success('操作成功！');
    }
}
