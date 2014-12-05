<!DOCTYPE html>
<html>
<head>
<meta content='建议与想法 - ' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
<script src="<?php echo base_url('static/common/js/plugins.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/common/js/jquery.upload.js')?>" type="text/javascript"></script>
<?php if($this->config->item('storage_set')=='local'){?>
<script src="<?php echo base_url('static/common/js/local.file.js')?>" type="text/javascript"></script>
<?php } else{?>
<script src="<?php echo base_url('static/common/js/qiniu.js')?>" type="text/javascript"></script>
<?php }?>
</head>
<body id="startbbs">
<?php $this->load->view('common/header');?>
<div id="wrap"><div class="container" id="page-main"><div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box'>
<div class='box-header'>
编辑话题 <?php echo $item['title']?>
</div>
<div class='inner row'>
<!--<div class='alert alert-info'>如果标题已经包含你想说的话，内容可以留空。</div>-->
<form accept-charset="UTF-8" action="<?php echo site_url('/topic/edit/'.$item['topic_id']);?>" class="simple_form form-vertical" id="new_topic" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline">
<input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>">
<input name="uid" type="hidden" value="1" />
<input name="node_id" type="hidden" value="1" />
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
<select name="node_id" id="node_id" class="form-control">
<?php if(set_value('node_id')){?>
<option selected="selected" value="<?php echo set_value('node_id'); ?>"><?php echo $cate['cname']?>(已选)</option>
<?php } else {?>
<option selected="selected" value="<?php echo $cate['node_id'];?>"><?php echo $cate['cname'];?>(已选)</option>
<?php } ?>
<?php if($cates[0]) foreach($cates[0] as $c) {?>
<optgroup label="&nbsp;&nbsp;<?php echo $c['cname']?>">
<?php if($cates[$c['node_id']]) foreach($cates[$c['node_id']] as $sc){?>
<option value="<?php echo $sc['node_id']?>"><?php echo $sc['cname']?></option>
<?php } ?>
<?php } ?>
</select>
<span class="help-inline red"><?php echo form_error('node_id');?></span>
</div>
<!--<div id='preview-widget'>
<a href="javascript:void(0);" class="action_label cancel_preview current_label" data-ref="topic_content">编辑</a>
</div>-->
<div class="form-group text optional">
<div class="col-md-12" id="textContain">
<textarea class="form-control" id="post_content" name="content" placeholder="话题内容" rows="10"><?php echo $item['content']?>
</textarea>
<span class="help-inline red"><?php echo form_error('content');?></span>
<p style="margin-top:8px;">
<span class='text-muted pull-left'>可直接粘贴链接和图片地址/发代码用&lt;pre&gt;标签</span>
<span class="pull-right"><?php if($this->config->item('storage_set')=='local'){?>
<input id="upload_file" type="button" value="图片/附件" name="file" class="btn btn-default pull-right">
	<?php } else {?>
	<input id="upload_tip" type="button" value="图片/附件"  class="btn btn-default">
<!--	<input type="button" onclick="doUpload()" value="图片/附件"  class="btn btn-default">-->
	<?php }?></span></p>
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
<?php $this->load->view('common/sidebar_login')?>

<?php $this->load->view('common/sidebar_ad');?>

</div>
</div></div></div>
<?php $this->load->view('common/footer');?>
</body>
</html>