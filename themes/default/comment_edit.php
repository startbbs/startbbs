<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $title?> - ' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view('header-meta');?>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/kindeditor-min.js');?>"></script>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/lang/zh_CN.js');?>"></script>
<?php if($this->config->item('show_editor')=='on'){?>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/keset.js');?>"></script>
<?php } elseif($this->config->item('storage_set')=='local') {?>
<link rel="stylesheet" href="<?php echo base_url('plugins/kindeditor/themes/default/default.css');?>" />
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/keupload.js');?>"></script>
<?php } else{?>
<script src="<?php echo base_url('static/common/js/jquery.upload.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/common/js/qiniu.js')?>" type="text/javascript"></script>
<?php }?>
</head>
<body id="startbbs">
<?php $this->load->view('header');?>
<div id="wrap"><div class="container" id="page-main"><div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>
<div class='box'>
<div class='box-header'>
修改回复
</div>
<div class='inner row'>
<form accept-charset="UTF-8" action="<?php echo site_url('comment/edit/'.$comment['cid'].'/'.$comment['fid'].'/'.$comment['id'])?>" id="new_topic" method="post" novalidate="novalidate" name="add_new">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="uid" type="hidden" value="1" />
<input name="cid" type="hidden" value="1" />
</div>
<a name='new_topic'></a>
<ul class="nav nav-tabs" style="margin-left: 15px; margin-right: 15px;border-bottom: 0px solid #999;height:20px">
  <li class="active"><a style="background-color: #eee;" href="#">编辑区</a></li>
  <?php if($this->config->item('show_editor')=='off'){?>
  <li class="pull-right">
	<?php if($this->config->item('storage_set')=='local'){?>
	<span id='upload-tip' class="btn btn-default" value="图片/附件">上传图片</span>
	<?php } else {?>
	<input id="upload_tip" type="button" value="图片/附件"  class="btn btn-default">
<!--	<input type="button" onclick="doUpload()" value="图片/附件"  class="btn btn-default">-->
	<?php }?>
	  </li>
<?php }?>
</ul>
<div class="form-group">
<div class="col-md-12" id="textContain">
<textarea class="form-control" id="topic_content" name="content" placeholder="话题内容" rows="10">
<?php if(set_value('content')){?>
<?php echo set_value('content'); ?>
<?php } else{?>
<?php echo $comment['content']; ?>
<?php }?>
</textarea>
<span class="red"><?php echo form_error('content');?></span>
<span class="text-muted" style="float:right">(可直接粘贴链接和图片地址/发代码用&lt;pre&gt;标签)</span>
</div>
</div>
<div class="col-sm-9">
<input class="btn btn-primary" data-disable-with="正在提交" name="commit" type="submit" value="修改" />
<small class='gray'>(支持 Ctrl + Enter 快捷键)</small>
</div>
</form>
</div>
</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('block/right_login')?>
<?php $this->load->view('block/right_ad');?>

</div>
</div></div></div>
<?php $this->load->view ('footer'); ?>