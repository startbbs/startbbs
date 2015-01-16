<div id="navbar-wrapper">
<div  id="navigation" class="navbar <?php if($this->config->item('static')=='default'){?>navbar-inverse<?php } else{?>navbar-default<?php }?> navbar-fixed-top">
<div class="container">

	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
		<a class="navbar-brand" href="<?php echo site_url()?>"><?php echo $settings['logo'];?></a>
<!--<a class=".btn .btn-default navbar-btn collapsed" data-target=".navbar-collapse" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><a href="<?php echo site_url()?>" class="brand">Start<span class="green">BBS</span></a>-->
	</div>

        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li<?php if(@$action=='home'){?> class="active"<?php }?>><a href="<?php echo site_url()?>"><?php echo lang('front_home');?></a></li>
            <li<?php if(@$action=='node'){?> class="active"<?php }?>><a href="<?php echo site_url('node')?>">节点</a></li>
            <li<?php if(@$action=='user'){?> class="active"<?php }?>><a href="<?php echo site_url('user')?>">会员</a></li>
            <li<?php if(@$action=='tag'){?> class="active"<?php }?>><a href="<?php echo site_url('tag')?>">标签</a></li>
            <li<?php if(@$action=='add'){?> class="active"<?php }?>><a href="<?php echo site_url('topic/add')?>">发表</a></li>
           </ul>

        <?php echo form_open('search',array('class'=>'navbar-form navbar-left','target'=>'_blank','role'=>'search'))?>
		      <div class="form-group">
		        <input type="text" class="form-control" name="keyword" placeholder="输入关键字回车">
		      </div>
		</form>
          <ul class="nav navbar-nav navbar-right">
 
	        <?php if($this->session->userdata('uid')){ ?>
	        <li><!--<a href="<?php echo site_url('message/')?>"><span class="badge">22</span></a>--></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('username');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('user/profile/'.$this->session->userdata('uid').'')?>">个人主页</a></li>
                <li><a href="<?php echo site_url('message')?>">站内信</a></li>
                <li><a href="<?php echo site_url('settings')?>">设置</a></li>
                <?php if($this->auth->is_admin()){ ?>
                <li><a href="<?php echo site_url('admin/login')?>">管理后台</a></li>
                <?php }?>
                <li class="divider"></li>
                <!--<li class="dropdown-header">Nav header</li>-->
                <li><a href="<?php echo site_url('user/logout')?>">退出</a></li>
              </ul>
            </li>
			<?php }else{?>
            <li><a href="<?php echo site_url('user/register')?>">注册</a></li>
            <li><a href="<?php echo site_url('user/login')?>">登入</a></li>
            <?php }?>
          </ul>
        </div><!--/.nav-collapse -->
        
</div>
</div>

</div>