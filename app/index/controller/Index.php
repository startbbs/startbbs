<?php
namespace app\index\controller;

use app\common\model\Category as CategoryModel;
use app\common\model\Topic as TopicModel;
use app\common\model\User as UserModel;
use app\common\controller\HomeBase;
use Db;
use Cache;
use Session;


use app\common\model\Attach as AttachModel;

class Index extends HomeBase
{
    public function index()
    {
        $this->category_model = new CategoryModel();
        $this->topic_model = new TopicModel();
        $toptopiclist = array();
        $this->assign('toptopiclist', $toptopiclist);
        
        $newtopiclist = $this->topic_model->limit(15)->order('ord','desc')->select();
        
        
        $hottopiclist=array();
        $this->user_model = new UserModel();
        $user_list = $this->user_model->limit(12)->order('posts desc')->select();
        $this->assign('newtopiclist', $newtopiclist);
        $hottopiclist = $this->topic_model->limit(10)->order('views','desc')->select();
        $this->assign('hottopiclist', $hottopiclist);
        $this->assign('user_list', $user_list);

        $link = Db::name('link')->select();

        $title = '首页';
        $this->assign('title', $title);
        $this->assign('link', $link);

        
        return $this->fetch();
    }
}
