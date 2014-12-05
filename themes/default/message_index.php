<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<title><?php echo $title;?> - <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
</head>
<body>
<?php $this->load->view('common/header'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading">
                    <h4>私信</h4>
                </div>
                <div class="panel-body">
<?php if($dialog_list){?>
<ul class="media-list">
	<?php foreach($dialog_list as $v){?>
      <li class="media">
        <a class="media-left" href="<?php echo site_url('user/profile/'.$v['receiver_uid'])?>">
          <img src="<?php echo base_url($v['receiver_avatar'].'normal.png')?>" alt="<?php echo $v['receiver_username'];?>">
        </a>
        <div class="media-body">
          <h5 class="media-heading"><a href="<?php echo site_url('user/profile/'.$v['receiver_uid'])?>"><?php echo $v['receiver_username']?></a> <?php echo friendly_date($v['update_time'])?></h5>
          <p><?php echo $v['last_content']?> <a href="<?php echo site_url('message/show/'.$v['id'])?>">查看对话(<?php echo $v['messages']?>)</a></p>
        </div>
      </li>
      <?php }?>
    </ul>
<?php }else{?>
还没有私信
<?php }?>
                </div>
            </div>
        </div>
<div class="col-md-4">
<?php $this->load->view('common/sidebar_login');?>
<?php $this->load->view('common/sidebar_ad');?>

</div>

        
    </div>
</div>

<?php $this->load->view('common/footer');?>
</body>
</html>