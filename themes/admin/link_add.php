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
				  <li><a href="<?php echo site_url('admin/links')?>">链接列表</a></li>
				  <li class="active">添加链接</li>
				</ol>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">添加链接</h3>
                    </div>
                    <div class="panel-body">
						<form accept-charset="UTF-8" action="<?php echo site_url('admin/links/add');?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
							<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
							<div class="form-group">
								<label class="col-md-3 control-label" for="name">网站名</label>
								<div class="col-md-5">
									<input class="form-control" id="name" name="name" size="50" type="text" value="" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="url">网址</label>
								<div class="col-md-5">
									<input class="form-control" id="url" name="url" size="50" type="email" value="" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="user_account_attributes_location">显示/隐藏</label>
								<div class="col-md-5">
									<label class='radio-inline'>
										<input checked="checked" id="settings_show_community_stats_on" name="is_hidden" type="radio" value="0" />显示</label>
									<label class='radio-inline'>
										<input id="settings_show_community_stats_off" name="is_hidden" type="radio" value="1" />隐藏</label>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" name="commit" class="btn btn-primary">添加链接</button>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ('common/footer');?>
</body></html>
