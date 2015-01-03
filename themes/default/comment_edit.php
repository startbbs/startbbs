<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $title?> - ' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
<script src="<?php echo base_url('static/common/js/topic.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/common/js/plugins.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/common/js/jquery.upload.js')?>" type="text/javascript"></script>
<?php if($this->config->item('storage_set')=='local'){?>
<script src="<?php echo base_url('static/common/js/local.file.js')?>" type="text/javascript"></script>
<?php } else{?>
<script src="<?php echo base_url('static/common/js/qiniu.js')?>" type="text/javascript"></script>
<?php }?>
</head>
<body id="startbbs">
<a id="top" name="top"></a>
<?php $this->load->view ('common/header'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">修改回复</h3>
                    </div>
                    <div class="panel-body">
						<form accept-charset="UTF-8" action="<?php echo site_url('comment/edit/'.$comment['node_id'].'/'.$comment['topic_id'].'/'.$comment['id'])?>" id="new_topic" method="post" novalidate="novalidate" name="add_new">
						<input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>">
						<input name="uid" type="hidden" value="1" />
						<input name="node_id" type="hidden" value="1" />
						<div class="form-group">
						<textarea class="form-control" id="post_content" name="content" placeholder="话题内容" rows="10"><?php echo $comment['content']; ?></textarea>
                        <span class="help-block red"><?php echo form_error('content');?></span>
					    <p>
						<span class="text-muted">可直接粘贴链接和图片地址/发代码用&lt;pre&gt;标签</span>
						<span class="pull-right">
						<?php if($this->config->item('storage_set')=='local'){?>
						<input id="upload_file" type="button" value="图片/附件" name="file" class="btn btn-default pull-right">
						<?php } else {?>
						<input id="upload_file" type="button" value="图片/附件"  class="btn btn-default">
						<?php }?></span>
						</p>
						</div>
						<div class="col-md-9">
						<input class="btn btn-primary" data-disable-with="正在提交" name="commit" type="submit" value="修改" />
						<small class='gray'>(支持 Ctrl + Enter 快捷键)</small>
						</div>
						</form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

            <div class="col-md-4">
			<?php $this->load->view('common/sidebar_login');?>
			<?php $this->load->view('common/sidebar_ad');?>
            </div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ('common/footer'); ?>
</body>
</html>