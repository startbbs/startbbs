<div class="navbar navbar-default navbar-fixed-top">
<div class="container">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?php echo site_url()?>">Start<span class="green">BBS</span></a>
<!--<a class=".btn .btn-default navbar-btn collapsed" data-target=".navbar-collapse" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><a href="<?php echo site_url()?>" class="brand">Start<span class="green">BBS</span></a>-->
	</div>

        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo site_url()?>" target=_blank>前台首页</a></li>

            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>
          <ul class="nav navbar-nav navbar-right">
	        <?php if($this->session->userdata('uid')){ ?>
			<li><a href="<?php echo site_url('user/profile/'.$this->session->userdata('uid').'')?>"><?php echo $this->session->userdata('username');?></a></li>
			<li><a href="<?php echo site_url('settings')?>">个人设置</a></li>
			<?php if($this->auth->is_admin()){ ?>
			<li class=""><a href="<?php echo site_url('admin/login')?>">管理后台</a></li>
			<?php }?>
			<li><a href="<?php echo site_url('admin/login/logout')?>" data-method="delete" rel="nofollow">退出</a></li>
			<?php }else{?>
            <li><a href="<?php echo site_url('user/register')?>">注册</a></li>
            <li><a href="<?php echo site_url('admin/login/do_login')?>">登入</a></li>
            <?php }?>
          </ul>
        </div><!--/.nav-collapse -->
        
</div>
</div>