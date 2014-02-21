<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view ('header-meta');?>
</head>

<body id="startbbs">
<a id="top" name="top"></a>
<?php $this->load->view ('header'); ?>

<div id="wrap">
<div class="container" id="page-main">
<div class="row">
<div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box'>
<div class='box-header'>
我关注的会员
</div>
<div class='inner'>
<ul class='thumbnails row'>
<?php if(isset($follow_list)){?>
<?php foreach($follow_list as $v){?>
<li class="col-xs-5 col-md-2">
<div class='thumbnail1'>
<a href="<?php echo site_url('user/info/'.$v['follow_uid']);?>" title="<?php echo $v['username']?>">
<?php if($v['avatar']){?>
<img alt="<?php echo $v['username']?> large avatar" class="large_avatar" src="<?php echo base_url($v['avatar'])?>" />
<?php } else{?>
<img alt="<?php echo $v['username']?> large avatar" class="large_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>" />
<?php }?>
</a></div>
<div class='sep5'></div>
<div class='caption center'>
<?php echo $v['username']?>
</div>
</li>
<?php }}else{?>
暂无关注会员
<?php }?>
</ul>
</div>
</div>

<div class='box'>
<div class='box-header'>
关注会员的话题
</div>
<?php if(isset($follow_user_forums)){?>
<?php foreach($follow_user_forums as $v){?>
<div class='admin cell topic'>
<div class='avatar pull-left'>
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="profile_link" title="<?php echo $v['username'];?>">
<?php if($v['avatar']) {?>
<img alt="<?php echo $v['username'];?> medium avatar" class="medium_avatar" src="<?php echo base_url($v['avatar']);?>" />
<?php } else {?>
<img alt="<?php echo $v['username'];?> medium avatar" class="medium_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>" />
<?php }?>
</a>
</div>
<div class='item_title'>
<div class='pull-right'>
<div class='badge badge-info'><?php echo $v['comments'];?></div>
</div>
<h2 class='topic_title'>
<a href="<?php echo site_url('forum/view/'.$v['fid']);?>" class="startbbs topic"><?php echo $v['title'];?></a>
</h2>
<div class='topic-meta'>
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="dark startbbs profile_link" title="<?php echo $v['username'];?>"><?php echo $v['username'];?></a>
<span class='text-muted'>•</span>
<?php echo $this->myclass->friendly_date($v['updatetime']);?>
<span class='text-muted'>•</span>
最后回复来自
<a href="<?php echo site_url('user/info/'.$v['ruid']);?>" class="startbbs profile_link" title="doudou"><?php echo $v['rname'];?></a>
</div>
</div>
</div>
<?php }?>
<?php } else{?>
<div class='cell'>暂无提醒</div>
<?php }?>
</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('block/right_login');?>

<?php $this->load->view('block/right_ad');?>




</div>
</div></div></div>
<?php $this->load->view ('footer'); ?>