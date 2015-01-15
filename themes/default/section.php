<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $title?> - ' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?>- <?php echo $settings['site_name']?></title>
<?php $this->load->view ('header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view ('header');?>

<div id="wrap">
<div class="container" id="page-main">
<div class="row">
<div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box'>
<div class='box-header'>
<div class='pull-right'>
话题总数
<div class='badge badge-info'>
&nbsp;
<?php echo $total_forums;?>
&nbsp;
</div>
</div>
<a href="<?php echo site_url()?>" class="startbbs"><?php echo $settings['site_name']?></a>
</div>
<div class='cell'>
<?php echo $settings['site_description']?>
</div>
</div>

<?php if($catelist[0]){?>
<?php if(count($catelist)==1){?>
	<div class='box'>
	<div class='box-header'>
	所有结点
	<div class='fr'>
	<!--888-->
	</div>
	</div>
	<?php foreach ($catelist[0] as $k=>$v) {?>
	<div class='admin cell topic'>
	<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
	<td class='avatar' valign='top'>
	<a href="<?php echo site_url($v['flist_url']);?>" class="profile_link" title="<?php echo $v['cname'];?>">
	<?php if($v['ico']){?>
	<img alt="<?php echo $v['cname'];?> medium avatar" class="medium_avatar" src="<?php echo base_url($v['ico'])?>" />
	<?php } else {?>
	<img alt="<?php echo $v['cname'];?> medium avatar" class="medium_avatar" src="<?php echo base_url('static/common/images/section.png')?>" />
	<?php }?>
	</a>
	</td>
	<td style='padding-left: 12px' valign='top' width="50%">
	<div class='sep3'></div>
	<h2 class='topic_title'>
	<a href="<?php echo site_url($v['flist_url']);?>" class="startbbs topic"><?php echo $v['cname'];?></a>
	</h2>
	<div class='topic-meta'>
	<?php echo $v['content'];?>
	</div>
	<div class='topic-bottom'>
	版主:<?php echo $v['master'];?>
	</div>
	</td>
	<td style='padding-left: 12px;text-align:right;' valign='top' width="15%">
	<div class='sep3'></div>
	<?php foreach($today_forums[$v['cid']] as $t){?>
	<div><?php echo @$t?>/今日</div>
	<?php }?>
	<div><?php echo $v['listnum'];?>/话题</div>
	</td>
	<td style='padding-left: 12px' valign='top' width="25%">
	<div class='sep3'></div>
	<?php if(@$new_forum[$v['cid']]){?>
	<?php foreach(@$new_forum[$v['cid']] as $f){?>
	<div><a href="<?php echo site_url('forum/view/'.$f['fid']);?>" class="startbbs topic"><?php echo sb_substr($f['title'],8);?></a></div>
	<div>by <a href="<?php echo site_url('user/info/'.$f['uid']);?>" class="dark startbbs profile_link" title="<?php echo $f['username'];?>"><?php echo $f['username'];?></a></div>
	<div><?php echo $this->myclass->friendly_date($f['updatetime']);?></div>
	<?php }?>
	<?php } else{?>
	<div>暂无话题</div>
	<?php }?>
	</td>
	</tr>
	</table>
	</div>
	<?php } ?>
	</div>
	
<?php }?>
<?php if(count($catelist)>1){?>
	<?php foreach ($catelist[0] as $v) {?>
	<div class='box'>
	<div class='box-header'>
	<?php echo $v['cname'];?>
	<div class='fr'>
	<!--888-->
	</div>
	</div>

	<?php if(isset($catelist[$v['cid']])){?>
	<?php foreach ($catelist[$v['cid']] as $k=>$c) {?>
	<div class='admin cell topic'>
	<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
	<td class='avatar' valign='top'>
	<a href="<?php echo site_url($c['flist_url']);?>" class="profile_link" title="<?php echo $c['cname'];?>">
	<?php if($c['ico']){?>
	<img alt="<?php echo $c['cname'];?> medium avatar" class="medium_avatar" src="<?php echo base_url($c['ico'])?>" />
	<?php } else {?>
	<img alt="<?php echo $c['cname'];?> medium avatar" class="medium_avatar" src="<?php echo base_url('static/common/images/section.png')?>" />
	<?php }?>
	</a>
	</td>
	<td style='padding-left: 12px' valign='top' width="50%">
	<div class='sep3'></div>
	<h2 class='topic_title'>
	<a href="<?php echo site_url($c['flist_url']);?>" class="startbbs topic"><?php echo $c['cname'];?></a>
	</h2>
	<div class='topic-meta'>
	<?php echo $c['content'];?>
	</div>
	<div class='topic-bottom'>
	版主:<?php echo $c['master'];?>
	</div>
	</td>
	<td style='padding-left: 12px;text-align:right;' valign='top' width="15%">
	<div class='sep3'></div>
	<?php foreach($today_forums[$c['cid']] as $t){?>
	<div><?php echo @$t?>/今日</div>
	<?php }?>
	<div><?php echo $c['listnum'];?>/话题</div>
	</td>
	<td style='padding-left: 12px' valign='top' width="25%">
	<div class='sep3'></div>
	<?php if(@$new_forum[$c['cid']]){?>
	<?php foreach(@$new_forum[$c['cid']] as $f){?>
	<div><a href="<?php echo site_url('forum/view/'.$f['fid']);?>" class="startbbs topic"><?php echo sb_substr($f['title'],8);?></a></div>
	<div>by <a href="<?php echo site_url('user/info/'.$f['uid']);?>" class="dark startbbs profile_link" title="<?php echo $f['username'];?>"><?php echo $f['username'];?></a></div>
	<div><?php echo $this->myclass->friendly_date($f['updatetime']);?></div>
	<?php }?>
	<?php } else{?>
	<div>暂无话题</div>
	<?php }?>
	</td>
	</tr>
	</table>
	</div>
	<?php } ?>
	<?php } else{?>
	<div class='cell topic'>
	暂二级节点, 请到后台设定节点！
	</div>
	<?php } ?>
	</div>

	<?php } ?>
<?php }?>
<?php } else{?>
<div class='cell topic'>
暂无节点, 请到后台设定节点！
</div>
<?php }?>



<!--<div class='box'>
<div class='box-header'>
创建新话题
</div>
<div class='inner'>

</div>
</div>-->

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('block/right_login');?>
<?php $this->load->view('block/right_new_users');?>
<?php $this->load->view('block/right_new_forums');?>
<?php $this->load->view('block/right_ad');?>

</div>
</div></div></div>

<?php $this->load->view ('footer'); ?>