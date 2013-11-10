<div class='box'>
<div class='box-header'>
分类节点
</div>
<div class='inner'>
<?php if($catelist[0]){?>
    <?php foreach ($catelist[0] as $v){?>
	<p><span class="text-muted"><?php echo $v['cname']; ?></span></p>
        <p>
        <?php if(isset($catelist[$v['cid']])) foreach($catelist[$v['cid']] as $c){?>
		<a href="<?php echo site_url($c['flist_url']);?>"><?php echo $c['cname']?></a>&nbsp;
		<?php }?>
		</p>
	<?php }?>
<?php }?>
</div>
</div>