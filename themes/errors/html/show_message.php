<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title><?php if($heading) echo $heading;else {?>Error<?php }?></title>
<link href="<?php echo base_url('static/common/css/bootstrap.min.css');?>" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
#container {
	width:600px;
	margin: 10px auto;
	padding: 20px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}
</style>
</head>
<body>
	<div id="container">
			<h2><?php echo $heading; ?></h2>
			<div class="alert<?php if ($status==1){ ?> alert-success<?php }else{?> alert-danger<?php } ?>" role="alert">
			<?php echo $message;?>
			</div>
		    <p>
			<?php if(!$url){ ?>
			<a href="javascript:history.back();" class="alert-link">如果您的浏览器没有自动跳转，请点击这里</a>
			<script language="javascript">setTimeout(function(){history.back();}, <?php echo $time; ?>);</script>
			<?php } else{?>
			<a href="<?php echo $url?>" class="alert-link">如果您的浏览器没有自动跳转，请点击这里</a>
			<script language="javascript">setTimeout("location.href='<?php echo $url; ?>';", <?php echo $time; ?>);</script>   
			<?php } ?>
			</p>
		
	</div>
</body>
</html>