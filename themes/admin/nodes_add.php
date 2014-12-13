<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ( 'common/header-meta' ); ?>
</head>
<body id="startbbs">
<?php $this->load->view ( 'common/header' ); ?>
    <div class="container">
        <div class="row">
            <?php $this->load->view ('common/sidebar');?>
            <div class="col-md-9">
                <ol class="breadcrumb">
				  <li><a href="<?php echo site_url('admin/login')?>">管理首页</a></li>
				  <li><a href="<?php echo site_url('admin/nodes')?>">结点列表</a></li>
				  <li class="active">增加结点</li>
				</ol>
                <div class="panel panel-default">
	                <div class="panel-heading">
		            <h4>
		            添加节点<span class="small pull-right"><a href="<?php echo site_url('admin/nodes');?>">返回分类列表</a></span>
		            </h4>
		            </div>
                    <div class="panel-body">
						<form accept-charset="UTF-8" action="<?php echo site_url('admin/nodes/add');?>" class="form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
						<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
						<div class="form-group">
						<label class="col-md-3 control-label" for="cname">分类名称</label>
						<div class="col-md-5">
						<input class="form-control" id="cname" name="cname" type="text" value="" /></div></div>
						<div class="form-group">
						<label class="col-md-3 control-label" for="user_email">父目录</label>
						<div class="col-md-5">
						<select name="pid" id="pid" class="form-control">
						<option selected="selected" value="0">根目录</option>
						<?php foreach($cates as $v){?>
						<option value="<?php echo $v['node_id']?>"><?php echo $v['cname']?></option>
						<?php } ?>
						</select>
						</div></div>
						<div class="form-group">
						<label class="col-md-3 control-label" for="keywords">分类关键字</label>
						<div class="col-md-5">
						<input class="form-control" id="keywords" name="keywords" size="50" type="text" value="" /></div></div>
						<div class="form-group">
						<label class="col-md-3 control-label" for="content">分类简介</label>
						<div class="col-md-5">
						<textarea class="form-control" cols="40" id="content" name="content" rows="5"></textarea></div></div>
						<div class="form-group">
						<label class="col-md-3 control-label" for="master">节点版主</label>
						<div class="col-md-5">
						<input class="form-control" id="master" name="master" size="50" type="text" value="" />
						<small class='help-inline'>多个版主间用逗号隔开(,)</small>
						</div></div>
						<div class="form-group">
						<label class="col-md-3 control-label" for="permit">节点权限</label>
						<div class="col-md-5">
						<?php foreach($group_list as $k=>$v){ ?>
						<label class="checkbox inline">
						<input name="permit_<?php echo $k;?>" value="<?php echo $v['gid']?>" type="checkbox"><?php echo $v['group_name']?>
						</label>
						<?php } ?>
						<label class="checkbox">
						(<input id="checkall" type="checkbox">全选/取消
						<small class='help-inline'>不选时为不限制</small>)
						</label>

						</div></div>

						<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
						  <button type="submit" name="commit" class="btn btn-primary">添加节点</button>
						</div>
						</div>

						</form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ('common/footer');?>
<script type="text/javascript">
$(document).ready(function(){
  $("#checkall").bind('click',function(){
  $("input:checkbox").prop("checked",$(this).prop("checked"));//全选
  });
});
</script>
</body></html>
