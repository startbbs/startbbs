<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use app\common\model\Article as ArticleModel;
use app\common\model\ArticleCategory as ArticleCategoryModel;
use think\Controller;
use think\Db;

/**
 * 文章详情信息获取
 * Class Article
 * @package app\index\controller
 */
class Article extends HomeBase
{
	/**
	 * 文章首页
	 * @param string $cid
	 * @return
	 */
    public function index()
    {
        $category_model = new ArticleCategoryModel();
        $article_model  = new ArticleModel();

        // 当前分类所有分类
        $category_list=$category_model->field('id,name,pid')->select();

        //热门文章
        $hotarticle = $article_model->limit(10)->order('reading','desc')->select();
        // 文章列表
        $articlelist = $article_model->order('create_time','desc')->paginate(10);
        $page = $articlelist->render();

        $this->assign([
            'title'   => '文章首页',
            'category_list' => $category_list,
            'articlelist'  => $articlelist,
            'hotarticle'  => $hotarticle,
            'page'  => $page,
        ]);

        return $this->fetch();
    }
	/**
	 * 文章列表页
	 * @param string $cid
	 * @return
	 */
    public function category($cid='')
    {
	    if(!$cid){
		    return false;
	    }
        $category_model = new ArticleCategoryModel();
        $article_model  = new ArticleModel();

        // 当前分类所有分类
        $category_list=$category_model->field('id,name,pid')->select();
        // 当前分类
        $category = $category_model->get($cid);

        //热门文章
        $hotarticle = $article_model->limit(10)->order('reading','desc')->select();
        // 文章列表
        $articlelist = $article_model->where('cid',$cid)->order('create_time','desc')->paginate(10);
        $page = $articlelist->render();

        $this->assign([
            'title'   => $category['name'].'列表',
            'category_list' => $category_list,
            'category' => $category,
            'articlelist'  => $articlelist,
            'hotarticle'  => $hotarticle,
            'page'  => $page,
        ]);

        return $this->fetch();
    }
	/**
	 * 文章详情页
	 * @param string $id
	 * @return
	 */
    public function detail($id='')
    {
        if (empty($id)) {
            return false;
        }

        $category_model = new ArticleCategoryModel();
        $article_model  = new ArticleModel();
        // 当前文章
        $article = $article_model->get($id);
        //热门文章
        $hotarticle = $article_model->limit(10)->order('reading','desc')->select();
        // 当前分类
        $cid = $article['cid'];
        $category = $category_model->get($article['cid']);
        // 当前分类所有分类
        $category_list=$category_model->field('id,name,pid')->select();

        // 当前分类所有子分类
        //$children = get_category_children($cid);
        $this->assign([
            'title'   => $article['title'],
            'description'   => $article['introduction'],
            'category'  => $category,
            'category_list'  => $category_list,
            'article'  => $article,
            'hotarticle'  => $hotarticle
        ]);

        return $this->fetch();
    }
}