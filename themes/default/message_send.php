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
                    <h4>发信息给<?php echo $receiver['username'];?></h4>
                </div>
                <div class="panel-body">

                    <form id="reply-chat" action="<?php echo site_url('message/send')?>" method="post" class="reply-message">
                        <div class="form-group">
                            <textarea id="reply_content"  class="form-control" name="content" rows="5" cols="3"></textarea>
                        </div>
                        <div class="form-group">
	                        <input type="hidden" name="receiver_id" value="" />
                            <button type="submit" class="btn btn-primary pull-right">发送</button>
                        </div>
                    </form>


<ul class="media-list clearfix">
<?php if(isset($dialog_list)) foreach($dialog_list as $k=>$v){?>
<?php if($k%2==1){?>
  <li class="media">
    <a class="media-left" href="#">
      <img src="<?php echo base_url($v['avatar']);?>" alt="...">
    </a>
    <div class="media-body alert alert-warning">
      <?php echo $v['content'];?>
      <p class="text-right">
     3天前</p>
    </div>
  </li>
<?php }else{?>
  <li class="media">
    <a class="pull-right" href="#">
      <img src="<?php echo base_url($v['avatar']);?>" alt="...">
    </a>
    <div class="media-body alert alert-info">
      <?php echo $v['content'];?>
            <p class="text-left">
     3天前</p>    </div>
  </li>
 <?php }?>
 <?php }?>
</ul>

                               </div>
            </div>
        </div>

		<div class="col-md-4">
		    <div class="panel">
		        <div class="panel-body text-center">
		            <a href="/index.php?m=topic&a=add&cid=1" class="btn btn-success btn-block">发表新话题</a>
		        </div>
		    </div>
		    <div class="panel">
		        <div class="panel-heading">
		            全部分类
		        </div>
		        <div class="panel-body">
		            <ul class="nav nav-pills nav-stacked">
		                <li class="active" >
		                        <a href="/index.php?m=topic&a=category&cid=1">大分类</a>
		                    </li>
		            </ul>
		        </div>

		    </div>
		</div>

    </div>
</div>
</div>
<?php $this->load->view('common/footer');?>
</body>
</html>