<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $title?> - ' name='description'>
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

    <div class="container">
        <div class="row">
            <div class="col-md-8">
	            <?php if($this->session->flashdata('error')){?>
<p class="alert alert-danger"><?php echo $this->session->flashdata('error');?></p>
<?php }?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">创建新主题</h3>
                    </div>
                    <div class="panel-body">
						<form accept-charset="UTF-8" action="<?php echo site_url('topic/add')?>" id="new_topic" method="post" novalidate="novalidate" name="add_new">
						<input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" id="token">
						<input name="uid" type="hidden" value="1" />
						<input name="node_id" type="hidden" value="1" />
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input class="form-control" id="topic_title" name="title" type="text" value="<?php echo set_value('title');?>" />
                                <span class="help-block red"><?php echo form_error('title');?></span>
                            </div>
                            <div class="form-group">
                            <label for="node_id">节点</label>
							<select name="node_id" id="node_id" class="form-control">
							<?php if(isset($cate['node_id'])){?>
							<option selected="selected" value="<?php echo $cate['node_id']; ?>"><?php echo $cate['cname']?></option>
							<?php } elseif(set_value('node_id')){?>
							<option selected="selected" value="<?php echo set_value('node_id'); ?>"><?php echo $cate['cname']?></option>
							<?php } else {?>
							<option selected="selected" value="">请选择分类</option>
							<?php } ?>
							<?php if($category[0]) foreach($category[0] as $v) {?>
							<?php if($category[$v['node_id']]){?>
							<optgroup label="&nbsp;&nbsp;<?php echo $v['cname']?>">
							<?php foreach($category[$v['node_id']] as $c){?>
							<option value="<?php echo $c['node_id']?>">
							<?php echo $c['cname']?>
							</option>
							<?php } ?>
							<?php } else {?>
							<option value="<?php echo $v['node_id']?>">
							<?php echo $v['cname']?>
							</option>
							<?php } ?>

							<?php } ?>
							</select>
							<span class="help-block red"><?php echo form_error('node_id');?></span>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="post_content" name="content" placeholder="话题内容" rows="10"><?php echo set_value('content'); ?>
</textarea>
								<span class="help-block red"><?php echo form_error('content');?></span>
							    <p>
								<span text-muted>可直接粘贴链接和图片地址/发代码用&lt;pre&gt;标签</span>
								<span class="pull-right">
								<?php if($this->config->item('storage_set')=='local'){?>
								<input id="upload_file" type="button" value="图片/附件" name="file" class="btn btn-default pull-right">
								<?php } else {?>
								<input id="upload_file" type="button" value="图片/附件"  class="btn btn-default">
								<?php }?></span>
								</p>
                            </div>
							<?php if($this->config->item('auto_tag') =='off'){?>
							<div class="form-group">
							  <label for="keywords">标签：</label>
							    <input type="text" name="keywords" class="form-control" id="keywords">
							    <span class="help-block">标签间用逗号(,)隔开</span>
							</div>
							<?php }?>

                            <button type="submit" class="btn btn-primary">创建</button><small class="text-muted">(支持 Ctrl + Enter 快捷键)</small>

                        </form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

			<div class="col-md-4">
			<?php $this->load->view('common/sidebar_login')?>
			<?php $this->load->view('common/sidebar_ad');?>
			</div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer');?>
</body>
</html>