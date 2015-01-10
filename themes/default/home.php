<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $settings['site_name']?> - <?php echo $settings['short_intro']?></title>
<meta name="keywords" content="<?php echo $settings['site_keywords']?>" />
<meta name="description" content="<?php echo $settings['short_intro']?>" />
<?php $this->load->view('common/header-meta');?>
</head>
<body>
<?php $this->load->view('common/header');?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $settings['welcome_tip']?></h3>
                    </div>
                    <div class="panel-body">
	                    <?php if($topic_list):?>
                        <ul class="media-list" id="topic_list">
							<?php foreach ($topic_list as $v):?>
                            <li class="media topic-list">
                                <div class="pull-right">
                                    <span class="badge badge-info topic-comment"><a href="<?php echo url('topic_show',$v['topic_id']).'#reply';?>"><?php echo $v['comments'] ;?></a></span>
                                </div>
                                <a class="media-left" href="<?php echo site_url('user/profile/'.$v['uid']);?>"><img class="img-rounded medium" src="<?php echo base_url($v['avatar'].'normal.png');?>" alt="<?php echo $v['username']?> medium avatar"></a>
                                <div class="media-body">
                                    <h2 class="media-heading topic-list-heading"><a href="<?php echo url('topic_show',$v['topic_id']);?>"><?php echo $v['title'];?></a><?php if( $v['is_top'] == '1' ) echo '<span class="badge badge-info">置顶</span>'; ?></h2>
                                    <p class="text-muted">
                                        <span><a href="<?php echo url('node_show',$v['node_id']);?>"><?php echo $v['cname']?></a></span>&nbsp;•&nbsp;
                                        <span><a href="<?php echo site_url('user/profile/'.$v['uid']);?>"><?php echo $v['username'];?></a></span>&nbsp;•&nbsp;
                                        <span><?php echo friendly_date($v['updatetime'])?></span>&nbsp;•&nbsp;
                                        <?php if ($v['rname']!=NULL) : ?>
                                            <span>最后回复来自 <a href="<?php echo site_url('user/profile/'.$v['ruid']);?>"><?php echo $v['rname']; ?></a></span>
                                        <?php else : ?>
                                            <span>暂无回复</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                        <?php else : ?>
                        暂无话题
                        <?php endif;?>
                    </div>
                     <div class="panel-footer"><a href="javascript:void(0)" id="getmore" class="startbbs">更多新主题</a></div>
                </div><!-- /.topic list -->
                
            </div><!-- /.col-md-8 -->

			<div class="col-md-4">
				<?php $this->load->view('common/sidebar_login');?>
				<?php $this->load->view('common/sidebar_cates');?>

				 <div class="panel panel-default">
				    <div class="panel-heading">
				        <h3 class="panel-title">社区统计</h3>
				    </div>
				    <div class="panel-body">
				        <ul class="list-unstyled">
				            <li>最新会员：<?php echo $stats['last_username']?></li>
				            <li>注册会员： <?php echo $stats['total_users']?></li>
				            <li>今日话题： <?php echo $stats['today_topics'];?></li>
				            <li>昨日话题： <?php echo $stats['yesterday_topics'];?></li>
				            <li>话题总数： <?php echo $stats['total_topics']?></li>
				            <li>回复数： <?php echo $stats['total_comments']?></li>
				        </ul>
				    </div>
				</div> 


				<?php $this->load->view('common/sidebar_ad');?>
				 <div class="panel panel-default">
				    <div class="panel-heading">
				        <h3 class="panel-title">友情链接</h3>
				    </div>
				    <div class="panel-body">
				        <ul class="list-unstyled">
					        <li style="width:0; height:0; overflow:hidden;"><a href="http://www.startbbs.com" target="_blank">StartBBS</a></li>
							<?php if($links){?>
							<?php foreach($links as $v){?>
							<?php if($v['is_hidden']==0){?>
				            <li><a href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['name'];?></a></li>
							<?php } else {?>
							<li>暂无链接</li>
							<?php } ?>
							<?php }?>
							<?php } else {?>
							<li>暂无链接</li>
							<?php }?>
				        </ul>
				    </div>
				</div>
			</div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer');?>
<script>
$(function() {
	var page=2;
			$("#getmore").click(function() {
				var data;
				$.get('<?php echo site_url();?>/home/getmore/'+page,function(data){
				page++;
				$("#topic_list").append(data);
				});
				//$("#infolist").after(tr);
			});
		});
		
</script>

</body>
</html>