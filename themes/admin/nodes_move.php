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
				  <li class="active">移动结点</li>
				</ol>
                <div class="panel panel-default">
	                <div class="panel-heading">
		            移动节点<span class="small pull-right"><a href="<?php echo site_url('admin/nodes');?>">返回分类列表</a></span>
		            </div>
                    <div class="panel-body">
						<form accept-charset="UTF-8" action="<?php echo site_url('admin/nodes/move/'.$node_id);?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
						<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>" id="token">
						<div class="form-group">
						<label class="col-md-3 control-label" for="user_email">移动到</label>
						<div class="col-md-5">
						<select name="pid" id="pid" class="form-control">
						<option selected="selected" value="0">根目录</option>
						<?php foreach($cates as $v){?>
						<option value="<?php echo $v['node_id']?>"><?php echo $v['cname']?></option>
						<?php } ?>
						</select>
						</div></div>

						<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
						  <button type="submit" name="commit" class="btn btn-primary">开始移动</button>
						</div>
						</div>
						</form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ('footer');?>
</body></html>
