<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $username?> - <?php echo $settings['site_name']?>' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $username?> - <?php echo $settings['site_name']?></title>
<?php echo $this->load->view('header-meta')?>
</head>
<body id="startbbs">
<?php echo $this->load->view('header')?>
<div id="wrap">
<div class="container" id="page-main">
<div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>
<div class='box'>
<div class='cell'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td align='center' valign='top' width='73'>
<?php if($avatar){?>
<img alt="<?php echo $username?> large avatar" class="large_avatar" style="width:72px; height:72px;" src="<?php echo base_url($big_avatar)?>"/>
<?php } else{?>
<img alt="<?php echo $username?> large avatar" class="large_avatar" style="width:72px; height:72px;" src="<?php echo base_url('uploads/avatar/default.jpg')?>"/>
<?php }?>
</td>
<td valign='top' width='10'></td>
<td align='left' valign='top' width='auto'>
<div class='pull-right'>
<div class='sep3'></div>
<?php if($this->session->userdata('uid')){?>
<?php if(!$is_followed){?>
<a href="<?php echo site_url('follow/add/'.$uid);?>" class="btn btn-info btn-sm" data-method="post" rel="nofollow">加入特别关注</a>
<?php }else{?>
<a href="<?php echo site_url('follow/cancel/'.$uid);?>" class="btn btn-sm btn-warning" data-method="post" rel="nofollow">取消特别关注</a>
<?php }?>
<?php }?>
</div>
<h2 style='padding: 0px; margin: 0px; font-size: 22px; line-height: 22px;'>
<?php echo $username?>
</h2>
<div class='sep5'></div>
<!--<span class='gray bigger'><?php echo $signature?></span>-->
<div class='sep5'></div>
<span class='snow'>
<?php echo $username?>
第
<?php echo $uid?>
号会员, 加入于
<?php echo $this->myclass->friendly_date($regtime)?>
</span>
<div class='sep10'></div>
<table border='0' cellpadding='2' cellspacing='0' width='100%'>
<tr>
<td width='50%'>
<span style='line-height: 16px;'>
签名:
&nbsp;
<?php echo $signature?>
</span>
</td>
</tr>
<tr>
<td width='50%'>
<span style='line-height: 16px;'>
个人主页
&nbsp;
<a href="<?php echo $homepage?>" class="startbbs" rel="nofollow external" target="_blank"><?php echo $homepage?></a>
</span>
</td>
</tr>
<tr>
<td width='50%'>
<span style='line-height: 16px;'>
所在地:
&nbsp;
<a href="http://www.google.com/maps?q=<?php echo $location?>" class="startbbs" rel="nofollow external" target="_blank"><?php echo $location?></a>
</span>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
<div class='inner'><p><?php echo $introduction?></p><!--<p>联系方式: <a href="mailto:" class="external mail"></a></p>--></div>
</div>
<div class='box'>
<div class='box-header'>
<?php echo $username?>
最近创建的话题
</div>
<?php foreach($user_posts as $v){?>
<div class='admin cell topic'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td valign='middle' width='auto'>
<span class='bigger'>
<a href="<?php echo site_url('forum/view/'.$v['fid']);?>" class="startbbs topic"><?php echo $v['title']?></a>
</span>
<div class='topic-meta'>
<a href="<?php echo site_url('forum/flist/'.$v['cid']);?>" class="node"><?php echo $v['cname']?></a>
&nbsp;&nbsp;•&nbsp;&nbsp;
<?php echo $this->myclass->friendly_date($v['addtime'])?>
&nbsp;&nbsp;•&nbsp;&nbsp;
最后回复来自
<a href="<?php echo site_url('user/info/'.$v['ruid']);?>" class="startbbs profile_link" title="marschris"><?php echo $v['rname']?></a>
</div>
</td>
<td align='right' valign='middle' width='40'>
<div class='badge badge-info'><?php echo $v['comments']?></div>
</td>
</tr>
</table>
</div>
<?php } ?>

<!--<div class='inner'>
<span class='chevron'>»</span>
<small><a href="/member/admin/topics" class="startbbs"><?php echo $username?> 创建的更多主题</a></small>
</div>-->
</div>
<div class='box'>
<div class='box-header'>
<?php echo $username?>
最近的回复
</div>
<?php foreach($user_comments as $v){?>
<div class='cell comment_header text-muted'>
<div class='pull-right timeago'>
<?php echo $this->myclass->friendly_date($v['replytime'])?>
</div>
回复了
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="startbbs profile_link" title="<?php echo $v['username']?>"><?php echo $v['username']?></a>
<?php echo $this->myclass->friendly_date($v['addtime'])?>
<span class='chevron'>›</span>
<a href="<?php echo site_url('forum/view/'.$v['fid']);?>" class="startbbs"><?php echo $v['title']?></a>
</div>
<div class='inner'>
<div class='reply_content'>
<?php echo $v['content']?>
</div>
</div>
<div class='sep5'></div>
<?php } ?>

</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('/block/right_login')?>

<!--<div class='box'>
<div class='box-header'>
关注daqing的人
<span class='gray'>(31)</span>
</div>
<div class='inner'>
<a href="/member/lihuanchun" class="profile_link" title="lihuanchun"><img alt="lihuanchun mini avatar" class="mini_avatar" src="/uploads/user_avatar/1/401/mini_8bec70c1f03.jpg" /></a>
<a href="/member/chopin" class="profile_link" title="chopin"><img alt="chopin mini avatar" class="mini_avatar" src="/avatar/mini_default.png" /></a>
<a href="/member/deeme" class="profile_link" title="deeme"><img alt="deeme mini avatar" class="mini_avatar" src="/avatar/mini_default.png" /></a>
<a href="/member/coon" class="profile_link" title="coon"><img alt="coon mini avatar" class="mini_avatar" src="/uploads/user_avatar/81/381/mini_310f8d895cf.png" /></a>
<a href="/member/leegang" class="profile_link" title="leegang"><img alt="leegang mini avatar" class="mini_avatar" src="/uploads/user_avatar/76/376/mini_06cc6e065ee.png" /></a>
<a href="/member/asdf01" class="profile_link" title="asdf01"><img alt="asdf01 mini avatar" class="mini_avatar" src="/uploads/user_avatar/78/278/mini_f9fb61a3196.jpg" /></a>
<a href="/member/doudou" class="profile_link" title="doudou"><img alt="doudou mini avatar" class="mini_avatar" src="/avatar/mini_default.png" /></a>
<a href="/member/4pple" class="profile_link" title="4pple"><img alt="4pple mini avatar" class="mini_avatar" src="/uploads/user_avatar/10/310/mini_6e3738054bc.jpg" /></a>
<a href="/member/xiao" class="profile_link" title="xiao"><img alt="xiao mini avatar" class="mini_avatar" src="/uploads/user_avatar/22/222/mini_0385535bc98.jpg" /></a>
<a href="/member/kandiyoki" class="profile_link" title="kandiyoki"><img alt="kandiyoki mini avatar" class="mini_avatar" src="/uploads/user_avatar/88/288/mini_267adc19f9e.jpg" /></a>
</div>
</div>-->


<?php $this->load->view('block/right_ad');?>

</div>
</div></div></div>
<?php $this->load->view('footer');?>