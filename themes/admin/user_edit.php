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
				  <li><a href="<?php echo site_url('admin/users')?>">用户列表</a></li>
				  <li class="active">编辑用户</li>
				</ol>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">编辑用户</h3>
                    </div>
                    <div class="panel-body">
					<form accept-charset="UTF-8" action="<?php echo site_url('admin/users/edit/'.$user['uid']);?>" class="form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
						<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
						<div class="form-group">
							<label class="col-md-3 control-label" for="user_nickname">用户名</label>
							<div class="col-md-5">
								<input class="form-control" id="user_nickname" name="username" size="50" type="text" value="<?php echo $user['username']?>" />
							</div>
						</div>
						<div class="form-group email optional">
							<label class="col-md-3 control-label" for="user_email">电子邮件</label>
							<div class="col-md-5">
								<input class="form-control" id="user_email" name="email" size="50" type="email" value="<?php echo $user['email']?>" />
							</div>
						</div>
						<div class="form-group password optional">
							<label class="col-md-3 control-label" for="user_password">新密码</label>
							<div class="col-md-5">
								<input class="form-control" id="user_password" name="password" size="50" type="password" />
							</div>
						</div>
						<div class="form-group password optional">
							<label class="col-md-3 control-label" for="user_password_confirmation">确认新密码</label>
							<div class="col-md-5">
								<input class="form-control" id="user_password_confirmation" name="user[password_confirmation]" size="50" type="password" />
							</div>
						</div>
						<div class="form-group string optional">
							<label class="col-md-3 control-label" for="user_account_attributes_personal_website">个人网站</label>
							<div class="col-md-5">
								<input class="form-control" id="user_account_attributes_personal_website" name="homepage" size="50" type="text" value="<?php echo $user['homepage']?>" />
							</div>
						</div>
						<div class="form-group string optional">
							<label class="col-md-3 control-label" for="user_account_attributes_location">所在地</label>
							<div class="col-md-5">
								<input class="form-control" id="user_account_attributes_location" name="location" size="50" type="text" value="<?php echo $user['location']?>" />
							</div>
						</div>
						<div class="form-group string optional">
							<label class="col-md-3 control-label" for="user_account_attributes_weibo_link">QQ</label>
							<div class="col-md-5">
								<input class="form-control" id="user_account_attributes_weibo_link" name="qq" size="50" type="text" value="<?php echo $user['qq']?>" />
							</div>
						</div>
						<div class="form-group string optional">
							<label class="col-md-3 control-label" for="user_account_attributes_signature">签名</label>
							<div class="col-md-5">
								<input class="form-control" id="user_account_attributes_signature" name="signature" size="50" type="text" value="<?php echo $user['signature']?>" />
							</div>
						</div>
						<div class="form-group text optional">
							<label class="col-md-3 control-label" for="user_account_attributes_introduction">个人简介</label>
							<div class="col-md-5">
								<textarea class="form-control" cols="40" id="user_account_attributes_introduction" name="introduction" rows="5">
									<?php echo $user[ 'introduction']?>
								</textarea>
							</div>
						</div>
						<input id="user_account_attributes_id" name="uid" type="hidden" value="<?php echo $user['uid']?>" />
						<div class="form-group integer optional">
							<label class="col-md-3 control-label" for="user_reward">积分</label>
							<div class="col-md-5">
								<input class="form-control" id="user_reward" name="credit" step="1" type="number" value="<?php echo $user['credit']?>" />
							</div>
						</div>
						<div class="form-group integer optional">
							<label class="col-md-3 control-label" for="user_group">用户组</label>
							<div class="col-md-5">
								<select name="gid" id="gid" class="form-control">
									<?php if(set_value( 'gid')){?>
									<option selected="selected" value="<?php echo set_value('gid'); ?>">
										<?php echo $group[ 'group_name']?>(已选)</option>
									<?php } else {?>
									<option selected="selected" value="<?php echo $user['gid'];?>">
										<?php echo $group[ 'group_name']?>(已选)</option>
									<?php } ?>
									<?php if($groups) foreach($groups as $v) {?>
									<option value="<?php echo $v['gid']?>">
										<?php echo $v[ 'group_name']?>
									</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" name="commit" class="btn btn-primary">更新用户信息</button>
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
