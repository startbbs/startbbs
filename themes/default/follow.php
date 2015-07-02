<!DOCTYPE html>
<html>
	<head>
		<meta content='' name='description'>
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
                        <h3 class="panel-title">我关注的会员</h3>
                    </div>
                    <div class="panel-body">
	                    <?php if(isset($follow_list)){?>
						<ul class='user-list clearfix'>
						<?php foreach($follow_list as $v){?>
						<li>
						<a href="<?php echo site_url('user/profile/'.$v['follow_uid']);?>"  title="<?php echo $v['username'];?>">
						<img class="img-rounded" alt="<?php echo $v['username'];?>" src="<?php echo base_url($v['avatar'].'normal.png');?>" />
						</a></li>
						<?php }?>
						</ul>
						<?php }else{?>
						暂无关注会员
						<?php }?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">关注会员的话题</h3>
                    </div>
                    <div class="panel-body">
	                    <?php if(isset($follow_user_topics)):?>
                        <ul class="media-list">
	                        <?php foreach($follow_user_topics as $v):?>
                            <li class="media">
                                <a class="media-left" href="<?php echo site_url('user/profile/'.$v['uid']);?>"><img class="img-rounded" src="<?php echo base_url($v['avatar'].'normal.png');?>" alt="<?php echo $v['username'];?>"></a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="<?php echo url('topic_show',$v['topic_id']);?>"><?php echo $v['title'];?></a><?php if( $v['is_top'] == '1' ) echo '<span class="badge badge-info">置顶</span>'; ?></h4>
                                    <p class="text-muted">
                                        <span><a href="<?php echo url('node_show',$v['node_id']);?>"><?php echo $v['cname']?></a></span>&nbsp;•&nbsp;
                                        <span><a href="<?php echo site_url('user/profile/'.$v['uid']);?>"><?php echo $v['username'];?></a></span>&nbsp;•&nbsp;
                                        <span><?php echo friendly_date($v['updatetime'])?></span>&nbsp;•&nbsp;
                                        <?php if ($v['rname']!=NULL):?>
                                            <span>最后回复来自 <a href="<?php echo site_url('user/profile/'.$v['ruid']);?>"><?php echo $v['rname']; ?></a></span>
                                        <?php else:?>
                                            <span>暂无回复</span>
                                        <?php endif;?>
                                    </p>
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                        <?php else:?>
						暂无话题
						<?php endif?>
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