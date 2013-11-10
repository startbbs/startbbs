<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view('header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('header');?>
<div id="wrap">
<div class="container" id="page-main">
<div class="row">
<?php $this->load->view('leftbar');?>
<div class='col-xs-12 col-sm-6 col-md-9'>
<?php if($this->session->flashdata('error')){?>
<p class="alert alert-danger"><?php echo $this->session->flashdata('error');?></p>
<?php }?>
<div class='box'>
<div class='cell'>
<div class='pull-right'>
<div class='btn-group'>
<!--<a href="<?php echo site_url('admin/links/add');?>" class="btn btn-primary btn-sm" data-remote="true">添加链接</a>-->
</div>
</div>
<a href="<?php echo site_url()?>" class="startbbs1">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/login');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> <?php echo $title?>
</div>
<div class='cell'>
<div>
    <ul class="nav nav-pills">
    <li<?php if($act=='index'){?> class="active"<?php }?>><a href="<?php echo site_url('admin/db_admin/index');?>">数据处理</a></li>
    <li<?php if($act=='backup'){?> class="active"<?php }?>><a href="<?php echo site_url('admin/db_admin/backup');?>">数据备份</a></li>
    <li<?php if($act=='restore'){?> class="active"<?php }?>><a href="<?php echo site_url('admin/db_admin/restore');?>">数据恢复.</a></li>
<!--    <li<?php if($act=='sql'){?> class="active"<?php }?>><a href="<?php echo site_url('admin/db_admin/sql');?>">执行sql</a></li>-->
    </ul>
<div>
<?php if($act=='index'){?>
<form name="myform" method="post" action="<?php echo site_url('admin/db_admin/index')?>">
<table class='table table-striped table-bordered table-condensed'>
<thead>
<tr>
<th class='w50'><input id="checkall" type="checkbox" checked="1">&nbsp;&nbsp;全选/取消</th>
<!--<th align='left' class='auto'>数据表</th>
<th align='right' class='auto'></th>
<th class='w100'></th>-->
</tr>
</thead>
<tbody>

<?php foreach($table_list as $k=>$v){ ?>
<tr class='highlight'>
<td class='auto'>
<input name="<?php echo $k?>" checked="1" value="<?php echo $v?>" type="checkbox">&nbsp;&nbsp;<?php echo $v?>
</td>
<!--<td class='auto'></td>
<td class='auto'>
<a href="" class="startbbs profile_link" title="admin"></a>
</td>
<td class='w100'></td>-->
</tr>
<?php } ?>
</tbody>
</table>
<div class='form-actions'>
<input class="btn btn-primary" name="optimize" type="submit" value="优化数据表" />
<input class="btn btn-primary" name="repair" type="submit" value="修复数据库" />
</div>
</form>
<?php }?>
<?php if($act=='backup'){?>
<form name="myform" method="post" action="<?php echo site_url('admin/db_admin/backup')?>">
<table class='table table-striped table-bordered table-condensed'>
<thead>
<tr>
<th class='span2'>备份目录:</th>
<th align='left' class='auto'>/data/backup/</th>
<!--<th align='right' class='auto'></th>
<th class='w100'></th>-->
</tr>
</thead>
<tbody>


<tr class='highlight'>
<td class='auto'>
<label class="checkbox">
<input id="checkall" type="checkbox" checked="1">全选/取消
</label>
</td>
<td class='auto'>
<?php foreach($table_list as $k=>$v){ ?>
<label class="checkbox inline">
<input name="<?php echo $k?>" checked="1" value="<?php echo $v?>" type="checkbox"><?php echo $v?>
</label>
<?php } ?>
</td>
<!--<td class='auto'>
<a href="" class="startbbs profile_link" title="admin"></a>
</td>
<td class='w100'></td>-->
</tr>
</tbody>
</table>
<div class='form-actions'>
<input class="btn btn-primary" name="backup" type="submit" value="开始备份数据库" />
</div>
</form>
<?php }?>

<?php if($act=='restore'){?>
<form name="myform" method="post" action="<?php echo site_url('admin/db_admin/restore')?>">
<table class='table table-striped table-bordered table-condensed'>
<thead>
<tr>
<th class='w50'><input id="checkall" type="checkbox" checked="1">&nbsp;&nbsp;全选/取消</th>
<th align='left' class='auto'>文件大小</th>
<th align='right' class='auto'>创建日期</th>
<th class='w100'>操作</th>
</tr>
</thead>
<tbody>

<?php foreach($sqlfiles as $k=>$v){ ?>
<tr class='highlight'>
<td class='auto'>
<input name="<?php echo $k?>" checked="1" value="<?php echo $v['name']?>" type="checkbox">&nbsp;&nbsp;<?php echo $v['name']?>
</td>
<td class='auto'><?php echo $v['size']/1000?>k</td>
<td class='auto'><?php echo date('Y-m-d H:i:s',$v['date'])?></td>
<td class='w100'><a href="<?php echo base_url('data/backup/'.$v['name'])?>" target=_blank>下载</a>&nbsp;&nbsp;<a href="<?php echo site_url('admin/db_admin/restore/'.$v['name'])?>">还原数据库</td>
</tr>
<?php } ?>
</tbody>
</table>
<div class='form-actions'>
<input class="btn btn-primary" name="del" type="submit" value="清除文件" />
</div>
</form>
<?php }?>
</div>
<div class='inner'>
<p class="help-block"><strong>注意</strong>
大型数据不建议使用此工具。
</p>
</div>

</div>
</div>

</div>
</div></div></div>
<?php $this->load->view ('footer');?>
<script type="text/javascript">
$(document).ready(function(){
  $("#checkall").bind('click',function(){
  $("input:checkbox").prop("checked",$(this).prop("checked"));//全选
  });
});
</script>
</body></html>
