<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ( 'header-meta' ); ?>
</head>
<body id="startbbs">
<?php $this->load->view ( 'header' ); ?>

<div id="wrap">
<div class="container" id="page-main">
<div class="row">

<?php $this->load->view ('leftbar');?>

<div class='col-xs-12 col-sm-6 col-md-9'>

<div class='box'>
<div class='cell'>
<div class='pull-right'><a href="<?php echo site_url('admin/links');?>" class="btn">返回<?php echo $title?></a></div>
<a href="<?php echo site_url()?>" class="startbbs1">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/login');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> <?php echo $title?>
</div>
<div class='cell'>
<form accept-charset="UTF-8" action="<?php echo site_url('admin/links/add');?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="iM/k39XK4U+GmgVT7Ps8Ko3OhPrcTBqUSu4yKYPgAjk=" /></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="name">网站名</label>
<div class="col-sm-5">
<input class="form-control" id="name" name="name" size="50" type="text" value="" /></div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="url">网址</label>
<div class="col-sm-5">
<input class="form-control" id="url" name="url" size="50" type="email" value="" /></div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_account_attributes_location">显示/隐藏</label>
<div class="col-sm-5">
<label class='radio-inline'>
<input checked="checked" id="settings_show_community_stats_on" name="is_hidden" type="radio" value="0" />
显示
</label>
<label class='radio-inline'>
<input id="settings_show_community_stats_off" name="is_hidden" type="radio" value="1" />
隐藏
</label>
</div>
</div>

<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit" class="btn btn-primary">添加链接</button>
</div>
</div>
</form>
</div>
</div>

</div>
</div></div></div>
<?php $this->load->view ('footer');?>

</body></html>
