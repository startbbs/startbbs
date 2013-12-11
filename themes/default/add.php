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
<?php if($this->session->flashdata('error')){?>
<p class="alert alert-danger"><?php echo $this->session->flashdata('error');?></p>
<?php }?>
<div class='box'>
<div class='box-header'>
创建新话题
</div>
<div class='inner row'>
<!--<div class='alert alert-info'>如果标题已经包含你想说的话，内容可以留空。</div>-->
<form accept-charset="UTF-8" action="<?php echo site_url('forum/add')?>" id="new_topic" method="post" novalidate="novalidate" name="add_new">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="uid" type="hidden" value="1" />
<input name="cid" type="hidden" value="1" />
</div>
<a name='new_topic'></a>
<div class="form-group">
<div class="col-md-6">
<label for="topic_title">标题</label>
<input class="form-control" id="topic_title" name="title" type="text" value="<?php echo set_value('title'); ?>" /></div>
<span class="help-inline red"><?php echo form_error('title');?></span>
</div>

<div class="form-group" style="width:300px; margin-left: 15px; margin-top: 10px;">
<label for="category">版块</label>
<select name="cid" id="cid" class="form-control">
<?php if($cate['cid']){?>
<option selected="selected" value="<?php echo $cate['cid']; ?>"><?php echo $cate['cname']?></option>
<?php } elseif(set_value('cid')){?>
<option selected="selected" value="<?php echo set_value('cid'); ?>"><?php echo $cate['cname']?></option>
<?php } else {?>
<option selected="selected" value="">请选择分类</option>
<?php } ?>
<?php if($category[0]) foreach($category[0] as $v) {?>
<?php if($category[$v['cid']]){?>
<optgroup label="&nbsp;&nbsp;<?php echo $v['cname']?>">
<?php foreach($category[$v['cid']] as $c){?>
<option value="<?php echo $c['cid']?>">
<?php echo $c['cname']?>
</option>
<?php } ?>
<?php } else {?>
<option value="<?php echo $v['cid']?>">
<?php echo $v['cname']?>
</option>
<?php } ?>

<?php } ?>
</select>

<span class="help-inline red"><?php echo form_error('cid');?></span>
</div>
<!--<div id='preview-widget' style="margin-left: 15px;">
<a href="javascript:void(0);" class="action_label cancel_preview current_label" data-ref="topic_content">编辑区</a>
</div>-->
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
<textarea class="form-control" id="topic_content" name="content" placeholder="话题内容" rows="10"><?php echo set_value('content'); ?>
</textarea>
<span class="red"><?php echo form_error('content');?></span>
<span class="text-muted" style="float:right">(可直接粘贴链接和图片地址/发代码用&lt;pre&gt;标签)</span>
</div>
</div>
<?php if($this->config->item('auto_tag') =='off'){?>
<div class="form-group">
  <label for="keywords">标签：</label>
  <div class="col-sm-5">
    <input type="text" name="keywords" class="input-large" id="keywords">
    <span class="help-inline">标签间用逗号(,)隔开</span>
  </div>
</div>
<?php }?>
<div class="col-sm-9">
<input class="btn btn-primary" data-disable-with="正在提交" name="commit" type="submit" value="创建" />
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