<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('common/header');?>
    <div class="container">
        <div class="row">
            <?php $this->load->view ('common/sidebar');?>
            <div class="col-md-9">
                <ol class="breadcrumb">
				  <li><a href="<?php echo site_url('admin/login')?>">管理首页</a></li>
				  <li class="active">话题</li>
				</ol>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">所有主题</h3>
                    </div>
                    <div class="panel-body table-responsive">
						<?php if($topics){?>
						<form name="myform" method="post" action="<?php echo site_url('admin/topics/batch_process')?>">
						<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
						<div class='input-group'>
						<table class='table table-hover table-condesed'>
						<thead>
						<tr>
						<th><input id="checkall" type="checkbox" checked="1"></th>
						<th>ID</th>
						<th>节点</th>
						<th>标题</th>
						<th>作者</th>
						<th>回复</th>
						<th>时间</th>
						<th>操作</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($topics as $k=>$v){ ?>
						<tr>
						<td>
						<input name="<?php echo $k?>" checked="1" value="<?php echo $v['topic_id']?>" type="checkbox">
						</td>
						<td>
						<strong>
						<?php echo $v['topic_id']?>
						</strong>
						</td>
						<td>
						<a href="<?php echo site_url('node/show/'.$v['node_id']);?>"><?php echo sb_substr($v['cname'],10)?></a>
						</td>
						<td>
						<a href="<?php echo site_url('topic/show/'.$v['topic_id']);?>"><?php echo sb_substr($v['title'],10)?></a>
						</td>
						<td>
						<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" title="admin"><?php echo $v['username']?></a>
						</td>
						<td>
						<?php echo $v['comments']?>
						</td>
						<td>
						<small><?php echo date('Y-m-d',$v['addtime'])?></small>
						</td>
						<td>
						<a href="<?php echo site_url('topic/edit/'.$v['topic_id']);?>" class="btn btn-primary btn-sm">编辑</a>
						<a href="<?php echo site_url('admin/topics/del/'.$v['topic_id'].'/'.$v['node_id'].'/'.$v['uid']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗？" data-method="delete" rel="nofollow">删除</a>
						<?php if($v['is_top']==0){?>
						<a href="<?php echo site_url('admin/topics/set_top/'.$v['topic_id']).'/'.$v['is_top'];?>" class="btn btn-primary btn-sm">置顶</a>
						<?php } else {?>
						<a href="<?php echo site_url('admin/topics/set_top/'.$v['topic_id']).'/'.$v['is_top'];?>" class="btn btn-primary btn-sm">取消置顶</a>
						<?php } ?>
						<?php if($v['is_hidden']==1){?>
						<a href="<?php echo site_url('admin/topics/approve/'.$v['topic_id']);?>" class="btn btn-primary btn-sm">审</a>
						<?php } ?>
						</td>
						</tr>
						<?php } ?>

						</tbody>
						</table>
						<?php if($pagination){?><ul class="pagination"><?php echo $pagination;?></ul><?php }?>
						<div class='form-actions'>
						<input class="btn btn-primary btn-danger" name="batch_del" type="submit" value="批量删除" />
						<input class="btn btn-primary" name="batch_approve" type="submit" value="批量审核" />
						</div>
						<?php } else{?>
						暂无贴子
						<?php }?>
                    </div>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer');?>
<script type="text/javascript">
$(document).ready(function(){
  $("#checkall").bind('click',function(){
  $("input:checkbox").prop("checked",$(this).prop("checked"));//全选
  });
});
</script>
</body></html>
