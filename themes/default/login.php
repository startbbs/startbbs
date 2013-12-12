<!DOCTYPE html><html><head><meta content='登入' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>登入 - <?php echo $settings['site_name']?></title>
<?php $this->load->view('header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('header');?>

<div id="wrap"><div class="container" id="page-main"><div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>


<div class='box'>
<div class='cell'><a href="<?php echo site_url()?>" class="startbbs"><?php echo $settings['site_name']?></a> <span class="chevron">&nbsp;›&nbsp;</span> 登入</div>
<div class='inner'>
<form accept-charset="UTF-8" action="<?php echo site_url('user/login?referer='.$referer);?>" class="form-horizontal" id="new_user" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="authenticity_token" type="hidden" value="lr/g+0G/gLUzIhYpJwhtULW5aftcf8soZOHMznkxxT0=" />
</div>

<div class="form-group">
<label class="col-sm-3 control-label" for="user_nickname">用户名</label>
<div class="col-sm-5">
<input autofocus="autofocus" class="form-control" id="user_nickname" name="username" size="50" type="text" />
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_password">密码</label>
<div class="col-sm-5">
<input class="form-control" id="user_password" name="password" size="50" type="password" />
</div></div>
<?php if($this->config->item('show_captcha')=='on'){?>
<div class="form-group">
<label class="col-sm-3 control-label" for="captcha_code">验证码</label>
<div class="col-sm-4">
<input class="form-control" id="captcha_code" name="captcha_code" size="50" type="text" value="" />
</div>
<div class="col-sm-3">
<a href="javascript:reloadcode();" title="更换一张验证码图片"><img src="<?php echo site_url('captcha_code');?>" name="checkCodeImg" id="checkCodeImg" border="0" /></a> <a href="javascript:reloadcode();">换一张</a>
</div>
</div>
<script language="javascript">
 var verify = document.getElementById('checkCodeImg');
 verify.setAttribute('src', '<?php echo site_url('captcha_code?');?>' + Math.random());
//刷新图片
function reloadcode() {//刷新验证码函数
 var verify = document.getElementById('checkCodeImg');
 verify.setAttribute('src', '<?php echo site_url('captcha_code?');?>' + Math.random());
}
</script>
<?php }?>
<div class='hide'>
<input name="user[remember_me]" type="hidden" value="0" />
<input checked="checked" id="user_remember_me" name="user[remember_me]" type="checkbox" value="1" /></div>
<div class='form-group'>
	<div class="col-sm-offset-3 col-sm-9">
		<button type="submit" name="commit" class="btn btn-primary">登入</button>
		<a href="<?php echo site_url('user/findpwd');?>" class="btn btn-default" role="button">找回密码</a>
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
<?php $this->load->view ('footer'); ?>