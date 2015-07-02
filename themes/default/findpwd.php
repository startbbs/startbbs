<!DOCTYPE html>
<html>
	<head>
<meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<a id="top" name="top"></a>
<?php $this->load->view('common/header'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $title?></h3>
                    </div>
                    <div class="panel-body">
					<?php if(isset($_GET['p'])){?>
					<form accept-charset="UTF-8" action="<?php echo site_url('user/resetpwd?p='.$p);?>" class="form-horizontal" id="new_user" method="post">
					<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
					<div class="form-group">
						<label class="col-md-3 control-label" for="user_password">新密码</label>
						<div class="col-md-5">
						<input class="form-control" id="user_password" name="password" value="<?php echo set_value('password'); ?>" type="password" />
						<span class="help-block red"><?php echo form_error('password');?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="user_password_confirmation">再输入一次</label>
						<div class="col-md-5">
						<input class="form-control" id="user_password_confirmation" name="password_c" value="<?php echo set_value('password_c'); ?>" type="password" />
						<span class="help-block red"><?php echo form_error('password_c');?></span>
						</div>
					</div>
					  <div class="form-group">
					    <div class="col-md-offset-3 col-md-9">
					      <button type="submit" name="commit" class="btn btn-primary" name="commit">继续</button>
					    </div>
					</div>
					</form>
					<?php } else {?>
					<form accept-charset="UTF-8" action="<?php echo site_url('user/findpwd');?>" class="simple_form form-horizontal" id="new_user" method="post" novalidate="novalidate">
					<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
					<div class="form-group">
						<label class="col-md-3 control-label" for="user_nickname">用户名</label>
						<div class="col-md-5">
						<input class="form-control" id="user_nickname" name="username" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="user_email">注册邮箱</label>
						<div class="col-md-5">
						<input class="form-control" id="user_email" name="email" type="email" value="" />
						</div>
					</div>
					  <div class="form-group">
					    <div class="col-md-offset-3 col-md-9">
					      <button type="submit" class="btn btn-primary" name="commit">找回密码</button>
					    </div>
					  </div>
					</form>
					<?php }?>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

            <div class="col-md-4">
				<?php $this->load->view('common/sidebar_login');?>
				<?php $this->load->view('common/sidebar_ad');?>
            </div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer'); ?>
</body>
</html>