<?php
namespace app\common\controller;

use Cache;
use think\Controller;
use Db;
use View;
use Env;

class HomeBase extends Controller
{


    protected function initialize()
    {
        parent::initialize();
        if (config('base.site_status') != 1) {
           exit('站点已关闭');
        }
		if(!is_file('./public/static/install/install.lock')){
            $this->redirect('/install.php');
        }
        $this->getNav();
        //$this->getSlide();
        print_r($this->getCategory());
		define('ROOT_PATH',Env::get('root_path'));
		define('DS',DIRECTORY_SEPARATOR); 
    }

    /**
     * 获取前端导航列表
     */
    protected function getNav()
    {
	    Cache::remember('nav',function(){
			$nav = Db::name('nav')->where(['status' => 1])->order(['sort' => 'ASC'])->select();
			$nav = !empty($nav) ? array2tree($nav) : [];
			return $nav;
		});
        $nav = Cache::get('nav');
		View::share('nav',$nav);
        //$this->assign('nav', $nav);
    }

    /**
     * 获取前端轮播图
     */
    protected function getSlide()
    {
        if (Cache::has('slide')) {
            $slide = Cache::get('slide');
        } else {
            $slide = Db::name('slide')->where(['status' => 1, 'cid' => 1])->order(['sort' => 'DESC'])->select();
            if (!empty($slide)) {
                Cache::set('slide', $slide);
            }
        }

        $this->assign('slide', $slide);
    }

    /**
     * 获取分类版块列表
     */
    protected function getCategory()
    {
        if (Cache::has('category_list')) {
            $category_list = Cache::get('category_list');
        } else {
            $category_list = Db::name('category')->order(['sort' => 'ASC'])->select();
            if (!empty($category_list)) {
                Cache::set('category_list', $category_list);
            }
        }
            $category_list = !empty($category_list) ? array2tree($category_list) : [];
        $this->assign('category_list', $category_list);
       // return $category_list;
    }

}