<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?>- <?php echo $settings['site_name']?></title>
<meta name="keywords" content="<?php echo $title?>" />
<meta name="description" content="<?php echo $category['content'];?>" />
<?php $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('common/header');?>

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
<?php echo $category['listnum'];?>
&nbsp;
</div>
</div>
<a href="/" class="startbbs"><?php echo $settings['site_name']?></a> <span class="chevron">&nbsp;›&nbsp;</span> <?php echo $category['cname'];?>
</div>
<div class='cell'>
<?php echo $category['content'];?>
</div>
</div>

<div class='box'>
<div class='box-header'>
<span>最新话题 (<span>版主:<?php echo $category['master'];?></span>)</span>
<span class='pull-right'>
<a href="<?php echo site_url('/topic/add/'.$category['node_id']);?>" class="btn btn-success btn-sm">快速发表</a>
</span>
</div>
<?php if($list){?>
<?php foreach ($list as $v) {?>
<div class='admin cell topic'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td class='avatar' valign='top'>
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" class="profile_link" title="<?php echo $v['username'];?>">
<?php if($v['avatar']) {?>
<img alt="<?php echo $v['username'];?> medium avatar" class="medium_avatar" src="<?php echo base_url();?><?php echo $v['avatar'];?>" />
<?php } else {?>
<img alt="<?php echo $v['username'];?> medium avatar" class="medium_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>" />
<?php }?>
</a>
</td>
<td style='padding-left: 12px' valign='top'>
<div class='pull-right'>
<div class='badge badge-info'><a href="<?php echo url('topic_show',$v['topic_id']).'#reply';?>"><?php echo $v['comments']?></a></div>
</div>
<div class='sep3'></div>
<h2 class='topic_title'>
<a href="<?php echo url('topic_show',$v['topic_id']);?>" class="startbbs topic"><?php echo sb_substr($v['title'],30);?></a>
<?php if( $v['is_top'] == '1' ) echo '<span class="label label-info">置顶</span>'; ?>
</h2>
<div class='topic-meta'>
<a href="<?php echo url('node_show',$v['node_id']);?>" class="node"><?php echo $category['cname'];?></a>
&nbsp;&nbsp;•&nbsp;&nbsp;
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" class="dark startbbs profile_link" title="<?php echo $v['username'];?>"><?php echo $v['username'];?></a>
&nbsp;&nbsp;•&nbsp;&nbsp;
<?php echo $this->myclass->friendly_date($v['addtime']);?>
&nbsp;&nbsp;•&nbsp;&nbsp;
最后回复来自
<a href="<?php echo site_url('user/profile/'.$v['ruid']);?>" class="startbbs profile_link" title="agred"><?php echo $v['rname'];?></a>
</div>
</td>
</tr>
</table>
</div>
<?php } ?>
<?php } else{?>
<div class='cell topic'>
暂无话题, 请发表话题！
</div>
<?php } ?>

<div class='inner'>
<?php if($pagination){?>
<ul class='pager'>
<li>
<?php echo $pagination?>
<!--<span class='gray'></span>-->
</li>
<li class='next'>
<!--<a href="/go/noticeboard?p=2">下一页 →</a>-->
</li>
</ul>
<?php }?>
</div>

</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('common/sidebar_login');?>
<?php $this->load->view('common/sidebar_cates');?>
<?php $this->load->view('common/sidebar_ad');?>

</div>
</div></div></div>

<?php $this->load->view('common/footer');?>
</body>
</html>