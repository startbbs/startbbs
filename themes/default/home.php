<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $settings['site_name']?> - <?php echo $settings['short_intro']?></title>
<meta name="keywords" content="<?php echo $settings['site_keywords']?>" />
<meta name="description" content="<?php echo $settings['short_intro']?>" />
<?php $this->load->view('header-meta');?>
</head>
<body>
<?php $this->load->view('header');?>
<div id="wrap">
<div class="container" id="page-main">
<div class="row">

<div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box' id='topics_index'>
<div align='left' class='cell'>
<div class='pull-right marketing'>
<span class='gray' style='font-size: 110%'>
<span class="snow"><?php echo $settings['site_keywords']?></span></span>
</div>
<div class='bigger welcome'><?php echo $settings['welcome_tip']?></div>

</div>
<span id="infolist">
<?php if($list){?>
<?php foreach ($list as $v){?>
<div class='cell topic'>
<div class='avatar pull-left'>
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" class="profile_link" title="<?php echo $v['username']?>">
<?php if($v['avatar']){?>
<img alt="<?php echo $v['username']?> medium avatar" class="medium_avatar" src="<?php echo base_url($v['avatar']);?>"/>
<?php } else{?>
<img alt="<?php echo $v['username']?> medium avatar" class="medium_avatar" src="uploads/avatar/default.jpg" />
<?php }?>
</a>
</div>
<div class='item_title'>
<div class='pull-right'>
<div class='badge badge-info'><a href="<?php echo url('topic_show',$v['topic_id']).'#reply';?>"><?php echo $v['comments']?></a></div>
</div>
<h3 class='topic_title'>
<a href="<?php echo url('topic_show',$v['topic_id']);?>" class="startbbs topic"><?php echo sb_substr($v['title'],30);?></a>
<?php if( $v['is_top'] == '1' ) echo '<span class="badge badge-info">置顶</span>'; ?>
</h3>
<div class='topic-meta'>
<a href="<?php echo url('node_show',$v['node_id']);?>" class="node"><?php echo $v['cname']?></a>
<span class='text-muted'>•</span>
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" class="dark startbbs profile_link" title="<?php echo $v['username']?>"><?php echo $v['username']?></a>
<span class='text-muted'>•</span>
<?php echo $this->myclass->friendly_date($v['updatetime'])?>
<span class='text-muted'>•</span>
<?php if($v['rname']){?>
最后回复来自
<a href="<?php echo site_url('user/profile/'.$v['ruid']);?>" class="startbbs profile_link" title="<?php echo $v['rname']?>"><?php echo $v['rname']?></a>
<?php } else {?>
暂无回复
<?php }?>
</div>
</div>
</div>
<?php } ?>
<?php } else {?>
<div class='cell topic'>
暂无话题, 请发表话题！
</div>
<?php } ?>

</span><!--infolist-->

<div class='inner'>
<div class='pull-right'><img align="absmiddle" alt="Rss" src="<?php echo base_url('static/common/images/rss.png');?>" />
<a href="<?php echo site_url('feed/')?>" class="dark" target="_blank">RSS</a>
</div>
&nbsp;
<span class='chevron'>»</span>
<a href="javascript:void(0)" id="getmore" class="startbbs">更多新主题</a>
</div>
</div>
<script>
//$(function(){
//	var page=1;
//	$('#getmore').live('click',function(){
//		$.get('/home/getmore/'+page,function(data){
//			page++;
//			$('#infolist').append(data);
//		});
//	});
//});

$(function() {
	var page=2;
			$("#getmore").click(function() {
				var data;
				$.get('<?php echo site_url();?>/home/getmore/'+page,function(data){
				page++;
				$("#infolist").append(data);
				});
				//$("#infolist").after(tr);
			});
		});
		
</script>


<div class="box">
<div class='box-header'>
		话题节点
	</div>
<?php if($catelist[0]){?>
	<div class="inner">
	<?php foreach ($catelist[0] as $v){?>
	<?php if(@$catelist[$v['node_id']]){?>

	<ul class="list-inline">
		<li class="test-muted"><?php echo $v['cname']?></li>
		<?php foreach(@$catelist[$v['node_id']] as $c){?>
  		<li class="btn btn-default"><a href="<?php echo url('node_show',$c['node_id']);?>" class="startbbs"><?php echo $c['cname']?></a></li>
  		<?php }?>
	</ul>
	<?php } else {?>
	<ul class="list-inline">
		<?php foreach((array)@$catelist[$v['node_id']] as $c){?>
  		<li class="tags"><a href="<?php echo url('node_show',$c['node_id']);?>" class="startbbs btn btn-default"><?php echo $v['cname']?></a></li>
  		<?php }?>
	</ul>
	<?php }?>
<?php }?>
	</div>
<?php }?>

</div>


</div>

<div class='col-xs-12 col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('common/sidebar_login');?>
<?php $this->load->view('common/sidebar_tags');?>

 <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">社区统计</h3>
    </div>
    <div class="panel-body">
        <ul class="list-unstyled statistics">
	        <?php if($total_users>0){?>
            <li>最新会员：<?php echo $last_user['username']?></li>
            <?php }?>
            <li>注册会员： <?php echo $total_users?></li>
            <li>今日话题： <?php echo $today_topics;?></li>
            <li>话题总数： <?php echo $total_topics?></li>
            <li>回复数： <?php echo $total_comments?></li>
        </ul>
    </div>
</div> 


<?php $this->load->view('common/sidebar_ad');?>
 <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">友情链接</h3>
    </div>
    <div class="panel-body">
        <ul class="list-unstyled statistics">
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


</div>
</div></div></div>
<?php $this->load->view('footer');?>