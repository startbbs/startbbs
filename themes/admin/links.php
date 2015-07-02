<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('common/header');?>
    <div class="container">
        <div class="row">
            <?php $this->load->view ('common/sidebar');?>
            <div class="col-md-9">
                <ol class="breadcrumb">
				  <li><a href="<?php echo site_url('admin/login')?>">管理首页</a></li>
				  <li class="active">链接列表</li>
				</ol>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">链接列表</h3>
                    </div>
                    <div class="panel-body">
					<?php if($links){?>
					<table class='table table-hover table-condensed'>
						<thead>
							<tr>
								<th>ID</th>
								<th>链接名称</th>
								<th>网址</th>
								<th>显示</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($links as $v){ ?>
							<tr>
								<td>
									<strong><?php echo $v['id']?></strong>
								</td>
								<td>
									<a href="<?php echo $v['url']?>">
										<?php echo $v[ 'name']?>
									</a>
								</td>
								<td>
									<a href="<?php echo $v['url']?>" class="rabel profile_link" title="admin">
										<?php echo $v[ 'url']?>
									</a>
								</td>
								<td>
					<small class='fade1'><?php if($v['is_hidden']==0){?>显示<?php } else {?>隐藏<?php }?></small>
								</td>
								<td>
					<a href="<?php echo site_url('admin/links/edit/'.$v['id']);?>" class="btn btn-primary btn-sm">编辑</a>
					<a href="<?php echo site_url('admin/links/del/'.$v['id']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗？" data-method="delete" rel="nofollow">删除</a>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
					<ul class="paper">
						<?php echo $pagination?>
					</ul>
					<?php } else{?>暂无贴子
					<?php }?>
					<a href="<?php echo site_url('admin/links/add');?>" class="btn btn-primary btn-sm" data-remote="true">添加链接</a>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ('common/footer');?>
</body></html>
