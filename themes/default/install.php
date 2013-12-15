<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>运行状态 - 管理后台 - Startbbs开源轻量社区系统</title>
<?php $this->load->view ( 'header-meta' ); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				var url = location.href;
				var url = window.location.protocol+"//"+window.location.host;
				$("#dataTest").click(function(){
					var isok = checkDbContent();
					if(isok){
						var dbhost = $("#txtHost").val();
						var dbport = $("#txtPort").val();
						var dbname = $("#txtName").val();
						var dbuser = $("#txtUser").val();
						var dbpwd = $("#txtPassword").val();
						var dbprefix = $("#txtPrefix").val();
						$.ajax({
							url:siteurl+"index.php/install/check",
							data:{
								dbhost:dbhost,
								dbport:dbport,
								dbname:dbname,
								dbuser:dbuser,
								dbpwd:dbpwd,
								dbprefix:dbprefix
							},
							dataType:"json",
							success:function(res){
								if(res["code"]==1){
									$("#testInfo").html(res["msg"]).removeClass("red").addClass("green");
								}else{
									$("#testInfo").html(res["msg"]).removeClass("green").addClass("red");
								}
							}
						})
					}
				})
				
				$("#btnSubmit").click(function(){
					if(checkDbContent() && checkInfo()){
						$("#dbform").submit();
					}
				})
			})
			
			function checkDbContent(){
				var isok = true;
				var dbhost = $("#txtHost").val();
				if(dbhost==""){
					$("#infoHost").html("请填写数据库主机").addClass("red");
					isok = false;
				}else{
					$("#infoHost").html("").removeClass("red");
				}
				var dbport = $("#txtPort").val();
				if(dbport==""){
					$("#infoPort").html("请输入数据库端口号").addClass("red");
					isok = false;
				}else{
					$("#infoPort").html("").removeClass("red");
				}
				var dbname = $("#txtName").val();
				if(dbname==""){
					$("#infoName").html("请输入数据库名").addClass("red");
					isok = false;
				}else{
					$("#infoName").html("").removeClass("red");
				}
				var dbuser = $("#txtUser").val();
				if(dbuser==""){
					$("#infoUser").html("请输入数据库用户名").addClass("red");
					isok = false;
				}else{
					$("#infoUser").html("").removeClass("red");
				}
				//var dbpwd = $("#txtPassword").val();
				//if(dbpwd==""){
				//	$("#infoPassword").html("请输入数据库密码").addClass("red");
				//	isok = false;
				//}else{
				//	$("#infoPassword").html("").removeClass("red");
				//}
				var dbprefix = $("#txtPrefix").val();
				if(dbprefix==""){
					$("#infoPrefix").html("请输入数据库前缀").addClass("red");
					isok = false;
				}else{
					$("#infoPrefix").html("").removeClass("red");
				}
				return isok;
			}

			function checkInfo(){
				var isok = true;
				var admin = $("#txtAdmin").val();
				if(admin==""){
					$("#infoAdmin").html("请输入管理员登陆名").addClass("red");
					isok = false;
				}else{
					$("#infoAdmin").html("").removeClass("red");
				}
				var pwd = $("#txtPwd").val();
				if(pwd==""){
					$("#infoPwd").html("请输入管理员密码").addClass("red");
					isok = false;
				}else{
					$("#infoPwd").html("").removeClass("red");
				}
				var email = $("#txtEmail").val();
				if(email==""){
					$("#infoEmail").html("请输入邮箱地址").addClass("red");
					isok = false;
				}else{
					$("#infoEmail").html("").removeClass("red");
				}
				return isok;
			}
		</script>
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
<div class='col-xs-12 col-sm-6 col-md-4'>
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
<div class='box'>
<div class='cell'>
欢迎使用起点startbbs轻量社区系统
</div>
<div class='inner'>
<span class="green">www.startbbs.com（代安装请联系QQ858292510）</span>

</div>
</div>
</div>
<?php if($step==1){?>
<div class='row'>
<div class='box'>
<div class='cell'>
文件以及目录权限检测(第一步)
</div>
<div class='inner'>
<table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>目录</th>
            <th>权限</th>
          </tr>
        </thead>
<?php $i=0; foreach($permission as $k=>$v){?>
<?php $i++;?>
<tr>
	<td><?php echo $i?></td>
	<td><?php echo $k;?></td>
	<td><?php if($v==1){?>可写<?php }else {?>不可写<?php }?></td>
</tr>
<?php }?>
</table>
<div class='form-actions'>
<a href="<?php echo site_url('install/step/2')?>" class="left btn btn-primary">下一步</a>
</div>
</div>
</div>
</div>
<?php }?>
<?php if($step==2){?>
<form action="<?php echo site_url('install/step/3');?>" method="post" id="dbform" role="form">
<div class='row'>
<div class='box'>
<div class='cell'>
数据库配置(第二步)
</div>
<div class='inner row'>
<div class="col-md-6">
<div class='form-group '>
<label class="control-label" for="settings_site_name">数据库主机</label>
<input id="txtHost" class="form-control" name="dbhost" type="text" value="localhost" />
<small class='help-inline' id="infoHost">一般为localhost</small>
</div>

<div class='form-group'>
<label class="control-label" for="settings_site_name">数据库端口</label>
<input id="txtPort" class="form-control" name="dbport" type="text" value="3306" />
<small class='help-inline' id="infoPort">一般为3306</small>
</div>

<div class='form-group'>
<label class="control-label" for="settings_site_name">数据库用户</label>
<input id="txtUser" class="form-control" name="dbuser" type="text" value="" />
<small class='help-inline' id="infoUser">必填</small>
</div>

<div class='form-group'>
<label class="control-label" for="settings_site_name">数据库密码</label>
<input id="txtPassword" class="form-control" name="dbpwd" type="text" value="" />
<small class='help-inline' id="infoPassword">非必填</small>
</div>

<div class='form-group'>
<span class="pull-right"><input type="checkbox" name="creatdb"> 创建</span>
<label class="control-label" for="settings_site_name">数据库名称</label>
<input id="txtName" class="form-control" name="dbname" type="text" value="startbbs" />
<small class='help-inline' id="infoName"></small>
</div>

<div class='form-group'>
<label class="control-label" for="settings_site_name">数据表前缀</label>
<input id="txtPrefix" class="form-control" name="dbprefix" type="text" value="stb_" />
<small class='help-inline' id="infoPrefix">不建议修改</small>
</div>

<span id="testInfo"></span>
<div class='form-actions'>
<a href="javascript:void(0)" id="dataTest" class="left btn btn-white btn-primary"><span>测试连接</span></a>
<!--<input id="btnSubmit" class="btn btn-white btn-primary" name="commit" type="submit" value="下一步" />-->
</div>

</div>
</div>
</div>
</div>

<div class='row'>
<div class='box'>
<div class='cell'>
管理员信息配置
</div>
<div class='inner row'>
	<div class="col-md-6">
<div class='form-group'>
<label for="settings_site_name">用户名</label>
<input id="txtAdmin" class="form-control" name="admin" type="text" value="admin" />
<small class='help-inline' id="infoAdmin">只能用'0-9'、'a-z'、'A-Z'</small>
</div>
<div class='form-group'>
<label for="settings_site_name">密码</label>
<input id="txtPwd" class="form-control" name="pwd" type="text" value="startbbs" />
<small class='help-inline' id="infoPwd">必填</small>
</div>
<div class='form-group'>
<label for="settings_site_name">管理员邮箱</label>
<input id="txtEmail" class="form-control" name="email" type="text" value="startbbs@126.com" />
<small class='help-inline' id="infoEmail">必填</small>
</div>
<div class='form-group'>
<label for="settings_site_name">安装目录</label>
<input id="txtUrl" class="form-control" name="base_url" type="text" value="" />
<small class='help-inline' id="infoUrl">根目录请留空,如二级目录名 bbs</small>
</div>
<div class='form-actions'>
<!--<input id="btnSubmit" class="btn btn-white btn-primary" name="commit" type="submit" value="下一步" />-->
<a id="btnSubmit" href="javascript:void()" class="left btn btn-white btn-primary"><span>点此安装</span></a>
<span class="green">(务必记住管理员信息)</span>
</div>

	</div>
</div>
</div>
</div>
</form>
<?php }?>


<?php if($step==3){?>
<div class='row'>
<div class='box span8'>
<div class='cell'>
安装最后一步
</div>
<div class='inner'>
<p class="green"><?php echo $msg1?></p>
<p class="green"><?php echo $msg2?></p>
<p class="green"><?php echo $msg3?></p>
<p class="green"><?php echo $msg4?></p>
<p class="red"><?php echo $msg5?></p>
<div class='form-actions'>
<a href="<?php echo site_url('/');?>" id="dataTest" class="left btn btn-white btn-primary"><span>进入首页</span></a>
</div>

</div>
</div>
</div>

<?php }?>
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
<?php echo $this->config->item('version');?>
</small>
</div>
</div>
</body></html>