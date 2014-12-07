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
					<form accept-charset="UTF-8" action="<?php echo site_url('user/resetpwd?p='.$p);?>" class="new_user" id="new_user" method="post">
					<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
					<table class='form'>
					<tr>
					<td class='left'>
					<label for="user_password">新密码</label>
					</td>
					<td class='right'>
					<input class="sl" id="user_password" name="password" size="30" type="password" />
					</td>
					</tr>
					<tr>
					<td class='left'>
					<label for="user_password_confirmation">请再输入一次</label>
					</td>
					<td class='right'>
					<input class="sl" id="user_password_confirmation" name="password_c" size="30" type="password" />
					</td>
					</tr>
					<tr>
					<td class='left'></td>
					<td class='right'>
					<input class="btn btn-sm" name="commit" type="submit" value="继续" />
					</td>
					</tr>
					</table>
					</form>
					<?php } else {?>
					<form accept-charset="UTF-8" action="<?php echo site_url('user/findpwd');?>" class="simple_form form-horizontal" id="new_user" method="post" novalidate="novalidate">
					<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="user_nickname">用户名</label>
						<div class="col-sm-6">
						<input class="form-control" id="user_nickname" name="username" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="user_email">注册邮箱</label>
						<div class="col-sm-6">
						<input class="form-control" id="user_email" name="email" type="email" value="" />
						</div>
					</div>
					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
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