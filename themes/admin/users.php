<!DOCTYPE html>
<html>
	<head>
		<meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ( 'common/header-meta' ); ?>
</head>
<body id="startbbs">
<?php $this->load->view ('common/header'); ?>

    <div class="container">
        <div class="row">
            <?php $this->load->view ('common/sidebar');?>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
	                    <ol class="breadcrumb">
						  <li><a href="<?php echo site_url('admin/login')?>">管理首页</a></li>
						  <li class="active">用户列表</li>
						</ol>
						<ul class="nav nav-pills">
						    <li<?php if($act=='index' || $act=='search'){?> class="active"<?php }?>><a href="<?php echo site_url('admin/users/index');?>">用户列表</a></li>
						    <li<?php if($act=='groupindex' || $act=='groupedit'){?> class="active"<?php }?>><a href="<?php echo site_url('admin/users/group/index');?>">用户组</a></li>
					    </ul>
						<?php if($act=='index' || $act=='search'){?>
						<table class='table table-hover table-condensed'>
							<thead>
								<tr>
									<th>ID</th>
									<th>昵称</th>
									<th>角色</th>
									<th>Email</th>
									<th>积分</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($users as $v){?>
								<tr id='user_<?php echo $v['uid']?>'>
									<td>
										<?php echo $v['uid']?>
									</td>
									<td>
										<strong><a href="<?php echo site_url('user/profile/'.$v['uid']);?>" class="black startbbs profile_link" title="admin"><?php echo $v['username']?></a></strong>
									</td>
									<td>	<strong class='green'><?php echo $v['group_type']?></strong>
									</td>
									<td>
										<?php echo $v['email']?>
									</td>
									<td>
										<?php echo $v['credit']?>
									</td>
									<td class='center'>	<a href="<?php echo site_url('admin/users/edit/'.$v['uid']);?>" class="btn btn-primary btn-sm">修改</a>
							<a href="<?php echo site_url('admin/users/del/'.$v['uid']);?>" class="btn btn-sm btn-danger">删除</a>
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<?php if(@$pagination){?>
						<ul class='pagination'>
						<?php if($act=='index') echo $pagination?>
						</ul>
						<?php }?>
						<ul class='pagination'>
							<?php echo form_open('admin/users/search', array('class'=>'form-inline'));?>
							<input id="username" class="form-control" name="username" placeholder="用户昵称" type="text" />
							<button type="submit" name="commit" class="btn btn-default">搜索</button>
							</form>
						</ul>
						<?php }?>

						<?php if($act=='groupindex'){?>
						<table class='table table-hover'>
							<thead>
								<tr>
									<th>GID</th>
									<th>用户组</th>
									<th>类型</th>
									<th>用户数</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($group_list as $v){?>
								<tr class='highlight' id='user_<?php echo $v[' gid ']?>'>
									<td>
										<?php echo $v[ 'gid']?>
									</td>
									<td>
									<strong><a href="<?php echo site_url('admin/users/group/edit/'.$v['gid']);?>" class="black startbbs profile_link" title="admin"><?php echo $v['group_name']?></a></strong>
									</td>
									<td>
									<strong class='green'><?php echo $v['group_type']?></strong>
									</td>
									<td>
										<?php echo $v[ 'usernum']?>
									</td>
									<td>
						<a href="<?php echo site_url('admin/users/group/edit/'.$v['gid']);?>" class="btn btn-primary btn-sm">修改</a>
										<?php if($v[ 'group_type']>=2){?>
						<a href="<?php echo site_url('admin/users/group/del/'.$v['gid']);?>" class="btn btn-sm btn-danger">删除</a>
										<?php }?>
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<a class="btn btn-default" href="<?php echo site_url('admin/users/group/add');?>" class="btn">新建用户组</a>
						<?php }?>
						<?php if($act=='groupadd'){?>
						<div>
						<form accept-charset="UTF-8" action="<?php echo site_url('admin/users/group/add');?>" class="simple_form form-horizontal" id="edit_user_1" method="post" novalidate="novalidate">
						<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
						<div class="form-group">
						<label class="col-md-3 control-label" for="user_group_name">用户组名</label>
						<div class="col-md-5">
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
						<input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
						<div class="form-group">
						<label class="col-md-3 control-label" for="user_group_name">用户组名</label>
						<div class="col-md-5">
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
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ( 'common/footer' ); ?>
</body></html>