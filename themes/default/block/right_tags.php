 <div class="panel panel-default">
    <div class="panel-heading">
        最新标签
    </div>
    <div class="panel-body">
	    <?php if($taglist){?>
        <ul class="list-unstyled">
	        <?php foreach($taglist as $v){?>
            <span class="tags"><a href="<?php echo site_url('tag/index/'.$v['tag_title']);?>"><?php echo $v['tag_title'];?></a></span>
			<?php }?>
        </ul>
        <?php }?>
    </div>
</div> 