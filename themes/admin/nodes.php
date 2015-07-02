<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ('common/header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view ('common/header');?>
    <div class="container">
        <div class="row">
            <?php $this->load->view ('common/sidebar');?>
            <div class="col-md-9">
                <ol class="breadcrumb">
				  <li><a href="<?php echo site_url('admin/login')?>">管理首页</a></li>
				  <li class="active">结点列表</li>
				</ol>
				<div class="panel panel-default">
				  	<!--<div class="panel-heading">ttttt<small class='pull-right'>操作选项</small></div>-->
				  	<div class="panel-body">
					<?php if($cates){?>
					<table class="table table-hover table-condensed">
						<?php foreach($cates as $v){?>
						<thead>
							<th>列表</th>
							<th><span class="pull-right">选项</span></th>
						</thead>
						<tr>
							<td><?php echo $v['cname'];?></td>
							<td><span class="pull-right"><a href="<?php echo site_url('/admin/nodes/edit/'.$v['node_id']);?>" class="btn btn-primary btn-sm" data-remote="true" id="edit_node_1">修改</a>
							<a href="<?php echo site_url('/admin/nodes/move/'.$v['node_id']);?>" class="btn btn-primary btn-sm" data-remote="true">移动</a>
							<a href="<?php echo site_url('/admin/nodes/del/'.$v['node_id']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗?" data-method="delete" data-remote="true" rel="nofollow">删除</a></span>
							</td>
						</tr>
						<?php if($scates=$this->cate_m->get_cates_by_pid($v['node_id']))?>
						<?php foreach($scates as $s){?>
						<tr>
							<td>├─&nbsp;<a href="<?php echo site_url('node/show/'.$s['node_id']);?>"><?php echo $s['cname'];?></a></td>
							<td><span class="pull-right"><a href="<?php echo site_url('/admin/nodes/edit/'.$s['node_id']);?>" class="btn btn-primary btn-sm" data-remote="true" id="edit_node_1">修改</a>
<a href="<?php echo site_url('/admin/nodes/move/'.$s['node_id']);?>" class="btn btn-primary btn-sm" data-remote="true">移动</a>
<a href="<?php echo site_url('/admin/nodes/del/'.$s['node_id']);?>" class="btn btn-sm btn-danger" data-confirm="真的要删除吗?" data-method="delete" data-remote="true" rel="nofollow">删除</a></span></td>
						</tr>
						<?php } ?>
						
						<?php } ?>
					</table>
					<?php } else {?>
					暂无分类
					<?php } ?>
					<a href="<?php echo site_url('admin/nodes/add');?>" class="btn btn-primary btn-sm" data-remote="true">添加节点</a>
					</div>

				</div>

            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ('common/footer');?>
</body></html>
