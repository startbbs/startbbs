<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?>- <?php echo $settings['site_name']?></title>
<meta name="keywords" content="<?php echo $title?>" />
<meta name="description" content="<?php echo $category['content'];?>" />
<?php $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('common/header');?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">节点:<?php echo $category['cname'];?><span class="pull-right">话题&nbsp;<span class='badge badge-info'><?php echo $category['listnum'];?></span></span></h3>
                    </div>
                    <div class="panel-body">
                        <p class="text-muted">
                        <?php echo $category['content'];?>
                        </p>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">话题列表<small>(版主:<?php echo $category['master'];?>)</small><span class='pull-right'><a href="<?php echo site_url('/topic/add/'.$category['node_id']);?>" class="label label-success">快速发表</a></span></h3>
                    </div>
                    <div class="panel-body">
	                    <?php if($topic_list):?>
                        <ul class="media-list">
							<?php foreach($topic_list as $v):?>
                            <li class="media topic-list">
                                <a class="media-left" href="<?php echo site_url('user/profile/'.$v['uid']);?>"><img class="img-rounded medium" src="<?php echo base_url($v['avatar'].'normal.png');?>" alt="<?php echo $v['username'];?>"></a>
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
                        <nav>
                        <?php if($pagination):?><ul class="pager"><?php echo $pagination;?></ul><?php endif?></nav>
						<?php else:?>
						暂无话题
						<?php endif?>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

            <div class="col-md-4">
			<?php $this->load->view('common/sidebar_login');?>
			<?php $this->load->view('common/sidebar_cates');?>
			<?php $this->load->view('common/sidebar_ad');?>
            </div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer');?>
</body>
</html>