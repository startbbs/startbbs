<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?=$title?> - 管理后台 - <?=$settings['site_name']?></title>
<?php $this->load->view ('header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view ('header');?>

<div id="wrap">
<div class="container" id="page-main">
<div class="row">
<?php $this->load->view ('leftbar');?>
<div class='col-xs-12 col-sm-6 col-md-9'>

<div class='box'>
<div class='inner'>
<div class='pull-right'>
<div class='btn-group'>
<a href="<?php echo site_url('admin/nodes/add');?>" class="btn btn-primary btn-sm" data-remote="true">添加节点</a>
<!--<a href="<?php echo site_url('admin/planes/sort');?>" class="btn btn-primary btn-sm" data-remote="true">排序</a>-->
</div>
</div>
<a href="<?php echo site_url();?>" class="startbbs">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/login');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> 分类节点
</div>
</div>
<div id='planes'>
<div class='box plane' id='plane_1'>
<div class='cell'>
<div class='pull-right'>
<a href="" class="dark" data-remote="true">操作选项</a>
</div>
分类列表
</div>
<?php if($cates){?>
<?php foreach($cates as $v){?>
<div class='cell node' id='node_1'>
<div class='pull-right'>
<a href="<?php echo site_url('/admin/nodes/edit/'.$v['cid']);?>" class="btn btn-primary btn-sm" data-remote="true" id="edit_node_1">修改节点</a>
<a href="<?php echo site_url('/admin/nodes/move/'.$v['cid']);?>" class="btn btn-primary btn-sm" data-remote="true">移动</a>
<a href="<?php echo site_url('/admin/nodes/del/'.$v['cid']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗?" data-method="delete" data-remote="true" rel="nofollow">删除</a>
</div>
<?=$v['cname'];?>
</div>
<?php if($scates=$this->cate_m->get_cates_by_pid($v['cid']))?>
<?php foreach($scates as $s){?>
<div class='cell node' id='node_1'>
<div class='pull-right'>
<a href="<?php echo site_url('/admin/nodes/edit/'.$s['cid']);?>" class="btn btn-primary btn-sm" data-remote="true" id="edit_node_1">修改节点</a>
<a href="<?php echo site_url('/admin/nodes/move/'.$s['cid']);?>" class="btn btn-primary btn-sm" data-remote="true">移动</a>
<a href="<?php echo site_url('/admin/nodes/del/'.$s['cid']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗?" data-method="delete" data-remote="true" rel="nofollow">删除</a>
</div>
├─&nbsp;<a href="<?php echo site_url('forum/flist/'.$s['cid']);?>"><?php echo $s['cname'];?></a>
</div>
<?php } ?>
<?php } ?>
<?php } else {?>
暂无分类
<?php } ?>
</div>

<div class='sep10'></div>

</div>

</div>
</div></div></div>
<?php $this->load->view ('footer');?>

</body></html>
