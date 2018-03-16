<?php
namespace app\index\controller;

use app\common\model\Topic as TopicModel;
use app\common\model\Post as PostModel;

use app\common\model\Category as CategoryModel;
use app\common\controller\HomeBase;

/**
 * 版块
 * Class Category
 * @package app\index\controller
 */
class Category extends HomeBase
{
    protected $topic_model;
    protected $post_model;
    protected $category_model;

    protected function initialize()
    {
        parent::initialize();
        $this->topic_model  = new TopicModel();
        $this->post_model  = new PostModel();
        $this->category_model = new CategoryModel();
    }
	/**
	 * 版块列表
	 * @param string $
	 * @return mixed
	 */
    public function index()
    {
	    $this->assign('title', '版块导航');
		return $this->fetch();
    }
    
	/**
	 * 版块话题列表
	 * @param int $id
	 * @return mixed
	 */
	public function topic($id)
	{
    	$topiclist = $this->topic_model->where('cid',$id)->order('ord','desc')->paginate(10);
    	$page=$topiclist->render();
    	$category = $this->category_model->get($id);

    	$hottopic = $this->topic_model->field('id,title,views')->where('cid',$id)->order('views','desc')->limit(10)->select();


    	$title=$category['name'];
        $this->assign('topiclist', $topiclist);
        $this->assign('page', $page);
        $this->assign('category', $category);
        $this->assign('hottopic', $hottopic);
        $this->assign('title', $title);
        return $this->fetch();
	}

}