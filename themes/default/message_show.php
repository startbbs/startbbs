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
                    <h4>与<?php echo $dialog['receiver_username']?>的对话<small class="pull-right"><a href="<?php echo site_url('message')?>">返回私信列表</a></small></h4>
                </div>
                <div class="panel-body">
	                <div class="clearfix">
                    <form id="send-message" action="<?php echo site_url('message/send')?>" method="post" class="reply-message">
                    <input type="hidden" id="token" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>">
                        <div class="form-group">
                            <textarea id="content"  class="form-control" name="content" rows="5" cols="3"></textarea>
                        </div>
                        <div class="form-group">
	                        <div class="col-md-2 pull-right">
	                        <input type="hidden" id="receiver_uid" name="receiver_uid" value="<?php echo $dialog['receiver_uid']?>" />
                            <button type="submit" class="btn btn-primary pull-right">发送</button>
                            </div>
                        <div class="col-md-offset-4 col-md-4">
		      		<div id="error" class="red"></div>
		      			</div>
                        </div>
                    </form>
                    </div>
                    
					<ul class="media-list">
					<?php if(isset($message_list)) foreach($message_list as $k=>$v){?>
					<?php if($v['sender_uid']==$uid){?>
					  <li class="media">
					    <a class="media-left" href="<?php echo site_url('user/profile/'.$v['sender_uid'])?>">
					      <img src="<?php echo base_url($v['sender_avatar'].'normal.png');?>" alt="<?php echo $v['sender_username'];?>">
					    </a>
					    <div class="media-body alert alert-info">
						  我:
					      <?php echo $v['content'];?>
					      <p>
					     <?php echo friendly_date($v['create_time'])?></p>
					    </div>
					  </li>
					<?php }else{?>
					  <li class="media">
					    <div class="media-body alert alert-warning">
						   <?php echo $v['sender_username'];?>:
					      <?php echo $v['content'];?>
					            <p>
					     <?php echo friendly_date($v['create_time'])?></p>
					     </div>
					    <a class="media-right" href="<?php echo site_url('user/profile/'.$v['sender_uid'])?>">
					      <img src="<?php echo base_url($v['sender_avatar'].'normal.png');?>" alt="<?php echo $v['sender_username'];?>">
					    </a>
					  </li>
					 <?php }?>
					 <?php }?>
					</ul>

                               </div>
            </div>
        </div>

		<div class="col-md-4">
<?php $this->load->view('common/sidebar_login');?>
<?php $this->load->view('common/sidebar_ad');?>
		</div>

    </div>
</div>
</div>
<?php $this->load->view('common/footer');?>
<script>
	$(function(){
		$('#send-message').on('submit',function(e) {
			e.preventDefault();
			var receiver_uid = $('#receiver_uid').val();
			var content =$.trim($('#content').val());
			var token=$('#token').val();
			if (content == '') {
				$('#error').html('内容不能为空!');
				return  false;
			}
			$.ajax({
				url: '<?php echo site_url('message/send')?>',
				type: 'post',
				dataType: 'json',
				data: {receiver_uid:receiver_uid,content:content,<?php echo $csrf_name;?>:token},
				success: function(data) {
					//$('#content').val('');
					//$('#message').modal('hide');
					location.reload();
				}
			});

		});

	});
</script>
</body>
</html>