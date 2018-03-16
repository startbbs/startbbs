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
 * 贴子
 * Class Post
 * @package app\index\controller
 */
class Post extends HomeBase
{
    protected $topic_model;
    protected $post_model;

    protected function initialize()
    {
        parent::initialize();
        $this->topic_model  = new TopicModel();
        $this->post_model  = new PostModel();
        $this->attachment_model = new AttachmentModel();
        $this->category_model = new CategoryModel();
        $this->user_model = new UserModel();
    }
    
    /**
     * 发表回贴
     * @return mixed
     */
    public function add()
    {
	    !is_login() && $this->error('没有登录', 'user/login');
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Post');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
	            $data['uid'] = session('user_id');
	            $data['username']=session('user_name');
	            
	            $files=Cache::get($data['attach']);
	            //附件地址替换
	            if($files){
		            $data['content'] = str_replace('tmp/'.$data['attach'],'attachment/'.date('Ym'),$data['content']);
	            }
                if ($this->post_model->allowField(true)->save($data)) {
	                //更新统计
					$this->category_model->where('id',$data['cid'])->setInc('posts');
					$this->user_model->where('id',$data['uid'])->setInc('posts');
					$this->topic_model->where('id',$data['topic_id'])->setInc('posts');
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
			                $file_data = array (
								'topic_id'=>$data['topic_id'],
								'post_id'=>$this->post_model->id,
								'uid' => $data['uid'],
								'original' => $file['name'],
								'file_name' => $file['savename'],
								'file_type' => $file['type'],
								'url' => $url,
								'size' => $file['size']
			                );
			                
			                $this->attachment_model->save($file_data);
			            }
			            rmdir($tmp_path);
		            }
                    $this->success('回贴成功','/topic/detail/id/'.$data['topic_id']);
                } else {
                    $this->error('保存失败');
                }
            }
        }else{
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
	 	$post_list = $this->post_model->where('topic_id',$id)->order('update_time desc,is_first')->paginate(10)->toArray();
		$content=$post_list['data'][0]['content'];
		unset($post_list['data'][0]);
		
	 	$this->assign('topic',$topic);
	 	$this->assign('content',$content);
	 	$this->assign('post_list',$post_list['data']);
	 	$this->assign('title',$topic['title']);
	 	//var_dump($post_list);
	 	return $this->fetch();
	 }
	 
    /**
     * 编辑贴子
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
	    !is_login() && $this->error('没有登录', 'user/login');
        $post = $this->post_model->find($id);

        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Post');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
	            $data['uid'] = session('user_id');  
	            $files=Cache::get($data['attach']);
	            //附件地址替换
	            if($files){
		            $data['content'] = str_replace('tmp/'.$data['attach'],'attachment/'.date('Ym'),$data['content']);
	            }
	            
                if ($this->post_model->allowField(true)->save($data, $id) !== false) {
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
								'topic_id'=>$post['topic_id'],
								'post_id'=>$id,
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
                    $this->success('更新成功','/topic/detail/id/'.$post['topic_id']);
                } else {
                    $this->error('更新失败');
                }
            }
        }
        $this->assign('post',$post);
        $this->assign('title','编辑贴子');
		$this->assign('attach',time());
        return $this->fetch();
    }


    /**
     * 删除贴子
     * @param int   $id
     * @param array $ids
     */
    public function delete($id = 0)
    {
	    $data = $this->post_model->get($id);
	    if(!has_permission($data['uid'])){
		    $this->error('请确认有权限或未登录');
	    }
        if ($id) {
            if ($this->post_model->destroy($id)) {
                //更新统计
				$this->topic_model->where('id',$data['topic_id'])->setDec('posts');
				$this->category_model->where('id',$data['cid'])->setDec('posts');
				$this->user_model->where('id',$data['uid'])->setDec('posts');
	            //删除附件
	            //需要判断是否有附件，再增加
	            $files=$this->attachment_model->where('post_id',$id)->column('url');
	            if($files){
		            foreach($files as $file) {
			            unlink(ROOT_PATH.$file);
		            }
		            $this->attachment_model->where('post_id',$id)->delete(); 
	            }
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的话题');
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