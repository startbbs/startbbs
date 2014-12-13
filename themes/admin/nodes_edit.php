<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ('common/header-meta' ); ?>
</head>
<body id="startbbs">
<?php $this->load->view ( 'common/header' ); ?>
    <div class="container">
        <div class="row">
            <?php $this->load->view ('common/sidebar');?>
            <div class="col-md-9">
                <ol class="breadcrumb">
				  <li><a href="<?php echo site_url('admin/login')?>">管理首页</a></li>
				  <li><a href="<?php echo site_url('admin/nodes')?>">结点列表</a></li>
				  <li class="active">编辑结点</li>
				</ol>
                <div class="panel panel-default">
	                <div class="panel-heading">
		            编辑节点<span class="small pull-right"><a href="<?php echo site_url('admin/nodes');?>">返回分类列表</a></span>
		            </div>
                    <div class="panel-body">
					<form accept-charset="UTF-8" action="<?php echo site_url('admin/nodes/edit/'.$cateinfo['node_id']);?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
					<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>" id="token">
					<div class='input-group'>
					<div class="form-group">
					<label class="col-md-3 control-label" for="cname">分类名称</label>
					<div class="col-md-5">
					<input class="form-control" id="cname" name="cname" size="50" type="text" value="<?php echo $cateinfo['cname']?>" /></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="user_email">父目录</label>
					<div class="col-md-5">
					<select name="pid" id="pid" class="form-control">
					<option selected="selected" value="<?php echo $pcateinfo['node_id']?>"><?php echo $pcateinfo['cname']?>(已选)</option>
					<?php foreach($cates as $v){?>
					<option value="<?php echo $v['node_id']?>"><?php echo $v['cname']?></option>
					<?php } ?>
					</select>
					</div></div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="keywords">分类关键字</label>
					<div class="col-md-5">
					<input class="form-control" id="keywords" name="keywords" size="50" type="text" value="<?php echo $cateinfo['keywords']?>" /></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="ico">分类ico</label>
					<div class="col-md-4">
					<input class="form-control" id="ico" name="ico" size="50" type="text" value="<?php echo $cateinfo['ico']?>" />
					</div>
					<div>
					<input id="upload_ico" type="button" value="选择"  class="btn btn-success">
					</div>


					</div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="content">分类简介</label>
					<div class="col-md-5">
					<textarea class="form-control" cols="40" id="content" name="content" rows="5"><?php echo $cateinfo['content']?></textarea></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="master">节点版主</label>
					<div class="col-md-5">
					<input class="form-control" id="master" name="master" size="50" type="text" value="<?php echo $cateinfo['master']?>" />
					<small class='help-inline'>多个版主间用逗号隔开(,)</small>
					</div></div>
					<div class="form-group">
					<label class="col-md-3 control-label" for="permit">节点权限</label>
					<div class="col-md-5">
					<?php foreach($group_list as $k=>$v){ ?>
					<label class="checkbox inline">
					<input name="permit_<?php echo $k;?>"<?php if(in_array($v['gid'],$permit_selected)){?> checked="1"<?php }?> value="<?php echo $v['gid']?>" type="checkbox"><?php echo $v['group_name']?>
					</label>
					<?php } ?>
					<label class="checkbox">
					(<input id="checkall" type="checkbox"<?php if($cateinfo['permit']){?> checked="1"<?php }?>>全选/取消
					<small class='help-inline'>不选时为不限制</small>)
					</label>

					</div></div>

					<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
					  <button type="submit" name="commit" class="btn btn-primary">更新</button>
					</div>
					</div>
					</div>
					</form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ('common/footer');?>
<script src="<?php echo base_url('static/common/js/jquery.upload.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#upload_ico").click(function(){ 
	doUpload(); 
	});
});
function doUpload() {
        // 上传方法
        var token=$('#token').val();
        $.upload({
                        // 上传地址
                        url:baseurl+"index.php/upload/upload_pic/<?php echo $cateinfo['node_id']?>", 
                        // 文件域名字
                        fileName: 'img', 
                        // 其他表单数据
                        params:{stb_csrf_token:token},
                        // 上传完成后, 返回json, text
                        dataType: 'json',
                        // 上传之前回调,return true表示可继续上传
                        onSend: function() {
                                        return true;
                        },
                        // 上传之后回调
                        onComplate: function(data) {
	                        if(data.file_url){
	                        $('#ico').val(data.file_url);
	                        alert(data.msg);
                            } else {
								alert(data.error);
							}
                        }
        });
}
	</script>

<script type="text/javascript">
$(document).ready(function(){
  $("#checkall").bind('click',function(){
  $("input:checkbox").prop("checked",$(this).prop("checked"));//全选
  //$("[type]:checkbox").prop("checked", true);
  });

});
</script>
</body></html>
