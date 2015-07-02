<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">节点列表</h3>
    </div>
    <div class="panel-body">
	    <?php if($catelist[0]){?>
    	<?php foreach ($catelist[0] as $v){?>
    	<p><span class="text-muted"><?php echo $v['cname']; ?></span></p>
        <p>
        <?php if(isset($catelist[$v['node_id']])) foreach($catelist[$v['node_id']] as $c){?>
		<a href="<?php echo url('node_show',$c['node_id']);?>"><?php echo $c['cname']?></a>&nbsp;
		<?php }?>
		</p>
		<?php }?>
		<?php }?>
    </div>
</div>