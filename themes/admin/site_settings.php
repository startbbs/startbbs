<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>基本设置 - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ( 'header-meta' ); ?>
<script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tab.js"></script>
<script type="text/javascript">
            $(function () {
                var log = function(s){
                    window.console && console.log(s)
                }
                $('.nav-tabs a:first').tab('show')
                $('a[data-toggle="tab"]').on('show', function (e) {
                    log(e)
                })
                $('a[data-toggle="tab"]').on('shown', function (e) {
                    log(e.target) // activated tab
                    log(e.relatedTarget) // previous tab
                })
            })

</script>

</head>
<body id="starbbs">
<?php $this->load->view ( 'header' ); ?>

<div id="wrap"><div class="container" id="page-main">
<div class="row">
<?php $this->load->view ( 'leftbar' ); ?>

<div class='col-xs-12 col-sm-6 col-md-9'>

<div class='box'>
<div class='cell'>
<a href="<?php echo site_url()?>" class="startbbs1">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/login');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> 基本设置
</div>
<div class="sep10"></div>
<div class="tabbable"> <!-- Only required for left/right tabs -->
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">网站设定</a></li>
<li><a href="#tab2" data-toggle="tab">话题设定</a></li>
<li><a href="#tab3" data-toggle="tab">登录接口</a></li>
<li><a href="#tab4" data-toggle="tab">邮件配置</a></li>
<li><a href="#tab5" data-toggle="tab">自定义url</a></li>
<li><a href="#tab6" data-toggle="tab">存储设定</a></li>
<!--<li><a href="#tab5" data-toggle="tab">备用</a></li>-->
</ul>
<div class="tab-content">
<div class="tab-pane active" id="tab1">
<div class='inner'>
<form accept-charset="UTF-8" action="<?php echo site_url('admin/site_settings?a=basic');?>" class="form-horizontal" method="post">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="_method" type="hidden" value="put" />
<input name="authenticity_token" type="hidden" value="YNAXPQDviOJ/cf5OH/KrqdxOjGLCdka+kUCp+fa3J+A=" />
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_site_name">网站名称</label>
<div class='col-sm-5'>
<input id="settings_site_name" class="form-control" name="site_name" type="text" value="<?php echo $item['0']['value'];?>" />

</div>
<small class='help-inline'>必填</small>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_welcome_tip">欢迎信息</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_welcome_tip" name="welcome_tip" type="text" value="<?php echo $item['1']['value'];?>" />
</div>
<small class='help-inline'>欢迎语</small>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_short_intro">简短介绍</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_short_intro" name="short_intro" type="text" value="<?php echo $item['2']['value'];?>" />
<small class='help-inline'>网站简短介绍, 显示在右侧边栏</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_marketing_str">关键字</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_marketing_str" name="site_keywords" type="text" value="<?php echo $item['6']['value'];?>" />
<small class='help-inline'>用英文逗号(,)隔开</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_static">网站风格</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_static" name="static" type="text" value="<?php echo $this->config->item('static');?>" />
<small class='help-inline'>例如: default,white</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_themes">模板目录设定</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_themes" name="themes" type="text" value="<?php echo $this->config->item('themes');?>" />
<small class='help-inline'>例如: default</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_logo">网站logo</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_logo" name="logo" type="text" value="<?php echo $this->config->item('logo')?>" />
<small class='help-inline'>可填入文字或图片地址</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="is_rewrite">开启伪静态</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($item['10']['value'] =='on'){ ?> checked="checked"<?php } ?> id="settings_is_rewrite_on" name="is_rewrite" type="radio" value="on" />
开启
</label>
<label class='radio-inline'>
<input<?php if($item['10']['value'] =='off'){ ?> checked="checked"<?php } ?> id="settings_is_rewrite_off" name="is_rewrite" type="radio" value="off" />
关闭
</label>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="is_rewrite">开启验证码</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($item['3']['value'] =='on'){ ?> checked="checked"<?php } ?> id="settings_show_captcha_on" name="show_captcha" type="radio" value="on" />
开启
</label>
<label class='radio-inline'>
<input<?php if($item['3']['value'] =='off'){ ?> checked="checked"<?php } ?> id="settings_show_captcha_off" name="show_captcha" type="radio" value="off" />
关闭
</label>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="is_rewrite">启用编辑器</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($item['11']['value'] =='on'){ ?> checked="checked"<?php } ?> id="settings_show_editor_on" name="show_editor" type="radio" value="on" />
开启
</label>
<label class='radio-inline'>
<input<?php if($item['11']['value'] =='off'){ ?> checked="checked"<?php } ?> id="settings_show_editor_off" name="show_editor" type="radio" value="off" />
关闭
</label>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="auto_tag">标签开关</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($this->config->item('auto_tag') =='on'){ ?> checked="checked"<?php } ?> id="settings_auto_tag_on" name="auto_tag" type="radio" value="on" />
自动生成
</label>
<label class='radio-inline'>
<input<?php if($this->config->item('auto_tag') =='off'){ ?> checked="checked"<?php } ?> id="settings_auto_tag_off" name="auto_tag" type="radio" value="off" />
手动录入
</label>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="site_close">社区运行状态</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($this->config->item('site_close') =='on'){ ?> checked="checked"<?php } ?> id="settings_site_close_on" name="site_close" type="radio" value="on" />
开启站点
</label>
<label class='radio-inline'>
<input<?php if($this->config->item('site_close') =='off'){ ?> checked="checked"<?php } ?> id="settings_site_close_off" name="site_close" type="radio" value="off" />
关闭站点
</label>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_site_close_msg">站点关闭公告</label>
<div class='col-sm-5'>
<textarea class="form-control" id="settings_site_close_msg" name="site_close_msg" rows="5"><?php echo $this->config->item('site_close_msg')?>
</textarea>
</div>
</div>
<!--
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_show_community_stats">社区运行状态</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($item['4']['value'] =='on'){ ?> checked="checked"<?php } ?> id="settings_show_community_stats_on" name="site_run" type="radio" value="on" />
显示
</label>
<label class='radio-inline'>
<input<?php if($item['4']['value'] =='off'){ ?> checked="checked"<?php } ?> id="settings_show_community_stats_off" name="site_run" type="radio" value="off" />
隐藏
</label>
</div>
</div>-->

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_custom_head_tags">第三方统计代码</label>
<div class='col-sm-5'>
<textarea class="form-control" id="settings_custom_head_tags" name="site_stats" rows="5"><?php echo $item['5']['value'];?>
</textarea>
<small class='help-inline'>支持HTML</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_seo_description">SEO 描述</label>
<div class='col-sm-5'>
<textarea class="form-control" id="settings_seo_description" name="site_description">
<?php echo $item['7']['value'];?></textarea>
<small class='help-inline'>用于HTML meta标签</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_reward_title">奖励名称</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_reward_title" name="reward_title" type="text" value="<?php echo $item['8']['value'];?>" />
<small class='help-inline'>例如: 银币，金币，积分，优惠券，代金券，蓝钻, Q币等</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="encryption_key">安全密钥</label>
<div class='col-sm-5'>
<input class="form-control" id="encryption_key" name="encryption_key" type="text" value="<?php echo $this->config->item('encryption_key')?>" />
<small class='help-inline'>安全密钥</small>
</div>
</div>
<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit" class="btn btn-primary">保存</button>
</div>
</div>

</form>
</div><!-inner->
</div>

<div class="tab-pane" id="tab2">
<div class="inner">
<form accept-charset="UTF-8" action="<?php echo site_url('admin/site_settings?a=topicset');?>" class="form-horizontal" method="post">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="_method" type="hidden" value="put" />
<input name="authenticity_token" type="hidden" value="YNAXPQDviOJ/cf5OH/KrqdxOjGLCdka+kUCp+fa3J+A=" />
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="comment_order">回复列表顺序</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($item['12']['value'] =='asc'){ ?> checked="checked"<?php } ?> id="settings_show_order_on" name="comment_order" type="radio" value="asc" />
正序
</label>
<label class='radio-inline'>
<input<?php if($item['12']['value'] =='desc'){ ?> checked="checked"<?php } ?> id="settings_show_order_off" name="comment_order" type="radio" value="desc" />
倒序
</label>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="is_approve">话题(回复)审核开关</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($this->config->item('is_approve') =='on'){ ?> checked="checked"<?php } ?> id="settings_show_approve_on" name="is_approve" type="radio" value="on" />
需审核
</label>
<label class='radio-inline'>
<input<?php if($this->config->item('is_approve') =='off'){ ?> checked="checked"<?php } ?> id="settings_show_approve_off" name="is_approve" type="radio" value="off" />
无需审核
</label>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_pagination_comments">首页列表条数</label>
<div class='col-sm-5'>
<div class='input-group'>
<input class="form-control" id="settings_pagination_comments" name="home_page_num" type="text" value="<?php echo $this->config->item('home_page_num');?>" />
<span class='input-group-addon'>/ 页</span>
</div>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_pagination_comments">列表每页条数</label>
<div class='col-sm-5'>
<div class='input-group'>
<input class="form-control" id="settings_pagination_comments" name="per_page_num" type="text" value="<?php echo $item['9']['value'];?>" />
<span class='input-group-addon'>/ 页</span>
</div>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_timespan">发贴时间间隔</label>
<div class='col-sm-5'>
<div class='input-group'>
<input class="form-control" id="settings_timespan" name="timespan" type="text" value="<?php echo $this->config->item('timespan');?>" />
<span class='input-group-addon'>/ 秒</span>
</div>
<small class='help-inline'>0为不限制</small>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_words_limit">发贴字数限制</label>
<div class='col-sm-5'>
<div class='input-group'>
<input class="form-control" id="settings_words_limit" name="words_limit" type="text" value="<?php echo $this->config->item('words_limit');?>" />
<span class='input-group-addon'>/ 字</span>

</div><small class='help-inline'>默认5000字</small>
</div>
</div>
<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit" class="btn btn-primary">保存</button>
</div>
</div>

</form>
</div><!-inner->
</div>

<div class="tab-pane" id="tab3">
<div class="inner">
<form accept-charset="UTF-8" action="<?php echo site_url('admin/site_settings?a=openid');?>" class="form-horizontal" method="post">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="_method" type="hidden" value="put" />
<input name="authenticity_token" type="hidden" value="YNAXPQDviOJ/cf5OH/KrqdxOjGLCdka+kUCp+fa3J+A=" />
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_qq_appid">QQ appid</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_site_name" name="qq_appid" type="text" value="<?php echo $this->config->item('qq_appid');?>" />
<small class='help-inline'>申请到的appid</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_welcome_tip">QQ appkey</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_qq_appkey" name="qq_appkey" type="text" value="<?php echo $this->config->item('qq_appkey');?>" />
<small class='help-inline'>申请到的appkey</small>
</div>
</div>
<!--<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_ga_id">Google Analytics ID</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_ga_id" name="settings[ga_id]" type="text" value="" />
<small class='help-inline'>例如: UA-12345678-01</small>
</div>
</div>-->
<hr>
<!--<div class='form-group'>
<label class="col-sm-3 control-label" for="is_rewrite">开启伪静态</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($item['10']['value'] =='on'){ ?> checked="checked"<?php } ?> id="settings_is_rewrite_on" name="is_rewrite" type="radio" value="on" />
开启
</label>
<label class='radio-inline'>
<input<?php if($item['10']['value'] =='off'){ ?> checked="checked"<?php } ?> id="settings_is_rewrite_off" name="is_rewrite" type="radio" value="off" />
关闭
</label>
</div>
</div>-->

<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit" class="btn btn-primary">保存</button>
</div>
</div>
</form>
</div><!-inner->
</div>

<div class="tab-pane" id="tab4">
<div class="inner">
<form accept-charset="UTF-8" action="<?php echo site_url('admin/site_settings?a=mailset');?>" class="form-horizontal" method="post">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="_method" type="hidden" value="put" />
<input name="authenticity_token" type="hidden" value="YNAXPQDviOJ/cf5OH/KrqdxOjGLCdka+kUCp+fa3J+A=" />
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="protocol">邮件发送方式：</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($this->config->item('protocol') =='smtp'){ ?> checked="checked"<?php } ?> id="settings_protocol" name="protocol" type="radio" value="smtp" />Smtp</label>
<!--<label class='radio-inline'>
<input<?php if($item['10']['value'] =='off'){ ?> checked="checked"<?php } ?> id="settings_is_rewrite_off" name="is_rewrite" type="radio" value="off" />
Phpmail
</label>-->
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_smtp_host">SMTP 服务器:</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_site_name" name="smtp_host" type="text" value="<?php echo $this->config->item('smtp_host');?>" />
<small class='help-inline'>设置 SMTP 服务器的地址</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_smtp_port">SMTP端口:</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_smtp_port" name="smtp_port" type="text" value="<?php echo $this->config->item('smtp_port');?>" />
<small class='help-inline'> 设置 SMTP 服务器的端口，默认为 25</small>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_smtp_user">发信人邮件地址:</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_smtp_user" name="smtp_user" type="text" value="<?php echo $this->config->item('smtp_user');?>" />
<small class='help-inline'>@发信人邮件地址</small>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_smtp_pass">邮箱密码:</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_smtp_user" name="smtp_pass" type="password" value="<?php echo $this->config->item('smtp_pass');?>" />
<small class='help-inline'>@发信人邮箱密码</small>
</div>
</div>

<hr>

<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit" class="btn btn-primary">保存</button>
</div>
</div>
</form>
</div><!-inner->
</div>

<div class="tab-pane" id="tab5">
<div class="inner">
<form accept-charset="UTF-8" action="<?php echo site_url('admin/site_settings?a=routes');?>" class="form-horizontal" method="post">
<div class="form-group">
<label class="col-sm-3 control-label" for="settings_default_controller">默认首页模块:</label>
<div class="col-sm-5">
<input class="form-control" id="settings_default_controller" name="default_controller" type="text" value="<?php echo $this->router->routes['default_controller'];?>" />
<small class="help-inline">比如home,section,或任何一个页面</small>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="settings_flist_url">列表页url:</label>
<div class="col-sm-5">
<input class="form-control" id="settings_flist_url" name="flist_url" type="text" value="<?php echo $routes[6];?>" />
<small class="help-inline">贴子列表页地址</small>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="settings_view_url">内容页url:</label>
<div class="col-sm-5">
<input class="form-control" id="settings_view_url" name="view_url" type="text" value="<?php echo $routes[7];?>" />
<small class="help-inline">贴子内容页地址</small>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="settings_tag_url">tag内容页url:</label>
<div class="col-sm-5">
<input class="form-control" id="settings_tag_url" name="tag_url" type="text" value="<?php echo $routes[8];?>" />
<small class="help-inline">tag内容页地址</small>
</div>
</div>

<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit" class="btn btn-primary">保存</button>
</div>
</div>
</form>
</div><!-inner->
</div>

<div class="tab-pane" id="tab6">
<div class="inner">
<form accept-charset="UTF-8" action="<?php echo site_url('admin/site_settings?a=storage');?>" class="form-horizontal" method="post">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="_method" type="hidden" value="put" />
<input name="authenticity_token" type="hidden" value="YNAXPQDviOJ/cf5OH/KrqdxOjGLCdka+kUCp+fa3J+A=" />
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="qiniu_set">附件存储方式：</label>
<div class='col-sm-5'>
<label class='radio-inline'>
<input<?php if($this->config->item('storage_set') =='local'){ ?> checked="checked"<?php } ?> id="settings_storage_set" name="storage_set" type="radio" value="local" />本地</label>
<label class='radio-inline'>
<input<?php if($this->config->item('storage_set') =='qiniu'){ ?> checked="checked"<?php } ?> id="settings_storage_set" name="storage_set" type="radio" value="qiniu" />七牛云(<a href="http://portal.qiniu.com/signup?code=3lmae10l9cl02" target=_blank>申请七牛</a>)</label>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_accesskey">七牛accesskey:</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_accesskey" name="accesskey" type="text" value="<?php echo $this->config->item('accesskey');?>" />
<small class='help-inline'>设置 Qiniu accesskey</small>
</div>
</div>
<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_secretkey">七牛secretkey:</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_secretkey" name="secretkey" type="text" value="<?php echo $this->config->item('secretkey');?>" />
<small class='help-inline'> 设置 Qiniu secretkey</small>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_bucket">空间名:</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_bucket" name="bucket" type="text" value="<?php echo $this->config->item('bucket');?>" />
<small class='help-inline'>七牛存储空间名</small>
</div>
</div>

<div class='form-group'>
<label class="col-sm-3 control-label" for="settings_file_domain">存储域名:</label>
<div class='col-sm-5'>
<input class="form-control" id="settings_file_domain" name="file_domain" type="text" value="<?php echo $this->config->item('file_domain');?>" />
<small class='help-inline'>空间中分配或绑定的域名</small>
</div>
</div>

<hr>

<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit" class="btn btn-primary">保存</button>
</div>
</div>
</form>
</div><!-inner->
</div>


<!--<div class="tab-pane" id="tab7">
<p>Howdy, I'm in Section 6.</p>
</div>-->

</div>
</div>



</div>

</div>
</div></div></div>
<?php $this->load->view ( 'footer' ); ?>
</body></html>
