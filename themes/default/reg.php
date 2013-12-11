<!DOCTYPE html>
<html>
	<head>
		<meta content='注册' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?>- <?php echo $settings['site_name']?></title>
<?php $this->load->view('header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('header');?>

<div id="wrap"><div class="container" id="page-main"><div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box'>
<div class='cell'>
<a href="<?php echo site_url()?>" class="startbbs"><?php echo $settings['site_name']?></a> <span class="chevron">&nbsp;›&nbsp;</span> 注册
</div>
<div class='inner'>
<form accept-charset="UTF-8" action="<?php echo site_url('user/reg');?>" class="form-horizontal" id="new_user" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="authenticity_token" type="hidden" value="zHmHYEJbz9hP+SpTe153DJH8BobrJSJ63cDjsuZayGs=" /></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_nickname">用户名</label>
<div class="col-sm-5">
<input autofocus="autofocus" class="form-control" id="user_nickname" name="username" size="50" type="text" value="<?php echo set_value('username'); ?>" /><span class="help-inline red"><?php echo form_error('username');?></span>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_email">电子邮件</label>
<div class="col-sm-5">
<input class="form-control" id="user_email" name="email" size="50" type="email" value="<?php echo set_value('email'); ?>" />
<span class="help-inline red"><?php echo form_error('email');?></span>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_password">密码</label>
<div class="col-sm-5">
<input class="form-control" id="user_password" name="password" size="50" type="password" value="<?php echo set_value('password'); ?>" />
<span class="help-inline red"><?php echo form_error('password');?></span>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_password_confirmation">密码确认</label>
<div class="col-sm-5">
<input class="form-control" id="user_password_confirmation" name="password_c" size="50" type="password" value="<?php echo set_value('password_c'); ?>" /><span class="help-inline red"><?php echo form_error('password_c');?></span>
</div></div>
<?php if($this->config->item('show_captcha')=='on'){?>
<div class="form-group">
<label class="col-sm-3 control-label" for="captcha_code">验证码</label>
<div class="col-sm-3">
<input class="form-control" id="captcha_code" name="captcha_code" size="50" type="text" value="<?php echo set_value('captcha_code'); ?>" />
</div>
<div class="col-sm-3">
<span class="help-inline red"> <a href="javascript:reloadcode();" title="更换一张验证码图片"><img src="<?php echo site_url('captcha_code');?>" name="checkCodeImg" id="checkCodeImg" border="0" /></a> <a href="javascript:reloadcode();">换一张</a><?php echo form_error('captcha_code');?></span>
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
	<div class="col-sm-offset-3 col-sm-9">
		<button type="submit" name="commit" class="btn btn-primary">注册</button>
	</div>
</div>
</form>

</div>
</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('block/right_login');?>
<?php $this->load->view('block/right_ad');?>

</div>
</div></div></div>
<?php $this->load->view('footer');?>