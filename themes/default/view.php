<!DOCTYPE html>
<html>
<head>
<title><?php echo $content['title']?> - <?php echo $settings['site_name']?></title>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<meta name="keywords" content="<?php echo $content['keywords']?>" />
<meta name="description" content="<?php echo $content['description'];?>" />
<?php $this->load->view ('header-meta');?>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/kindeditor-min.js');?>"></script>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/lang/zh_CN.js');?>"></script>
<?php if($this->config->item('show_editor')=='on'){?>
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/keset2.js');?>"></script>
<?php } elseif($this->config->item('storage_set')=='local') {?>
<link rel="stylesheet" href="<?php echo base_url('plugins/kindeditor/themes/default/default.css');?>" />
<script charset="utf-8" src="<?php echo base_url('plugins/kindeditor/keupload.js');?>"></script>
<?php } else{?>
<script src="<?php echo base_url('static/common/js/jquery.upload.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/common/js/qiniu.js')?>" type="text/javascript"></script>
<?php }?>
<script src="<?php echo base_url('static/common/js/topic.js')?>" type="text/javascript"></script>
</head>
<body id="startbbs" name="top">
<?php $this->load->view ('header'); ?>
<div id="wrap"><div class="container" id="page-main"><div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>
<div class='box'>
<article>
<div class='header topic-head'>
<div class='pull-right'>
<a href="<?php echo site_url('user/info/'.$content['uid']);?>" class="profile_link" title="<?php echo $content['username']?>">
<?php if($content['avatar']) {?>
<img alt="<?php echo $content['username']?> medium avatar" class="medium_avatar" src="<?php echo base_url($content['avatar']);?>" />
<?php } else {?>
<img alt="<?php echo $content['username']?> medium avatar" class="medium_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>" />
<?php }?>
</a>
</div>
<p><a href="<?php echo site_url();?>">首页</a> <span class="text-muted">/</span> <a href="<?php echo site_url('forum/flist/'.$cate['cid']);?>"><?php echo $cate['cname'];?></a></p>
<h1 id='topic_title'>
<?php echo $content['title']?>
</h1>
<small class='topic-meta'>
By
<a href="<?php echo site_url('user/info/'.$content['uid']);?>" class="dark startbbs profile_link" title="<?php echo $content['username']?>"><?php echo $content['username']?></a>
at
<?php echo date('Y-m-d h:i:s',$content['addtime']);?>,
<?php echo $content['views']?>次浏览 • <?php echo $content['favorites'];?>人收藏
<?php if($this->session->userdata('uid')){?>
• <a href="#reply_content">回复</a> • 
<?php if($in_favorites){?>
<a href="<?php echo site_url('favorites/del/'.$content['fid']);?>" title="取消收藏">取消收藏</a>
<?php } else {?>
<a href="<?php echo site_url('favorites/add/'.$content['fid']);?>" title="点击收藏">收藏</a>
<?php } ?>
<?php } ?>
</small>
</div>
<?php if($page==1){?>
<div class='inner'>
<div class='content topic_content'><?php echo $content['content']?></div>
<?php if(isset($tag_list)){?>
<p class="tag">
<?php foreach($tag_list as $tag){?>
<a href='<?php echo site_url($tag['tag_url']);?>'><?php echo $tag['tag_title'];?></a>&nbsp;
<?php }?>
</p>
<?php }?>
</div>
<div class='inner'>
<?php if($this->auth->is_user($content['uid']) || $this->auth->is_admin() || $this->auth->is_master($cate['cid'])){?>
<a href="<?php echo site_url('forum/edit/'.$content['fid']);?>" class="btn btn-default btn-sm unbookmark" data-method="edit" rel="nofollow">编辑此贴</a>
<a href="<?php echo site_url('forum/del/'.$content['fid'].'/'.$content['cid'].'/'.$content['uid']);?>" class="btn btn-sm btn-danger" data-method="edit" rel="nofollow">删除</a>
<?php }?>
<?php if($this->auth->is_admin() || $this->auth->is_master($cate['cid'])){?>
<a href="<?php echo site_url('forum/view/'.$content['fid'].'?act=set_top');?>" class="btn btn-default btn-sm unbookmark" data-method="edit" rel="nofollow">
<?php if($content['is_top']==0){?>
置顶此贴
<?php } else {?>
取消置顶
<?php }?>
</a>
<?php }?>
<div align='right' class='pull-right'>
<!--<a href="/topics/187/bookmarks" class="btn btn-xs bookmark" data-method="post" rel="nofollow">加入收藏</a>-->
</div>
&nbsp;&nbsp;
</div>
<?php }?>
</article>
</div>

<section>
<div class='box'>
<div class='box-header'>
<div class='pull-right'>
<a href="#reply" class="dark jump_to_comment">跳到回复</a>
</div>
<span id="comments">
<?php echo $content['comments']?></span> 回复
</div>
<div class='fix_cell' id='saywrap'>
<div id="clist">
<?php foreach ($comment as $key=>$v){?>
<article>
<div class='cell hoverable reply' id='comment_988'>
<div class="row">
<div class="col-md-1">
<a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="profile_link" title="<?php echo $v['username']?>">
<?php if($v['avatar']) {?>
<img alt="<?php echo $v['username']?> medium avatar" class="medium_avatar" src="<?php echo base_url($v['avatar']);?>" />
<?php } else {?>
<img alt="<?php echo $v['username']?> medium avatar" class="medium_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>" />
<?php }?>
</a>
</div>
<div class="col-md-11">
<div>
<span class='snow pull-right' id="r<?php echo ($page-1)*10+$key+1;?>">
#<?php echo ($page-1)*10+$key+1;?> -<a href="#reply" class="clickable startbbs"  data-mention="<?php echo $v['username']?>" onclick="replyOne('<?php echo $v['username']?>');">回复</a></span>
<span><a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="dark startbbs profile_link" title="<?php echo $v['username']?>"><?php echo $v['username']?></a></span>
<span class="snow">&nbsp;&nbsp;<?php echo $this->myclass->friendly_date($v['replytime'])?></span>
</div>
<div class='content reply_content'><?php echo stripslashes($v['content'])?></div>
<div class="pull-right">
<!--<?php echo $v['signature']?>-->
<?php if($this->auth->is_admin() || $this->auth->is_master($cate['cid'])){?>
<a href="<?php echo site_url('comment/del/'.$content['cid'].'/'.$v['fid'].'/'.$v['id']);?>" class="danger snow"><span class="glyphicon glyphicon-remove-sign"></span>删除</a><?php }?>
<?php if($this->auth->is_user($v['uid']) || $this->auth->is_admin() || $this->auth->is_master($cate['cid'])){?>
 <a href="<?php echo site_url('comment/edit/'.$content['cid'].'/'.$v['fid'].'/'.$v['id']);?>" class="danger snow"><span class="glyphicon glyphicon-remove-sign"></span>编辑</a>
 <?php }?>
</div>

</div>
</div>
</div>
</article>
<?php }?>
</div>
 
 <?php if($content['comments']>10){?>
<div class='center'>
<ul class='pagination'>
<?php echo $pagination;?>
<!--<span class='gray'></span>-->
<!--<li class='next'>
<a href="/go/noticeboard?p=2">下一页 →</a>
</li>-->
</ul>
</div>
<?php }?> 
</div>
</div>


</section>

<a name='reply'></a>

<div class='box'>
<div class='box-header'>
<div class='pull-right'>
<a href="#top" class="dark back_to_top">回到顶部</a>
</div>
现在就添加一条回复
</div>
<div class='inner row'>
<?php if($this->auth->is_login()){?>
<!--<form id="myform" action="<?php echo site_url('comment/add_comment');?>" method="post" name="add_new">-->
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="authenticity_token" type="hidden" value="b9p2+DhdHWTAHdRMrexpe7XxI2HxTaX7MaUKEaQiUsY=" />
<input name="fid" id="fid" type="hidden" value="<?php echo $content['fid']?>" />
<input name="is_top" id="is_top" type="hidden" value="<?php echo $content['is_top']?>" />
<input name="username" id="username" type="hidden" value="<?php echo $user['username']?>" />
<input name="avatar" id="avatar" type="hidden" value="<?php echo base_url($user['middle_avatar'])?>" />

<!--<div id='preview-widget'style="margin-left: 15px;">
<a href="javascript:void(0);" class="action_label cancel_preview current_label" data-ref="comment_content">编辑区</a>

</div>-->
<ul class="nav nav-tabs" style="margin-left: 15px; margin-right: 15px;border-bottom: 0px solid #999;height:20px">
  <li class="active"><a style="background-color: #eee;" href="#">编辑区</a></li>
  <?php if($this->config->item('show_editor')=='off'){?>
  <li class="pull-right">
	<?php if($this->config->item('storage_set')=='local'){?>
	<span id='upload-tip' class="btn btn-default" value="图片/附件">上传图片</span>
	<?php } else {?>
	<input id="upload_tip" type="button" value="图片/附件"  class="btn btn-default">
<!--	<input type="button" onclick="doUpload()" value="图片/附件"  class="btn btn-default">-->
	<?php }?>
	  </li>
<?php }?>
</ul>
<div class="form-group">
<div class="col-md-12" id="textContain">
<textarea class="form-control" id="reply_content" name="comment" rows="5"></textarea>
<span class='text-muted' style="float:right">可直接粘贴链接和图片地址/发代码用&lt;pre&gt;标签</span>
</div></div>
<div class="col-sm-9">
<input class="btn btn-primary" data-disable-with="正在提交" type="submit" id="comment-submit" value="发送" />
<small class='gray'>(支持 Ctrl + Enter 快捷键)</small>
 <span id="msg"></span>
 </div>
<!-- </form>-->
 <?php } else{?>
<div style="text-align: center;">
<p><?php echo $settings['welcome_tip']?></p>
<p><a class="btn btn-default" href="<?php echo site_url('user/login');?>">登录发表</a></p>
<p><a href="<?php echo site_url('user/reg');?>">还没有账号？去注册</a></p>
</div>
 <?php }?>
</div>
</div>



</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('block/right_login');?>
<?php $this->load->view('block/right_cateinfo');?>
<?php $this->load->view('block/right_cates');?>
<?php $this->load->view('block/right_related_forum');?>

<?php if($this->auth->is_admin() && isset($_COOKIE['username'])){ ?>
<!--<div class='box'>
<div class='box-header'>
话题管理
</div>
<div class='cell'>
<a href="/nodes/1/topics/26/edit_title" class="btn btn-xs" data-remote="true">修改标题</a>
<a href="/nodes/1/topics/26/edit" class="btn btn-xs">编辑全部</a>
</div>
<div class='cell'>
<a href="/nodes/1/topics/26/move" class="btn btn-xs" data-remote="true">移动到新节点</a>
</div>
<div class='cell'>
<a href="/topics/26/toggle_comments_closed" class="btn btn-xs" data-method="put" rel="nofollow">禁止回复</a>
<a href="/topics/26/toggle_sticky" class="btn btn-xs" data-method="put" rel="nofollow">置顶此话题</a>
</div>
<div class='inner'>
<a href="/nodes/1/topics/26" class="btn btn-xs btn-danger" data-confirm="真的要删除吗？" data-method="delete" rel="nofollow">删除此话题</a>
</div>
</div>-->
<?php }?>

<?php $this->load->view('block/right_ad');?>
</div>
</div></div></div>
<?php $this->load->view ('footer'); ?>