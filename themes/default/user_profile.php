<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $user['username']?> - <?php echo $settings['site_name']?>' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $user['username']?> - <?php echo $settings['site_name']?></title>
<?php echo $this->load->view('common/header-meta')?>
</head>
<body id="startbbs">
<?php echo $this->load->view('common/header')?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-2">
                            <img class="img-rounded img-responsive" src="<?php echo base_url($user['avatar'].'big.png')?>" alt="<?php echo $user['username']?> large avatar">
                        </div>
                        <div class="col-md-6">
                            <h4><?php echo $user['username'];?></h4>
                            <p class="text-muted"><small><?php echo $user['username'];?>是第<?php echo $user['uid'];?>号会员，加入于<?php echo date('Y-m-d H:i',$user['regtime']);?></small></p>
                            <p>签名：<?php echo $user['signature'];?></p>
                            <p>个人主页：<a href="<?php echo $user['homepage'];?>"><?php echo $user['homepage'];?></a></p>
                            <p>所在地：<?php echo $user['location'];?></p>
                        </div>
                        <div class="col-md-4">
						<?php if($this->session->userdata('uid') && $user['uid']!=$this->session->userdata('uid')){?>
						<button class="btn btn-default" data-toggle="modal" data-target="#message">私信</button>
						<?php if(!$is_followed){?>
						<a href="<?php echo site_url('follow/add/'.$user['uid']);?>" class="btn btn-info" data-method="post" rel="nofollow">关注</a>
						<?php }else{?>
						<a href="<?php echo site_url('follow/cancel/'.$user['uid']);?>" class="btn btn-warning" data-method="post" rel="nofollow">取消关注</a>
						<?php }?>
						<?php }?>  
                        </div>
                        <div class="col-md-12">
                            <p><?php echo $user['introduction'];?></p>
                        </div>
                    </div>
                </div><!-- /.info -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><small><?php echo $user['username'];?> 最近创建的主题</small></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list">
                            <?php foreach ($topic_list as $v) : ?>
                            <li class="media topic-list">
                                <div class="pull-right">
                                    <span class="badge badge-info"><?php echo $v['comments'] ;?></span>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading topic-list-heading"><a href="<?php echo site_url('topic/show/'.$v['topic_id']);?>"><?php echo $v['title'];?></a></h4>
                                    <p class="small text-muted">
                                        <span><a href="<?php echo site_url('node/show/'.$v['node_id']);?>"><?php echo $v['cname'];?></a></span>&nbsp;•&nbsp;
                                        <span><?php echo friendly_date($v['addtime']);?></span>&nbsp;•&nbsp;
                                        <?php if ($v['rname']!=NULL) : ?>
                                            <span>最后回复来自 <a href="<?php echo site_url('user/profile/'.$v['ruid']);?>"><?php echo $v['rname'];?></a></span>
                                        <?php else : ?>
                                            <span>暂无回复</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <ul class="pagination"></ul>
                    </div>
                </div><!-- /.topics -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><small><?php echo $user['username'];?> 最近回复了</small></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list">
                            <?php foreach ($comment_list as $v) : ?>
                            <li class="media reply-list">
                                <div class="media-body reply_content">
                                    <h4 class="media-heading topic-list-heading"><small>回复了 <a href="<?php echo site_url('user/profile/'.$v['uid']);?>" title="<?php echo $v['username']?>"><?php echo $v['username']; ?></a> 创建的主题 </small><a href="<?php echo site_url('topic/show/'.$v['topic_id']);?>"><?php echo $v['title']; ?></a></h4>
                                    <blockquote>
                                        <?php echo $v['content'];?>
                                        <small><?php echo friendly_date($v['replytime']);?></small>
                                    </blockquote>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <!--<ul class="pagination"></ul>-->
                    </div>
                </div><!-- /.comments -->
            </div><!-- /.col-md-8 -->

			<div class='col-md-4'>
			<?php $this->load->view('common/sidebar_login')?>
			<?php $this->load->view('common/sidebar_ad');?>
			</div>

        </div><!-- /.row -->
    </div><!-- /.container -->
<div class="modal fade" id="message">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">发信给</h4>
      </div>
      <div class="modal-body">
	    <form id="send-message" class="form-horizontal">
		<input type="hidden" id="token" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>">
		<div class="form-group">
			<div class="col-md-2 control-label"><label for="message_receiver" class="required">发给：</label></div>
			<div class="col-md-8">
				<input type="text" class="form-control"  value="<?php echo $user['username']?>" disabled/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-2 control-label"><label>内容</label></div>
			<div class="col-md-8">
				<textarea id="content" name="content"  class="form-control" rows="5"></textarea>
			</div>
		</div>
		<div class="form-group">
		      <div class="col-md-offset-2 col-md-2">
		      	<input type="hidden" name="receiver_uid" id="receiver_uid" value="<?php echo $user['uid'];?>">
		        <button class="btn btn-primary" type="submit">发送</button>
		      </div>
		      <div class="col-md-4">
		      		<div id="error" class="red"></div>
		      </div>
		</div>
		</form>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
					$('#content').val(data);
					$('#message').modal('hide');
					//location.href ='<?php echo site_url('message/index')?>;
				}
			});

		});

	});
</script>
</body>
</html>