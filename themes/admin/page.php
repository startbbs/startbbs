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
				  <li class="active">单页面列表</li>
				</ol>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">单页面</h3>
                    </div>
                    <div class="panel-body">
					<?php if($page_list){?>
					<table class='table table-hover table-condensed'>
						<thead>
							<tr>
								<th>ID</th>
								<th>页面名称</th>
								<th>时间</th>
								<th>显示</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($page_list as $v){ ?>
							<tr>
								<td>
					<strong>

					<?php echo $v['pid']?>

					</strong>
								</td>
								<td>
									<a href="<?php echo site_url('page/index/'.$v['pid']);?>" title="<?php echo $v['title']?>">
										<?php echo $v[ 'title']?>
									</a>
								</td>
								<td>
									<?php echo friendly_date($v[ 'add_time']);?>
								</td>
								<td>
					<small><?php if($v['is_hidden']==0){?>显示<?php } else {?>隐藏<?php }?></small>
								</td>
								<td>
					<a href="<?php echo site_url('admin/page/edit/'.$v['pid']);?>" class="btn btn-primary btn-sm">编辑</a>
					<a href="<?php echo site_url('admin/page/del/'.$v['pid']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗？" data-method="delete" rel="nofollow">删除</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php if($pagination){?><ul class="pagination"><?php echo $pagination;?></ul><?php }?>
					<?php } else{?>
					暂无内容，请添加内容
					<?php }?>
					<a href="<?php echo site_url('admin/page/add')?>" class="btn btn-primary btn-sm" data-remote="true">添加单页面</a>

                    </div>
                </div>
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ('common/footer');?>
</body></html>
