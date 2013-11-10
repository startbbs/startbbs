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
<div class='pull-right'><a href="<?php echo site_url('admin/page');?>" class="btn">返回<?php echo $title?></a></div>
<a href="<?php echo site_url()?>" class="startbbs1">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> <?php echo $title?>
</div>
<div class='cell'>
<form accept-charset="UTF-8" action="<?php echo site_url('admin/page/edit/'.$page['pid']);?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="iM/k39XK4U+GmgVT7Ps8Ko3OhPrcTBqUSu4yKYPgAjk=" /></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="title">标题</label>
<div class="col-sm-5">
<input class="form-control" id="title" name="title" size="50" type="text" value="<?php echo $page['title'];?>" />
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="content">内容</label>
<div class="col-sm-5">
<textarea class="form-control" id="content" name="content" rows="10"><?php echo $page['content'];?></textarea>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="go_url">转向url</label>
<div class="col-sm-5">
<input class="form-control" id="go_url" name="go_url" size="60" type="text" value="<?php echo $page['go_url'];?>" />
<small class='help-inline'>没有外链，请留空</small>
</div></div>
<div class="form-group string optional">
<label class="col-sm-3 control-label" for="user_account_attributes_location">是否显示在底菜单</label>
<div class="col-sm-5">
<label class='radio-inline'>
<input<?php if($page['is_hidden'] =='0'){ ?> checked="checked"<?php } ?> id="settings_show_community_stats_on" name="is_hidden" type="radio" value="0" />
显示
</label>
<label class='radio-inline'>
<input<?php if($page['is_hidden'] =='1'){ ?> checked="checked"<?php } ?> id="settings_show_community_stats_off" name="is_hidden" type="radio" value="1" />
隐藏
</label>
</div>
</div>

<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit" class="btn btn-primary">编辑页面</button>
</div>
</div>

</form>
</div>
</div>

</div>
</div></div></div>
<?php $this->load->view ('footer');?>

</body></html>
