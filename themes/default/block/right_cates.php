<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">分类节点</h3>
    </div>
    <div class="panel-body">
	    <?php if($catelist[0]){?>
    	<?php foreach ($catelist[0] as $v){?>
    	<p><span class="text-muted"><?php echo $v['cname']; ?></span></p>
        <p>
        <?php if(isset($catelist[$v['node_id']])) foreach($catelist[$v['node_id']] as $c){?>
		<a href="<?php echo site_url($c['node_show_url']);?>"><?php echo $c['cname']?></a>&nbsp;
		<?php }?>
		</p>
		<?php }?>
		<?php }?>
    </div>
</div>