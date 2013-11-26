<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>运行状态 - 管理后台 - Startbbs开源轻量社区系统</title>
<?php $this->load->view ( 'header-meta' ); ?>
</head>
<body id="startbbs">
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">
<div class="navbar-header">
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#">Startbbs</a>
</div>
<div class="collapse navbar-collapse">
  <ul class="nav navbar-nav">
    <li class="active"><a href="#">Home</a></li>
    <li><a href="http://www.startbbs.com">STB官方</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
</div><!--/.nav-collapse -->
</div>
</div>


<div id="wrap">
<div class="container" id="page-main">
<div class="row">
<div class='span2'>
<div class='box fix_cell'>
<div class='cell'>
<strong class='gray'>安装步骤</strong>
</div>
<div class='cell'>
权限检测
</div>
<div class='cell'>
数据库配置
</div>
<div class='cell'>
管理员配置
</div>
<div class='cell'>
安装完成
</div>
</div>

</div>

<div class='col-xs-12 col-sm-6 col-md-8'>

<div class='row'>
<div class='box span8'>
<div class='cell'>
欢迎使用起点startbbs轻量社区系统
</div>
<div class='inner'>
<span class="green">www.startbbs.com</span>

</div>
</div>
</div>

<div class='row'>
<div class='box span8'>
<div class='cell'>
安装最后一步
</div>
<div class='inner'>
<p class="green"><?=$msg1?></p>
<p class="green"><?=$msg2?></p>
<p class="green"><?=$msg3?></p>
<p class="green"><?=$msg4?></p>
<p class="red"><?=$msg5?></p>
<div class='form-actions'>
<a href="<?php echo site_url('/');?>" id="dataTest" class="left btn btn-white btn-primary"><span>进入首页</span></a>
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
<div class="fr"> <!--<a href="" target="_blank"><img src="" border="0" alt="Linode" width="120"></a>--></div>
<p>&copy; 2013 Startbbs Inc, Some rights reserved.</p>
</div>
<small class='text-muted'>
Powered by
<a href="http://www.startbbs.com" class="text-muted" target="_blank">StartBBS</a>
1.0.0.alpha
</small>
</div>
</div>
</body></html>