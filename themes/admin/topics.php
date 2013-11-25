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
<a href="<?php echo site_url();?>" class="startbbs1">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/login');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> 讨论话题
</div>
<div class='cell'>
<?php if($topics){?>
<form name="myform" method="post" action="<?php echo site_url('admin/topics/batch_process')?>">
<table class='topics table'>
<thead>
<tr>
<th align='left' class='auto'><input id="checkall" type="checkbox" checked="1"></th>
<th class='w50'>ID</th>
<th align='left' class='auto'>节点</th>
<th align='left' class='auto'>标题</th>
<th align='left' class='auto'>作者</th>
<th align='right' class='auto'>回复数</th>
<th align='right' class='auto'>创建时间</th>
<th class='w100'>操作</th>
</tr>
</thead>
<tbody>
<?php foreach($topics as $k=>$v){ ?>
<tr class='highlight'>
<td class='auto'>
<input name="<?php echo $k?>" checked="1" value="<?php echo $v['fid']?>" type="checkbox">
</td>
<td class='w50'>
<strong class='green'>
<?php echo $v['fid']?>
</strong>
</td>
<td class='auto'>
<a href="<?php echo site_url('forum/flist/'.$v['cid']);?>"><?php echo sb_substr($v['cname'],10)?></a>
</td>
<td class='auto'>
<a href="<?php echo site_url('forum/view/'.$v['fid']);?>"><?php echo sb_substr($v['title'],10)?></a>
</td>
<td class='auto'>
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="rabel profile_link" title="admin"><?php echo $v['username']?></a>
</td>
<td align='right' class='auto'>
<?php echo $v['comments']?>
</td>
<td align='right' class='auto'>
<small class='fade1'><?=date('Y-m-d',$v['addtime'])?></small>
</td>
<td class='w100'>
<a href="<?php echo site_url('forum/edit/'.$v['fid']);?>" class="btn btn-primary btn-sm">编辑</a>
<a href="<?php echo site_url('admin/topics/del/'.$v['fid'].'/'.$v['cid'].'/'.$v['uid']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗？" data-method="delete" rel="nofollow">删除</a>
<?php if($v['is_top']==0){?>
<a href="<?php echo site_url('admin/topics/set_top/'.$v['fid']).'/'.$v['is_top'];?>" class="btn btn-primary btn-sm">置顶</a>
<?php } else {?>
<a href="<?php echo site_url('admin/topics/set_top/'.$v['fid']).'/'.$v['is_top'];?>" class="btn btn-primary btn-sm">取消置顶</a>
<?php } ?>
<?php if($v['is_hidden']==1){?>
<a href="<?php echo site_url('admin/topics/approve/'.$v['fid']);?>" class="btn btn-primary btn-sm">审</a>
<?php } ?>
</td>
</tr>
<?php } ?>

</tbody>
</table>
<div class='form-actions'>
<input class="btn btn-primary btn-danger" name="batch_del" type="submit" value="批量删除" />
<input class="btn btn-primary" name="batch_approve" type="submit" value="批量审核" />
</div>
<?php } else{?>
暂无贴子
<?php }?>
</div>
<div align='center' class='inner'>
<div>
<ul class='pagination'>
<?php echo $pagination?>
</ul>
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
