<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $username?> - <?php echo $settings['site_name']?>' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $username?> - <?php echo $settings['site_name']?></title>
<?php echo $this->load->view('common/header-meta')?>
</head>
<body id="startbbs">
<?php echo $this->load->view('common/header')?>
<div id="wrap">
<div class="container" id="page-main">
<div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>
<div class='box'>
<div class='cell'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td align='center' valign='top' width='73'>
<img alt="<?php echo $username?> large avatar" class="large_avatar" style="width:72px; height:72px;" src="<?php echo base_url($avatar.'big.png')?>"/>
</td>
<td valign='top' width='10'></td>
<td align='left' valign='top' width='auto'>
<div class='pull-right'>
<div class='sep3'></div>
<button class="btn btn-default" data-toggle="modal" data-target="#message">私信</button>
<?php if($this->session->userdata('uid')){?>
<?php if(!$is_followed){?>
<a href="<?php echo site_url('follow/add/'.$uid);?>" class="btn btn-info" data-method="post" rel="nofollow">关注</a>
<?php }else{?>
<a href="<?php echo site_url('follow/cancel/'.$uid);?>" class="btn btn-warning" data-method="post" rel="nofollow">取消关注</a>
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
积分:<?php echo $credit?>
</span>
</td>
</tr>
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
<a href="<?php echo site_url('topic/show/'.$v['topic_id']);?>" class="startbbs topic"><?php echo $v['title']?></a>
</span>
<div class='topic-meta'>
<a href="<?php echo site_url('node/show/'.$v['node_id']);?>" class="node"><?php echo $v['cname']?></a>
&nbsp;&nbsp;•&nbsp;&nbsp;
<?php echo $this->myclass->friendly_date($v['addtime'])?>
&nbsp;&nbsp;•&nbsp;&nbsp;
最后回复来自
<a href="<?php echo site_url('user/profile/'.$v['ruid']);?>" class="startbbs profile_link" title="marschris"><?php echo $v['rname']?></a>
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
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" class="startbbs profile_link" title="<?php echo $v['username']?>"><?php echo $v['username']?></a>
<?php echo $this->myclass->friendly_date($v['addtime'])?>
<span class='chevron'>›</span>
<a href="<?php echo site_url('topic/show/'.$v['topic_id']);?>" class="startbbs"><?php echo $v['title']?></a>
</div>
<div class='inner'>
<div class='reply_content'>
<?php echo $v['content']?>
</div>
</div>
<div class='sep5'></div>
<?php } ?>
</div>

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
				<input type="text" class="form-control"  value="<?php echo $username?>" disabled/>
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
		      	<input type="hidden" name="receiver_uid" id="receiver_uid" value="<?php echo $uid;?>">
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

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('common/sidebar_login')?>
<?php $this->load->view('common/sidebar_ad');?>
</div>
</div></div></div>
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
					//location.href =site_url+"/message/index";
				}
			});

		});

	});
</script>
</body>
</html>