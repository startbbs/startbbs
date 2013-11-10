<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $settings['site_name']?> - <?php echo $settings['short_intro']?></title>
<meta name="keywords" content="<?php echo $settings['site_keywords']?>" />
<meta name="description" content="<?php echo $settings['short_intro']?>" />
<?php $this->load->view('header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('header');?>
<div id="wrap">
<div class="container" id="page-main">
<div class="row-fluid"><div class='span8'>

<div class='box' id='topics_index'>
<div align='left' class='cell'>
<div class='pull-right marketing'>
<span class='gray' style='font-size: 110%'>
<span class="snow"><?php echo $settings['site_keywords']?></span></span>
</div>
<div class='bigger welcome'><?php echo $settings['welcome_tip']?></div>
<?php if(!$this->session->userdata('uid')){?>
<div class='sep10'></div>
<div class="hero-unit"><h1><?php echo $settings['site_name']?></h1><p><?php echo $settings['short_intro']?></p></div>
<?php }?>
</div>
<span id="infolist">
<?php if($list){?>
<?php foreach ($list as $v){?>
<div class='cell topic'>
<div class='avatar pull-left'>
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="profile_link" title="<?php echo $v['username']?>">
<?php if($v['avatar']){?>
<img alt="<?php echo $v['username']?> medium avatar" class="medium_avatar" src="<?php echo base_url();?>/<?php echo $v['avatar'];?>"/>
<?php } else{?>
<img alt="<?php echo $v['username']?> medium avatar" class="medium_avatar" src="uploads/avatar/default.jpg" />
<?php }?>
</a>
</div>
<div class='item_title'>
<div class='pull-right'>
<div class='badge badge-info'><a href="<?php echo site_url($v['view_url'].'#reply');?>"><?php echo $v['comments']?></a></div>
</div>
<h2 class='topic_title'>
<a href="<?php echo site_url($v['view_url']);?>" class="startbbs topic"><?php echo sb_substr($v['title'],30);?></a>
<?php if( $v['is_top'] == '1' ) echo '<span class="badge badge-info">置顶</span>'; ?>
</h2>
<div class='topic-meta'>
<a href="<?php echo site_url($v['flist_url']);?>" class="node"><?php echo $v['cname']?></a>
<span class='muted'>•</span>
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="dark startbbs profile_link" title="<?php echo $v['username']?>"><?php echo $v['username']?></a>
<span class='muted'>•</span>
<?php echo $this->myclass->friendly_date($v['updatetime'])?>
<span class='muted'>•</span>
<?php if($v['rname']){?>
最后回复来自
<a href="<?php echo site_url('user/info/'.$v['ruid']);?>" class="startbbs profile_link" title="<?php echo $v['rname']?>"><?php echo $v['rname']?></a>
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
				$.get('home/getmore/'+page,function(data){
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
	<div class="cell">
	<?php foreach ($catelist[0] as $v){?>
	<?php if(@$catelist[$v['cid']]){?>
	<dl class="dl-horizontal" style="margin:5px">
        <dt class="span2 muted"><?php echo $v['cname']?></dt>
        <dd class="span10">
        <?php foreach($catelist[$v['cid']] as $c){?>
			<a href="<?php echo site_url($c['flist_url']);?>" class="startbbs item_node"><?php echo $c['cname']?></a>
		<?php }?>
        </dd>
	</dl>
	<?php } else {?>
		<a href="<?php echo site_url($v['flist_url']);?>" class="startbbs item_node"><?php echo $v['cname']?></a>
	<?php }?>
<?php }?>
	</div>
<?php }?>

</div>


</div>
<div class='span4' id='Rightbar'>
<?php $this->load->view('block/right_login');?>
<?php $this->load->view('block/right_tags');?>

<div class='box'>
<div class='box-header'>
社区运行状态
</div>
<div class='inner'>
<table border='0' cellpadding='3' cellspacing='0' width='100%'>
<?php if($total_users>0){?>
<tr>
<td align='right' width='60'>
<span class='gray'>最新会员</span>
</td>
<td align='left'>
<strong><?php echo $last_user['username']?></strong>
</td>
</tr>
<?php }?>
<tr>
<td align='right' width='60'>
<span class='gray'>注册会员</span>
</td>
<td align='left'>
<strong><?php echo $total_users?></strong>
</td>
</tr>
<tr>
<td align='right' width='60'>
<span class='gray'>今日话题</span>
</td>
<td align='left'>
<strong><?php echo $today_forums;?></strong>
</td>
</tr>
<tr>
<td align='right' width='60'>
<span class='gray'>话题总数</span>
</td>
<td align='left'>
<strong><?php echo $total_forums?></strong>
</td>
</tr>

<tr>
<td align='right' width='50'>
<span class='gray'>回复数</span>
</td>
<td align='left'>
<strong><?php echo $total_comments?></strong>
</td>
</tr>
</table>
</div>
</div>

<?php $this->load->view('block/right_ad');?>

<div class='box'>
<div class='box-header'>
友情链接
</div>
<div class='inner'>
<ul class="unstyled">
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