<div class="navbar<?php if($this->config->item('static')=='default'){?> navbar-inverse<?php }?> navbar-static-top navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a class="btn btn-navbar collapsed" data-target=".nav-collapse" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><a href="<?php echo site_url()?>" class="brand">Start<span class="green">BBS</span></a>
<div class="nav-collapse collapse">
<ul class="nav pull-left">
<li class=""><a href="<?php echo site_url()?>">首页</a></li>
<li class=""><a href="<?php echo site_url('section')?>">节点</a></li>
<li class=""><a href="<?php echo site_url('user')?>">会员</a></li>
<li class=""><a href="<?php echo site_url('forum/add')?>">发表</a></li>
</ul>

<!--<form class="navbar-search pull-left" action="/home/search" method="get">
<input class="search-query" data-domain="" id="q" maxlength="40" name="q" placeholder="输入关键字并回车" type="text" />
</form>-->
<form class="navbar-search pull-left" action="http://www.google.com/search" method="get" target="_blank">
<input class="search-query" data-domain="" id="q" maxlength="40" name="q" placeholder="输入关键字并回车" type="text" />
<input type=hidden name=ie value=UTF-8>
<input type=hidden name=oe value=UTF-8>
<input type=hidden name=hl value=zh-CN>
<input type=hidden name=domains value="<?php echo base_url()?>">
<input type=hidden name=sitesearch value="<?php echo base_url()?>">
</form>

<ul class="nav pull-right">
<?php if($this->session->userdata('uid')){ ?>
<li class=""><a href="<?php echo site_url('user/info/'.$this->session->userdata('uid').'')?>"><?php echo $this->session->userdata('username');?></a></li>
<li class=""><a href="<?php echo site_url('settings')?>"><i class="icon-th-list icon-white"></i> 个人设置</a></li>
<?php if($this->auth->is_admin()){ ?>
<li class=""><a href="<?php echo site_url('admin/login')?>"><i class="icon-th-list icon-white"></i> 管理后台</a></li>
<?php }?>
<li><a href="<?php echo site_url('user/logout')?>" data-method="delete" rel="nofollow">退出</a></li>
<?php }else{?>
<li class=""><a href="<?php echo site_url('user/reg')?>"><i class="icon-user icon-white"></i>注册</a></li>
<li class=""><a href="<?php echo site_url('user/login')?>"><i class="icon-user icon-white"></i>登入</a></li>
<li class=""><a href="<?php echo site_url("qq_login")?>" target="_self"><img src="<?php echo base_url("static/common/images/qq_login.png");?>" /></a></li>
<?php }?>
</ul>
</div></div></div></div>

