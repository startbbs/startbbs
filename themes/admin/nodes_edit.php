<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ( 'header-meta' ); ?>
<script src="<?php echo base_url('static/common/js/jquery.upload.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#upload_ico").click(function(){ 
	doUpload(); 
	});
});
function doUpload() {
        // 上传方法
        $.upload({
                        // 上传地址
                        url:baseurl+"index.php/upload/upload_pic/<?php echo $cateinfo['cid']?>", 
                        // 文件域名字
                        fileName: 'img', 
                        // 其他表单数据
                        //params: {name: 'pxblog'},
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
<div class='pull-right'><a href="<?php echo site_url('admin/nodes');?>" class="btn">返回分类列表</a></div>
<a href="<?php echo site_url();?>" class="startbbs1">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/login');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> 编辑分类
</div>
<div class='cell'>
<form accept-charset="UTF-8" action="<?php echo site_url('admin/nodes/edit/'.$cateinfo['cid']);?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="iM/k39XK4U+GmgVT7Ps8Ko3OhPrcTBqUSu4yKYPgAjk=" /></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="cname">分类名称</label>
<div class="col-sm-5">
<input class="form-control" id="cname" name="cname" size="50" type="text" value="<?php echo $cateinfo['cname']?>" /></div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_email">父目录</label>
<div class="col-sm-5">
<select name="pid" id="pid" class="form-control">
<option selected="selected" value="<?php echo $pcateinfo['cid']?>"><?php echo $pcateinfo['cname']?>(已选)</option>
<?php foreach($cates as $v){?>
<option value="<?php echo $v['cid']?>"><?php echo $v['cname']?></option>
<?php } ?>
</select>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="keywords">分类关键字</label>
<div class="col-sm-5">
<input class="form-control" id="keywords" name="keywords" size="50" type="text" value="<?php echo $cateinfo['keywords']?>" /></div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="ico">分类ico</label>
<div class="col-sm-4">
<input class="form-control" id="ico" name="ico" size="50" type="text" value="<?php echo $cateinfo['ico']?>" />
</div>
<div>
<input id="upload_ico" type="button" value="选择"  class="btn btn-success">
</div>


</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="content">分类简介</label>
<div class="col-sm-5">
<textarea class="form-control" cols="40" id="content" name="content" rows="5"><?php echo $cateinfo['content']?></textarea></div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="master">节点版主</label>
<div class="col-sm-5">
<input class="form-control" id="master" name="master" size="50" type="text" value="<?php echo $cateinfo['master']?>" />
<small class='help-inline'>多个版主间用逗号隔开(,)</small>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="permit">节点权限</label>
<div class="col-sm-5">
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

</form>
</div>
</div>

</div>
</div></div></div>
<?php $this->load->view ('footer');?>
<script type="text/javascript">
$(document).ready(function(){
  $("#checkall").bind('click',function(){
  $("input:checkbox").prop("checked",$(this).prop("checked"));//全选
  //$("[type]:checkbox").prop("checked", true);
  });

});
</script>
</body></html>
