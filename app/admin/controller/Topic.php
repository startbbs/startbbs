<?php
namespace app\admin\controller;

use app\common\model\Topic as TopicModel;
use app\common\model\Post as PostModel;
use app\common\model\Category as CategoryModel;
use app\common\controller\AdminBase;

/**
 * 话题管理
 * Class Topic
 * @package app\admin\controller
 */
class Topic extends AdminBase
{
    protected $topic_model;
    protected $category_model;

    protected function initialize()
    {
        parent::initialize();
        $this->topic_model  = new TopicModel();
        $this->post_model  = new PostModel();
        $this->category_model = new CategoryModel();

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
        $field = 'id,title,cid,username,views,status,update_time,sort';

        if ($cid > 0) {
            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }

        if (!empty($keyword)) {
            $map['title'] = ['like', "%{$keyword}%"];
        }

        $topic_list  = $this->topic_model->field($field)->where($map)->order(['update_time' => 'DESC'])->paginate(15);
        $category_list = $this->category_model->column('name', 'id');

        return $this->fetch('index', ['topic_list' => $topic_list, 'category_list' => $category_list, 'cid' => $cid, 'keyword' => $keyword]);
    }

    /**
     * 添加话题
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存话题
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Topic');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->topic_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑话题
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $topic = $this->topic_model->find($id);
        $topic['content'] = $this->post_model->where('id',$topic['first_post_id'])->value('content');

        return $this->fetch('edit', ['topic' => $topic]);
    }

    /**
     * 更新话题
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Topic');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->topic_model->allowField(true)->save($data, $id) !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除话题
     * @param int   $id
     * @param array $ids
     */
    public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->topic_model->destroy($id)) {
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