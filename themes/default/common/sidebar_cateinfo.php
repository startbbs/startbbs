<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo $cate['cname'];?>
    </div>
    <div class="panel-body">
        <p><?php echo $cate['content'];?></p>
        <a href="<?php echo url('node_show',$cate['node_id']);?>" class="btn btn-default btn-sm">此节点</a>
<a href="<?php echo site_url('topic/add/'.$cate['node_id'])?>" class="btn btn-sm btn-success">新建话题</a>
<a href="<?php echo url('topic_show',$content['previous'])?>" class="btn btn-default btn-sm">上一贴</a>
<a href="<?php echo url('topic_show',$content['next'])?>" class="btn btn-default btn-sm">下一贴</a>
    </div>
</div>