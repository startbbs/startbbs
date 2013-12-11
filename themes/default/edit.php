<!DOCTYPE html>
<html>
<head>
<meta content='建议与想法 - ' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view('header-meta');?>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/kindeditor-min.js');?>"></script>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/lang/zh_CN.js');?>"></script>
<?php if($this->config->item('show_editor')=='on'){?>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/keset.js');?>"></script>
<?php } elseif($this->config->item('storage_set')=='local'){?>
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
编辑话题 <?php echo $item['title']?>
</div>
<div class='inner row'>
<!--<div class='alert alert-info'>如果标题已经包含你想说的话，内容可以留空。</div>-->
<form accept-charset="UTF-8" action="<?php echo site_url('/forum/edit/'.$item['fid']);?>" class="simple_form form-vertical" id="new_topic" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="uid" type="hidden" value="1" />
<input name="cid" type="hidden" value="1" />
</div>
<a name='new_topic'></a>
<div class="form-group string required">
<div class="col-md-6">
<label class="string required control-label" for="topic_title">标题</label>
<input class="form-control" id="topic_title" maxlength="100" name="title" size="60" type="text" value="<?php echo $item['title']?>" /></div>
<span class="help-inline red"><?php echo form_error('title');?></span>
</div>

<div class="form-group optional" style="width:300px; margin-left: 15px; margin-top: 10px;">
<label for="category">版块</label>
<select name="cid" id="cid" class="form-control">
<?php if(set_value('cid')){?>
<option selected="selected" value="<?php echo set_value('cid'); ?>"><?php echo $cate['cname']?>(已选)</option>
<?php } else {?>
<option selected="selected" value="<?php echo $cate['cid'];?>"><?php echo $cate['cname'];?>(已选)</option>
<?php } ?>
<?php if($cates[0]) foreach($cates[0] as $c) {?>
<optgroup label="&nbsp;&nbsp;<?php echo $c['cname']?>">
<?php if($cates[$c['cid']]) foreach($cates[$c['cid']] as $sc){?>
<option value="<?php echo $sc['cid']?>"><?php echo $sc['cname']?></option>
<?php } ?>
<?php } ?>
</select>
<span class="help-inline red"><?php echo form_error('cid');?></span>
</div>
<!--<div id='preview-widget'>
<a href="javascript:void(0);" class="action_label cancel_preview current_label" data-ref="topic_content">编辑</a>
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
<div class="form-group text optional">
<div class="col-md-12" id="textContain">
<textarea class="form-control" id="topic_content" name="content" placeholder="话题内容" rows="10"><?php echo $item['content']?>
</textarea>
<span class="help-inline red"><?php echo form_error('content');?></span>
</div>
</div>
<div class="col-sm-9">
<input class="btn btn-primary btn-inverse" data-disable-with="正在提交" name="commit" type="submit" value="修改" />
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