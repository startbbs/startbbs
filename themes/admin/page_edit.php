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
				  <li><a href="<?php echo site_url('admin/page')?>">单页面列表</a></li>
				  <li class="active">编辑单页面</li>
				</ol>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">修改页面<small class='pull-right'><a href="<?php echo site_url('admin/page');?>">返回页面列表</a></small></h3>
                    </div>
                    <div class="panel-body">
					<form accept-charset="UTF-8" action="<?php echo site_url('admin/page/edit/'.$page['pid']);?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
						<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
						<div class="form-group">
							<label class="col-md-3 control-label" for="title">标题</label>
							<div class="col-md-5">
								<input class="form-control" id="title" name="title" size="50" type="text" value="<?php echo $page['title'];?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="content">内容</label>
							<div class="col-md-5">
								<textarea class="form-control" id="content" name="content" rows="10">
									<?php echo $page[ 'content'];?>
								</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="go_url">转向url</label>
							<div class="col-md-5">
								<input class="form-control" id="go_url" name="go_url" size="60" type="text" value="<?php echo $page['go_url'];?>" />
					<small class='help-block'>没有外链，请留空</small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="user_account_attributes_location">是否显示在底菜单</label>
							<div class="col-md-5">
								<label class='radio-inline'>
								<input<?php if($page['is_hidden']=='0'){?> checked="checked"<?php }?> id="settings_show_community_stats_on" name="is_hidden" type="radio" value="0" /> 显示</label>
								<label class='radio-inline'>
								<input<?php if($page['is_hidden']=='1'){?> checked="checked"<?php }?> id="settings_show_community_stats_off" name="is_hidden" type="radio" value="1" /> 隐藏</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" name="commit" class="btn btn-primary">编辑页面</button>
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
