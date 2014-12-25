<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
</head>

<body id="startbbs">
<a id="top" name="top"></a>
<?php $this->load->view('common/header'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">通知中心</h3>
                    </div>
                    <div class="panel-body">
	                    <?php if($notices_list):?>
                        <ul class="media-list">
                            <?php foreach ($notices_list as $v) : ?>
                            <li class="media">
                                <div class="media-body">
                                    
                                    <blockquote>
									<h4 class="media-heading topic-list-heading">
									<a href="<?php echo site_url('user/profile/'.$v['suid']);?>"><img alt="<?php echo $v['username'];?> mini avatar" src="<?php echo base_url($v['avatar'].'small.png');?>" /></a><a href="<?php echo site_url('user/profile/'.$v['suid']);?>"><?php echo $v['username'];?></a> 在贴子<a href="<?php echo site_url('topic/show/'.$v['topic_id']);?>"><?php echo $v['title'];?>...</a>中</h4>
	                                <?php if($v['ntype']==0){?>回复了你　<?php }?>
									<?php if($v['ntype']==1){?>提到了@你　<?php }?>
                                    <?php echo friendly_date($v['ntime']);?>
                                    </blockquote>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if(@$pagination):?><ul class="pagination"><!--<?php echo $pagination; ?>--></ul><?php endif?>
                        <?php else: ?>
                        暂无提醒
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

			<div class="col-md-4">
				<?php $this->load->view('common/sidebar_login');?>
				<?php $this->load->view('common/sidebar_ad');?>
			</div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer');?>
</body>
</html>