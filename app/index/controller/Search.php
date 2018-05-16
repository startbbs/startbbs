<?php
namespace app\index\controller;

use app\common\model\Topic as TopicModel;
use app\common\controller\HomeBase;

/**
 * 搜索
 * Class Search
 * @package app\index\controller
 */
class Search extends HomeBase
{
    protected $topic_model;

    protected function initialize()
    {
        parent::initialize();
        $this->topic_model  = new TopicModel();
    }

    /**
     * 搜索列表
     * @param string $keyword 关键词
     * @param int    $page
     * @return mixed
     */
    public function index()
    {
	    $k = input('k');
	    $k_code=urldecode($k);
	    if(!$k){
		    $this->error('关键词不得为空');
	    }
	    $data = $this->topic_model->where('status',1)->whereLike('title','%'.$k_code.'%')->order('update_time','DESC')->paginate(15, false, ['query' => array('k' => $k)]);
	    $this->assign([
	    	'title'=>$k.'的搜索结果',
	    	'keyword' => $k,
	    	'topic_list' => $data,

	    ]);
        return $this->fetch();
    }

}