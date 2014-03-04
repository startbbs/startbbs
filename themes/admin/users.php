<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ( 'header-meta' ); ?>
</head>
<body id="startbbs">
<?php $this->load->view ('header'); ?>
<div id="wrap"><div class="container" id="page-main">
<div class="row">
<?php $this->load->view ('leftbar');?>

<div class='col-xs-12 col-sm-6 col-md-9'>

<div class='box'>
<div class='cell'>
<div class='pull-right'>
<form accept-charset="UTF-8" action="<?php echo site_url('admin/users/search');?>" class="form-search" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /></div>
<div class='input-group'>
<input class="span2 search-query" id="username" name="username" placeholder="用户昵称" type="text" />
<input class="btn" name="commit" type="submit" value="搜索" />
</div>
</form>
</div>
<a href="<?php echo site_url()?>" class="startbbs1">StartBBS</a> <span class="chevron">&nbsp;›&nbsp;</span> <a href="<?php echo site_url('admin/login');?>">管理后台</a> <span class="chevron">&nbsp;›&nbsp;</span> 用户
</div>
<div class='cell'>
<div>
    <ul class="nav nav-pills">
    <li<?php if($act=='index' || $act=='search'){?> class="active"<?php }?>><a href="<?php echo site_url('admin/users/index');?>">用户列表</a></li>
    <li<?php if($act=='groupindex' || $act=='groupedit'){?> class="active"<?php }?>><a href="<?php echo site_url('admin/users/group/index');?>">用户组</a></li>
    </ul>
<?php if($act=='index' || $act=='search'){?>
<div>
<table class='table'>
<thead>
<tr>
<th align='right'>ID</th>
<th align='left' class='w50'>昵称</th>
<th align='left' class='auto'>角色</th>
<th align='left' class='auto'>Email</th>
<th align='right' class='auto'>银币</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach($users as $v){?>
<tr class='highlight' id='user_<?php echo $v['uid']?>'>
<td align='right'><?php echo $v['uid']?></td>
<td align='left' class='auto'>
<strong>
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="black startbbs profile_link" title="admin"><?php echo $v['username']?></a>
</strong>
</td>
<td align='left' class='w50'>
<strong class='green'><?php echo $v['group_type']?></strong>
</td>
<td align='left' class='auto'><?php echo $v['email']?></td>
<td align='right' class='auto'>
<?php echo $v['money']?>
</td>
<td class='center'>
<a href="<?php echo site_url('admin/users/edit/'.$v['uid']);?>" class="btn btn-primary btn-sm">修改</a>
<a href="<?php echo site_url('admin/users/del/'.$v['uid']);?>" class="btn btn-sm btn-danger">删除</a>
</td>
</tr>
<?php }?>
</tbody>
</table>
</div>

<div align='center' class='inner'>
<div>
<ul class='pagination'>
<?php if($act=='index') echo $pagination?>
</ul>
</div>
</div>
<?php }?>
<?php if($act=='groupindex'){?>
<table class='table'>
<thead>
<tr>
<th>GID</th>
<th class='w50'>用户组</th>
<th class='auto'>类型</th>
<th class='auto'>用户数</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach($group_list as $v){?>
<tr class='highlight' id='user_<?php echo $v['gid']?>'>
<td><?php echo $v['gid']?></td>
<td class='auto'>
<strong>
<a href="<?php echo site_url('admin/users/group/edit/'.$v['gid']);?>" class="black startbbs profile_link" title="admin"><?php echo $v['group_name']?></a>
</strong>
</td>
<td align='left' class='w50'>
<strong class='green'><?php echo $v['group_type']?></strong>
</td>
<td class='auto'>
<?php echo $v['usernum']?>
</td>
<td>
<a href="<?php echo site_url('admin/users/group/edit/'.$v['gid']);?>" class="btn btn-primary btn-sm">修改</a>
<?php if($v['group_type']>=2){?>
<a href="<?php echo site_url('admin/users/group/del/'.$v['gid']);?>" class="btn btn-sm btn-danger">删除</a>
<?php }?>
</td>
</tr>
<?php }?>
</tbody>
</table>

<a href="<?php echo site_url('admin/users/group/add');?>" class="btn">新建用户组</a>

<?php }?>
<?php if($act=='groupadd'){?>
<div class='cell'>
<form accept-charset="UTF-8" action="<?php echo site_url('admin/users/group/add');?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="iM/k39XK4U+GmgVT7Ps8Ko3OhPrcTBqUSu4yKYPgAjk=" /></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_group_name">用户组名</label>
<div class="col-sm-5">
<input class="form-control" id="user_group_name" name="group_name" size="50" type="text" value="" /></div></div>
<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit_add" value=1 class="btn btn-primary">添加用户组</button>
</div>
</div>
</form>
</div>
<?php }?>
<?php if($act=='groupedit'){?>
<div class='cell'>
<form accept-charset="UTF-8" action="<?php echo site_url('admin/users/group/edit/'.$group_info['gid']);?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
<div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="iM/k39XK4U+GmgVT7Ps8Ko3OhPrcTBqUSu4yKYPgAjk=" /></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_group_name">用户组名</label>
<div class="col-sm-5">
<input class="form-control" id="user_group_name" name="group_name" size="50" type="text" value="<?php echo $group_info['group_name']?>" /></div></div>

<div class="form-group">
<div class="col-sm-offset-3 col-sm-9">
  <button type="submit" name="commit_edit" value=1 class="btn btn-primary">更新用户组</button>
</div>
</div>
</form>
</div>
<?php }?>
</div>

</div>
</div></div></div>
<?php $this->load->view ( 'footer' ); ?>

</body></html>