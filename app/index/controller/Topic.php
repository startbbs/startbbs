<?php
namespace app\index\controller;

use app\common\model\Topic as TopicModel;
use app\common\model\Post as PostModel;
use app\common\model\Attachment as AttachmentModel;
use app\common\model\User as UserModel;
use app\common\model\Category as CategoryModel;

use app\common\controller\HomeBase;

use Cache;

/**
 * 话题
 * Class Topic
 * @package app\index\controller
 */
class Topic extends HomeBase
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
        $this->attachment_model = new AttachmentModel();
        $this->user_model = new UserModel();


        $category_level_list = $this->category_model->getLevelList();
        $this->assign('category_level_list', $category_level_list);
    }

    /**
     * 话题管理
     * @param int    $cid     分类ID
     * @param string $keyword 关键词
     * @param int    $page
     * @return mixed
     */
    public function index($cid = 0, $keyword = '', $page = 1)
    {
        $map   = [];
        $field = 'id,title,cid,username,reading,status,update_time,sort';

        if ($cid > 0) {
            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }

        if (!empty($keyword)) {
            $map['title'] = ['like', "%{$keyword}%"];
        }

        $topic_list  = $this->topic_model->field($field)->where($map)->order(['update_time' => 'DESC'])->paginate(15, false, ['page' => $page]);
        $category_list = $this->category_model->column('name', 'id');

        return $this->fetch('index', ['topic_list' => $topic_list, 'category_list' => $category_list, 'cid' => $cid, 'keyword' => $keyword]);
    }

    /**
     * 添加话题
     * @return mixed
     */
    public function add()
    {
	    !is_login() && $this->error('没有登录', 'user/login');
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Topic');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
	            $data['uid'] = session('user_id');
	            $data['username']=session('user_name');
	            if(has_permission($data['uid'],2)){
					$data['ord'] = ($data['is_top'])?2*time():time(); 
	            }else{
		            $data['ord'] = time();
	            }
	            $files=Cache::get($data['attach']);
	            //附件地址替换
	            if($files){
		            $data['content'] = str_replace('tmp/'.$data['attach'],'attachment/'.date('Ym'),$data['content']);
	            }
	            
                if ($this->topic_model->allowField(true)->save($data)) {
	                $data['topic_id']=$this->topic_model->id;
	            	$data['is_first'] = 1;
	                $this->post_model->allowField(true)->save($data);
	                $this->topic_model->isUpdate(true)->save(['id' => $data['topic_id'], 'first_post_id' => $this->post_model->id]);
	                //更新统计
	                $count = array(
					  'topics'=>array('exp','topics+1'),
					  'posts'=>array('exp','posts+1'),
					);
					$this->category_model->where('id',$data['cid'])->setField($count);
					$this->user_model->where('id',$data['uid'])->setField($count);
					
		            //移动附件
		            if($files){
			            $upload_path = ROOT_PATH . 'public' . DS . 'uploads';
			            $tmp_path = $upload_path.DS.'tmp'.DS.$data['attach'];
			            $new_file_path = $upload_path.DS.'attachment'.DS.date('Ym');
			            $new_save_path = '/public/uploads/attachment'.DS.date('Ym');
			            if (!file_exists($new_file_path)) {
				        	mkdir ($new_file_path, 0777, true );
						}
			            foreach($files as $k=>$file){
				        	$tmp_file=$tmp_path.DS.$file['savename'];
				        	$new_file=$new_file_path.DS.$file['savename'];
				        	rename($tmp_file,$new_file);
				        	
				        	$url=$new_save_path.DS.$file['savename'];
				        	$attachs[]=$url;//备用
			                //附件入库
			                $file_data[] = array (
								'topic_id'=>$data['topic_id'],
								'post_id'=>$this->post_model->id,
								'uid' => $data['uid'],
								'original' => $file['name'],
								'file_name' => $file['savename'],
								'file_type' => $file['type'],
								'url' => $url,
								'size' => $file['size']
			                );
			            }
			            $this->attachment_model->saveAll($file_data,false);
			            rmdir($tmp_path);
		            }
		            
                    $this->success('发表成功','/topic/detail/id/'.$data['topic_id']);
                } else {
                    $this->error('保存失败');
                }
            }
        }else{
		    $this->assign('attach',time());
		    $this->assign('title','发表话题');
	        return $this->fetch();
        }

    }

	/**
	 * 话题详细页
	 * @param int $id
	 * @return mixed
	 */
	 public function detail($id)
	 {
	 	$topic = $this->topic_model->get($id)->toArray();
	 	if(!$topic){
		 	$this->error('话题不存在');
	 	}
	 	$post_list = $this->post_model->where('topic_id',$id)->order('is_first desc,update_time')->paginate(10);
	 	$page = $post_list->render();
	 	$post_list=$post_list->toArray();
	 	
		$content='';
	 	foreach($post_list['data'] as $k => $v )
	 	{
		 	if($v['is_first']){
			 	$content=$v['content'];
			 	unset($post_list['data'][$k]);
		 	}
	 	}
	 	$hottopic = $this->topic_model->field('id,title,posts')->order('posts','desc')->limit(10)->select();

	 	//更新浏览
	 	$this->topic_model->where('id', $id)->setInc('views', 1);
	 	$this->assign('topic',$topic);
	 	$this->assign('content',$content);
	 	$this->assign('post_list',$post_list['data']);
	 	$this->assign('page', $page);
	 	$this->assign('title',$topic['title']);
	 	$this->assign('attach',time());
	 	$this->assign('hottopic',$hottopic);
	 	
	 	//var_dump($post_list);
	 	return $this->fetch();
	 }
	 
    /**
     * 编辑话题
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $topic = $this->topic_model->find($id);
	    if(!has_permission($topic['uid'],1)){
		    $this->error('请确认有权限或未登录');
	    }
        $topic['content'] = $this->post_model->where('id',$topic['first_post_id'])->value('content');

        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Topic');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
	            $data['uid'] = session('user_id'); 
	            $data['ord'] = ($data['is_top'])?2*time():time();
	            
	            $files=Cache::get($data['attach']);
	            //附件地址替换
	            if($files){
		            $data['content'] = str_replace('tmp/'.$data['attach'],'attachment/'.date('Ym'),$data['content']);
	            }
	            
                if ($this->topic_model->allowField(true)->save($data, $id) !== false) {
	                $this->post_model->update(['id'=>$topic['first_post_id'],'content'=>$data['content']]);
		            //移动附件
		            if($files){
			            $upload_path = ROOT_PATH . 'public' . DS . 'uploads';
			            $tmp_path = $upload_path.DS.'tmp'.DS.$data['attach'];
			            $new_file_path = $upload_path.DS.'attachment'.DS.date('Ym');
			            $new_save_path = '/public/uploads/attachment'.DS.date('Ym');
			            if (!file_exists($new_file_path)) {
				        	mkdir ($new_file_path, 0777, true );
						}
			            foreach($files as $file){
				        	$tmp_file=$tmp_path.DS.$file['savename'];
				        	$new_file=$new_file_path.DS.$file['savename'];
				        	rename($tmp_file,$new_file);
				        	
				        	$url=$new_save_path.DS.$file['savename'];
				        	$attachs[]=$url;//备用
			                //附件入库
			                $file_data[] = array (
								'topic_id'=>$id,
								'post_id'=>$topic['first_post_id'],
								'uid' => $data['uid'],
								'original' => $file['name'],
								'file_name' => $file['savename'],
								'file_type' => $file['type'],
								'url' => $url,
								'size' => $file['size']
			                );
			            }
			            $this->attachment_model->saveAll($file_data,false);
			            rmdir($tmp_path);
		            }
                    $this->success('更新成功','/topic/detail/id/'.$id);
                } else {
                    $this->error('更新失败');
                }
            }
        }
        $this->assign('topic',$topic);
        $this->assign('title','编辑贴子');
		$this->assign('attach',time());
        return $this->fetch();
    }

    /**
     * 删除话题
     * @param int   $id
     * @param array $ids
     */
    public function delete($id = 0)
    {
	    $data = $this->topic_model->get($id);
	    if(!has_permission($data['uid'],1)){
		    $this->error('请确认有权限或未登录');
	    }
        if ($id) {
            if ($this->topic_model->destroy($id)) {
	            $posts = $this->post_model->where('topic_id',$id)->delete();
	            if($posts){
	                //更新统计
	                $count = array(
					  'topics'=>array('exp','topics-1'),
					  'posts'=>array('exp','posts-'.$posts),
					);
					$this->category_model->where('id',$data['cid'])->setField($count);
					$this->user_model->where('id',$data['uid'])->setField($count);
	            }
	            //删除附件
	            //需要判断是否有附件，再增加
	            $files=$this->attachment_model->where('topic_id',$id)->column('url');
	            if($files){
		            foreach($files as $file) {
			            unlink(ROOT_PATH.$file);
		            }
		            $this->attachment_model->where('topic_id',$id)->delete(); 
	            }
                $this->success('删除成功','/');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的话题');
        }
    }
	/**
	 * 置顶
	 * @param string $
	 * @return
	 */
	public function setTop($id,$top)
	{
		$topic = $this->topic_model->get($id);
	    if(!has_permission($topic['uid'],2)){
		    $this->error('请确认有权限或未登录');
	    }
	    if($top==1){
		    $data=array(
				'ord'=>2*time(),
				'is_top'=>1,
				'msg' =>'置顶成功'
		    );
	    }
	    if($top==0){
		    $data=array(
				'ord'=>time(),
				'is_top'=>0,
				'msg' =>'取消置顶'
		    );
	    }
	    if($topic->isUpdate(true)->save($data)){
		    $this->success($data['msg']);
	    }
	    
	}
	/**
	 * 设精华
	 * @param string $
	 * @return
	 */
	public function setRecommend($id,$recommend)
	{
		$topic = $this->topic_model->get($id);
	    if(!has_permission($topic['uid'],2)){
		    $this->error('请确认有权限或未登录');
	    }
	    if($recommend==1){
		    $data=array(
				'ord'=>time(),
				'is_recommend'=>1,
				'msg' =>'精华成功'
		    );
	    }
	    if($recommend==0){
		    $data=array(
				'ord'=>time(),
				'is_recommend'=>0,
				'msg' =>'取消精华'
		    );
	    }
	    if($topic->isUpdate(true)->save($data)){
		    $this->success($data['msg']);
	    }
	    
	}
	
    /**
     * 话题审核状态切换
     * @param array  $ids
     * @param string $type 操作类型
     */
    public function toggle($ids = [], $type = '')
    {
        $data   = [];
        $status = $type == 'audit' ? 1 : 0;

        if (!empty($ids)) {
            foreach ($ids as $value) {
                $data[] = ['id' => $value, 'status' => $status];
            }
            if ($this->topic_model->saveAll($data)) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->error('请选择需要操作的话题');
        }
    }
}