<!DOCTYPE html>
<html>
<head>
<meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>升级 - 管理后台 - Startbbs开源轻量社区系统</title>
<?php $this->load->view('common/header-meta' );?>
</head>
<body id="startbbs">
<div class="navbar navbar-inverse navbar-static-top navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a class="btn btn-navbar collapsed" data-target=".nav-collapse" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a><a href="/" class="brand">StartBBS</a>
<div class="nav-collapse collapse">
<form class="navbar-search pull-left">
<input class="search-query" data-domain="startbbs.com" id="q" maxlength="40" name="q" placeholder="搜索话题" type="text" />
</form>
<ul class="nav pull-right">
<li class=""><a href="http://www.startbbs.com">Startbbs官方</a></li>
</ul>
</div></div></div></div>


<div id="wrap">
<div class="container" id="page-main">
<div class="row">


<div class='col-xs-12 col-sm-12 col-md-12'>

<div class='row'>
<div class='box col-md-12'>
<div class='cell'>
欢迎进入startbbs社区升级系统
</div>
<div class='inner'>
<span>最新版本：<?php echo $new_version;?></span>
<dl>
<dt><?php echo $msg;?></dt>
<dd></dd>
</dl>
</div>
</div>
</div>
<div class='row'>
<div class='box col-md-12'>
<div class='cell'>
<?php echo $version_msg;?>
</div>
<div class='inner'>
<div class='form-group'>
    <dl class="dl-horizontal">
<?php if(@$msg_1){?>
<dt>升级记录：</dt>
<dd class="green"><?php echo $msg_1;?></dd>
<?php }?>
<?php if(@$msg_2){?>
<dt></dt>
<dd class="green"><?php echo $msg_2;?></dd>
<?php }?>
<?php if(@$msg_error){?>
<dt></dt>
<dd class="green"><?php echo $msg_error;?></dd>
<?php }?>
<?php if(@$msg_done){?>
<dt></dt>
<dd class="green"><?php echo $msg_done;?></dd>
<?php }?>
    </dl>
</div>
<div class='form-actions'>
<?php if(!@$post){?>
<form method="post" action="<?php echo site_url('upgrade/index/');?>">
<input type="submit" name="do_upgrade" value="开始升级" class="left btn btn-white btn-primary"/>
</form>
<?php } else{?>
<!--<input id="btnSubmit" class="btn btn-white btn-primary" name="commit" type="submit" value="下一步" />-->
<a href="<?php echo site_url();?>" id="home" class="left btn btn-white btn-primary"><span>进入首页</span></a>
<?php }?>
</div>


</div>
</div>
</div>

</div>
</div></div></div>
<div id='footer'>
<div class='container' id='footer-main'>
<ul class='page-links'>
<!--<li><a href="/page/about" class="dark nav">StartBBS 简介</a></li>
<li class='snow'>·</li>
<li><a href="/page/support" class="dark nav">技术支持</a></li>-->
</ul>
<div class='copywrite'>
<div class="pull-right"> <!--<a href="" target="_blank"><img src="" border="0" alt="Linode" width="120"></a>--></div>
<p>&copy; 2013 Startbbs Inc, Some rights reserved.</p>
</div>
<small class='text-muted'>
Powered by
<a href="<?php echo $this->config->item('sys_url');?>" class="text-muted" target="_blank"><?php echo $this->config->item('sys_name');?></a>
<?php echo $this->config->item('sys_version');?>
</small>
</div>
</div>
</body></html>