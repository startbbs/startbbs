<!DOCTYPE html>
<html>
	<head>
<meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title;?> - <?php echo $settings['site_name']?></title>
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
                        <h3 class="panel-title">搜索: <span class="red">#<?php echo $keyword;?></span> (<?php echo $topic_num;?>)</h3>
                    </div>
                    <div class="panel-body">
	                    <?php if($search_list):?>
                        <ul class="media-list">
							<?php foreach($search_list as $v):?>
                            <li class="media">
	                            <div class="pull-right">
                                    <span class="badge badge-info topic-comment"><?php echo $v['comments']?></span>
                                </div>
                               
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="<?php echo url('topic_show',$v['topic_id']);?>"><?php echo highlight_phrase($v['title'],$keyword,'<span class=red>','</span>');?></a>&nbsp;<span class="text-muted"><?php echo friendly_date($v['updatetime'])?></span></h4>
                                </div>

                            </li>
						<?php endforeach;?>
                        </ul>
                        <?php if($pagination):?><ul class="pagination"><?php echo $pagination;?></ul><?php endif?>
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

<?php $this->load->view('common/footer'); ?>
</body>
</html>