<!DOCTYPE html>
<html>
<head>
<meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title;?> - <?php echo $settings['site_name'];?></title>
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
                            <li class="active"><a href="#">修改头像</a></li>
                            <li><a href="<?php echo site_url('settings/password');?>">密码安全</a></li>
                        </ul>
                        <div class="setting">
	                        <?php if ($msg!='') echo '<div class="alert alert-danger">'.$msg.'</div>'; ?>
							<form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url('settings/avatar_upload')?>" method="post">
								<input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>">
				  			<fieldset>
				    			<div class="form-group">
				      				<label class="col-md-2 control-label">当前头像</label>
				      				<div class="col-md-8">
				      					<?php if ($myinfo['avatar']){?>
											<img class="large_avatar" src="<?php echo base_url($avatar.'big.png');?>" class="img-rounded">
				                            <img class="middle_avatar" src="<?php echo base_url($avatar.'normal.png');?>" class="img-rounded">
				                            <img class="small_avatar" src="<?php echo base_url($avatar.'small.png');?>" class="img-rounded">
				      					<?php } else {?>
											<img class="large_avatar" src="<?php echo base_url('uploads/avatar/avatar_large.jpg');?>"/>
				      						<img class="middle_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>"/>
				      						<img class="small_avatar" src="<?php echo base_url('uploads/avatar/avatar_small.jpg');?>"/>
				      					<?php }?>
	                                    <div class="alert alert-info alert-avatar">
	                                        <strong>注意</strong> 支持 512k 以内的 PNG / GIF / JPG 图片文件作为头像，推荐使用正方形的图片以获得最佳效果。
	                                    </div>
				      				</div>
				    			</div>
				    			
				    			<div class="form-group">
				      				<label class="col-md-2 control-label" for="avatar_file">选择图片</label>
				      				<div class="col-md-6">
				       					<input type="file" id="avatar_file" name="avatar_file" />
				      				</div>
				    			</div>
				    			
				    			<div class="form-group">
					    			<div class="col-sm-offset-2 col-sm-6">
				    				<button type="submit" name="upload" class="btn btn-primary">上传新头像</button>
				    				</div>
				    			</div>
				    		</fieldset>
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