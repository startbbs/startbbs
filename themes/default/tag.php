<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title;?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view ('header-meta');?>
</head>

<body id="startbbs">
<a id="top" name="top"></a>
<?php $this->load->view ('header'); ?>

<div id="wrap">
<div class="container" id="page-main">
<div class="row">
<div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box fix_cell'>
<div class='cell'><a href="<?php echo site_url()?>" class="startbbs"><?php echo $settings['site_name']?></a> <span class="chevron">&nbsp;›&nbsp;</span>标签: #<?php echo $title;?> (<?php echo $tag['forums'];?>)</div>
<?php if(isset($tag_list)){?>
<?php foreach($tag_list as $v){?>
<div class='admin cell topic'>
<div class='avatar pull-left'>
<?php if($v['avatar']) {?>
<a href="/member/admin" class="profile_link" title="<?php echo $v['username'];?>"><img alt="<?php echo $v['username'];?> medium avatar" class="medium_avatar" src="<?php echo base_url();?><?php echo $v['avatar'];?>" /></a>
<?php } else {?>
<a href="/member/admin" class="profile_link" title="<?php echo $v['username'];?>"><img alt="<?php echo $v['username'];?> medium avatar" class="medium_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>" /></a>
<?php }?>
</div>
<div class='item_title'>
<div class='pull-right'>
<div class='badge badge-info'><?php echo $v['comments']?></div>
</div>
<h2 class='topic_title'>
<a href="<?php echo site_url($v['view_url']);?>" class="startbbs topic"><?php echo sb_substr($v['title'],30);?></a>
</h2>
<div class='topic-meta'>
<!--<a href="<?php echo site_url('forum/flist/'.$v['cid']);?>" class="node"><?=$category['cname'];?></a>-->
<span class='text-muted'>•</span>
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="dark startbbs profile_link" title="<?php echo $v['username'];?>"><?php echo $v['username'];?></a>
<span class='text-muted'>•</span>
<?php echo $this->myclass->friendly_date($v['updatetime']);?>
<span class='text-muted'>•</span>
最后回复来自
<a href="" class="startbbs profile_link" title=""></a>
</div>
</div>
</div>
<?php }?>
<?php } else{?>
<div class='cell topic'>
暂无收藏话题
</div>
<?php } ?>


<div class='inner'>
<ul class='pager'>
<li class='center'>
<?php echo $pagination;?>
<!--<span class='gray'></span>-->
</li>
<!--<li class='next'>
<a href="/go/noticeboard?p=2">下一页 →</a>
</li>-->
</ul>
</div>
</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('block/right_login');?>

<?php $this->load->view('block/right_ad');?>




</div>
</div></div></div>
<?php $this->load->view ('footer'); ?>