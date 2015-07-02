<!DOCTYPE html><html><head><meta content='登入' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>登入 - <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('common/header');?>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">请登录</h3>
                    </div>
                    <div class="panel-body">
					<form accept-charset="UTF-8" action="<?php echo site_url('user/login');?>" class="form-horizontal" id="new_user" method="post" novalidate="novalidate">
					<input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>">
					<div class="form-group">
						<label class="col-md-2 control-label" for="user_nickname">用户名</label>
						<div class="col-md-6">
						<input class="form-control" id="user_nickname" name="username" size="50" type="text" value="<?php echo set_value('username'); ?>"/><span class="help-block red"><?php echo form_error('username');?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="user_password">密码</label>
						<div class="col-md-6">
						<input class="form-control" id="user_password" name="password" size="50" type="password" value="<?php echo set_value('password'); ?>"/>
						<span class="help-block red"><?php echo form_error('password');?></span>
						</div>
					</div>
					<?php if($this->config->item('show_captcha')=='on'){?>
					<div class="form-group">
						<label class="col-md-2 control-label" for="captcha_code">验证码</label>
						<div class="col-md-4">
						<input class="form-control" id="captcha_code" name="captcha_code" size="50" type="text"  value="<?php echo set_value('captcha_code'); ?>"/>
						<span class="help-block red"><?php echo form_error('captcha_code');?></span>
						</div>
						<div class="col-md-3">
						<a href="javascript:reloadcode();" title="更换验证码"><img src="<?php echo site_url('captcha_code');?>" name="checkCodeImg" id="checkCodeImg" border="0" /></a>&nbsp;&nbsp;<a href="javascript:reloadcode();">换一张</a>
						</div>
					</div>
					<script language="javascript">
					//刷新图片
					function reloadcode() {//刷新验证码函数
					 var verify = document.getElementById('checkCodeImg');
					 verify.setAttribute('src', '<?php echo site_url('captcha_code?');?>' + Math.random());
					}
					</script>
					<?php }?>
					<div class='form-group'>
						<div class="col-md-offset-2 col-md-9">
							<button type="submit" name="commit" class="btn btn-primary">登入</button>
							<a href="<?php echo site_url('user/findpwd');?>" class="btn btn-default" role="button">找回密码</a>
						</div>
					</div>

					</form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

			<div class="col-md-4">
			<?php $this->load->view('common/sidebar_login');?>
			<?php $this->load->view('common/sidebar_ad');?>
			</div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer');?>
</body>
</html>