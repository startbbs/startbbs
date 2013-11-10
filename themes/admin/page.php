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

<div class='box'>
<div class='cell'>
<div class='pull-right'>
<div class='btn-group'>
<a href="<?php echo site_url('admin/page/add');?>" class="btn btn-primary btn-sm" data-remote="true">添加页面</a>
</div>
</div>
<a href="<?php echo site_url()?>" class="startbbs1">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/login');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> <?php echo $title?>
</div>
<div class='cell'>
<?php if($page_list){?>
<table class='topics table'>
<thead>
<tr>
<th class='w50'>ID</th>
<th align='left' class='auto'>页面名称</th>
<th align='left' class='auto'>时间</th>
<th align='right' class='auto'>显示</th>
<th class='w100'>操作</th>
</tr>
</thead>
<tbody>
<?php foreach($page_list as $v){ ?>
<tr class='highlight'>
<td class='w50'>
<strong class='green'>
<?php echo $v['pid']?>
</strong>
</td>
<td class='auto'>
<a href="<?php echo site_url('page/index/'.$v['pid']);?>" class="startbbs profile_link" title="admin"><?php echo $v['title']?></a>
</td>
<td class='auto'>
<?php echo $this->myclass->friendly_date($v['add_time']);?>
</td>
<td class='auto'>
<small class='fade1'><?php if($v['is_hidden']==0){?>显示<?php } else {?>隐藏<?php }?></small>
</td>
<td class='w100'>
<a href="<?php echo site_url('admin/page/edit/'.$v['pid']);?>" class="btn btn-primary btn-sm">编辑</a>
<a href="<?php echo site_url('admin/page/del/'.$v['pid']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗？" data-method="delete" rel="nofollow">删除</a>
</td>
</tr>
<?php } ?>


</tbody>
</table>
<?php } else{?>
暂无内容，请添加内容
<?php }?>
</div>
<div align='center' class='inner'>
<div class='pagination pagination-centered pagination-small'>
<ul>
<?php echo $pagination;?>
</ul>
</div>

</div>
</div>

</div>
</div></div></div>
<?php $this->load->view ('footer');?>
</body></html>
