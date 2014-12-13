<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>运行状态 - 管理后台 - <?php echo $settings['site_name']?></title>
<?php $this->load->view ( 'common/header-meta' ); ?>
</head>
<body id="startbbs">
<?php $this->load->view ( 'common/header' ); ?>
    <div class="container">
        <div class="row">
<?php $this->load->view ('common/sidebar');?>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">欢迎进入后台管理</h3>
                    </div>
                    <div class="panel-body">
					StartBBS开源社区系统</a>
 <span class="red"><?php echo $this->config->item('sys_version');?></span>
                    </div>
                </div>
                <div class="row">
	                <div class="col-md-6">
		                <div class="panel panel-default">
		                    <div class="panel-heading">
		                        <h3 class="panel-title">统计</h3>
		                    </div>
		                    <div class="panel-body">
			                    <ul class="list-unstyled">
									<li>会员总数:<?php echo $total_users?></li>
									<li>主题总数:<?php echo $total_topics?></li>
									<li>回复总数:<?php echo $total_comments?></li>
								</ul>
		                    </div>
		                </div>
	                </div>
	                <div class="col-md-6">
		                <div class="panel panel-default">
		                    <div class="panel-heading">
		                        <h3 class="panel-title">清理</h3>
		                    </div>
		                    <div class="panel-body">

		                    </div>
		                </div>
	                </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">官方动态</h3>
                    </div>
                    <div class="panel-body">
						<iframe src="http://bbs.startbbs.com/home/latest" width="100%" height="100%" frameborder="0" scrolling="no">Startbbs使用了框架技术，但是您的浏览器不支持框架，请升级您的浏览器以便正常访问StartBBS。</iframe>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view ( 'common/footer' ); ?>
</body></html>
