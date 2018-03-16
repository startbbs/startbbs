<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use Cache;
use think\Db;
use app\admin\model\System as systemModel;
use Config;
use think\facade\Env;
/**
 * 系统配置
 * Class System
 * @package app\admin\controller
 */
class System extends AdminBase
{
    public function initialize()
    {
        parent::initialize();
        $this->systemmodel=new systemModel();
    }

    /**
     * 站点配置
     */
    public function siteConfig($group="base")
    {
	    (string)$group || $this->error('参数错误');
	    $where =array(
			['group','=',$group],
			['status','=',1],
	    );
	    
        $site_config = Db::name('system')->where($where)->order('sort')->select();
        $group_list  = Config::get('system.group_list') ?: null;
        $this->assign([
			'site_config' => $site_config,
			'group' => $group,
			'group_list' => $group_list
        ]);
        return $this->fetch('site_config');
    }

    /**
     * 更新配置
     */
    public function updateSiteConfig()
    {
        if ($this->request->isPost()) {
	                
        $site_config = $this->request->post('config/a');

        foreach ($site_config as $name => $value) {
           $status= $this->systemmodel->where(['name' => $name])->setField('value', $value);
           if ($status===false){
               $this->error='系统错误，请稍候再试';
               return false;
           }
        }

        Cache::clear('system_config');
        $this->success('提交成功');
        }
    }

    /**
     * 清除缓存
     */
    public function clear()
    {
        if (delete_dir_file(Env::get('runtime_path') . 'cache/') || delete_dir_file(Env::get('runtime_path'). 'temp/')) {
            $this->success('清除缓存成功');
        } else {
            $this->error('清除缓存失败');
        }
    }
}