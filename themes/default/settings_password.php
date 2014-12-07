<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title;?>- <?php echo $settings['site_name'];?></title>
<?php echo $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<?php echo $this->load->view('common/header');?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">
                        <h4>账号设置</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            <li><a href="<?php echo site_url('settings/profile');?>">基本信息</a></li>
                            <li><a href="<?php echo site_url('settings/avatar');?>">修改头像</a></li>
                            <li class="active"><a href="#">密码安全</a></li>
                        </ul>
                        <div class="setting">
	                        <?php if (@$msg!='') echo '<div class="alert alert-danger">'.$msg.'</div>'; ?>
							<form accept-charset="UTF-8" action="<?php echo site_url('settings/password');?>" class="simple_form form-horizontal" method="post">
								<input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>">
								<div class="form-group">
									<label class="col-md-2 control-label" for="user_current_password">当前密码</label>
									<div class="col-md-6">
									<input class="form-control" id="user_current_password" name="password" value="<?php echo set_value('password'); ?>" size="50" type="password" />
									<span class="help-block red"><?php echo form_error('password');?></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="user_password">新密码</label>
									<div class="col-md-6">
									<input class="form-control" id="user_password" name="newpassword" value="<?php echo set_value('newpassword'); ?>" size="50" type="password" />
									<span class="help-block red"><?php echo form_error('newpassword');?></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="user_password_confirmation">密码确认</label>
									<div class="col-md-6">
									<input class="form-control" id="user_password_confirmation" name="newpassword2" value="<?php echo set_value('newpassword2'); ?>" size="50" type="password" />
									<span class="help-block red"><?php echo form_error('newpassword2');?></span>
									</div>
								</div>

								<div class='form-group'>
									<div class="col-sm-offset-3 col-sm-9">
										<button type="submit" name="commit" class="btn btn-primary">修改密码</button>
									</div>
								</div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
			<div class="col-md-4">
			<?php $this->load->view('common/sidebar_login')?>
			<?php $this->load->view('common/sidebar_ad');?>
			</div> 
        </div>
    </div>

<?php $this->load->view('common/footer');?>
</body>
</html>