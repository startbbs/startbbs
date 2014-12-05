<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $title?> - ' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?>- <?php echo $settings['site_name']?></title>
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
最新会员
<div class='pull-right'>
<!--888-->
</div>
</div>

<div class="cell">
<ul class='user_list'>
<?php if($new_users) foreach($new_users as $v){?>
<li>
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" title="<?php echo $v['username'];?>">
<img src="<?php echo base_url($v['avatar'].'normal.png');?>" alt="<?php echo $v['username'];?>">
</a>
</li>
<?php }?>
</ul>
</div>

</div>

<div class='box'>
<div class='box-header'>
活跃会员
<div class='pull-right'>
<!--888-->
</div>
</div>

<div class="cell">
<ul class='inline user_list'>
<?php if($hot_users) foreach($hot_users as $v){?>
<li>
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" title="<?php echo $v['username'];?>">
<img src="<?php echo base_url($v['avatar'].'normal.png');?>" alt="<?php echo $v['username'];?>">
</a>
</li>
<?php }?>
</ul>
</div>

</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('common/sidebar_login');?>
<?php $this->load->view('common/sidebar_ad');?>

</div>
</div></div></div>

<?php $this->load->view('common/footer');?>
</body>
</html>