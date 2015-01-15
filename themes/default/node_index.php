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
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $settings['site_name']?><span class='pull-right'>话题总数<span class='badge badge-info'>&nbsp;<?php echo $total_topics;?>&nbsp;</span></span></h3>
                    </div>
                    <div class="panel-body">
                        <?php echo $settings['site_description']?>
                    </div>
                </div>
                <?php if($catelist[0]):?>
                <?php if(count($catelist)==1):?>
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">所有结点</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list">
	                        <?php foreach ($catelist[0] as $k=>$v):?>
                            <li class="media section">
                                <a class="media-left" href="#"><img class="img-rounded" src="<?php echo base_url($v['ico'])?>" alt="<?php echo $v['cname'];?>"></a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="<?php echo url('node_show',$v['node_id']);?>"><?php echo $v['cname'];?></a></h4>
                                    <p class="text-muted">
                                        <?php echo $v['content'];?>
                                    </p>
                                    <p class="text-muted">
                                        版主:<?php echo $v['master'];?>
                                    </p>
                                </div>
                            </li>
                            <?php endforeach?>
                        </ul>
                    </div>
                </div>
                <?php endif?>
                <?php if(count($catelist)>1):?>
                <?php foreach ($catelist[0] as $v) {?>
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $v['cname'];?></h3>
                    </div>
                    <div class="panel-body">
	                    <?php if(isset($catelist[$v['node_id']])){?>
                        <ul class="media-list">
	                        <?php foreach ($catelist[$v['node_id']] as $k=>$c) {?>
                            <li class="media section">
                                <a class="pull-left" href="<?php echo url('node_show',$v['node_id']);?>"><img class="img-rounded" src="<?php echo base_url($c['ico'])?>" alt="<?php echo $c['cname'];?>"></a>     	
                            	<span class="pull-right text-right"><p><?php foreach($today_topics[$v['node_id']] as $t){?><?php echo @$t?>/今日<?php }?></p><p><?php echo $c['listnum'];?>/话题</p></span>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="<?php echo url('node_show',$c['node_id']);?>"><?php echo $c['cname'];?></a></h4></h4>
                                    <p class="text-muted">
                                        <?php echo $c['content'];?>
                                    </p>
                                    <p class="text-muted">
                                        版主:<?php echo $c['master'];?>
                                    </p>
                                </div>
                            </li>
                            <?php }?>
                        </ul>
                        <?php }else{?>
                        暂无节点
                        <?php }?>
                    </div>
                </div>
                <?php }?>
                <?php endif?>
              <?php else:?>
              <div class="panel panel-default">
				  <div class="panel-body">
				    暂无节点，请到后台添加
				  </div>
			</div>
              <?php endif?>
            </div><!-- /.col-md-8 -->

            <div class="col-md-4">
                <?php $this->load->view('common/sidebar_login');?>
				<?php $this->load->view('common/sidebar_new_users');?>
				<?php $this->load->view('common/sidebar_new_topics');?>
				<?php $this->load->view('common/sidebar_ad');?>
            </div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer');?>
</body>
</html>