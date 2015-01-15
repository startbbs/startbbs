 <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">友情链接</h3>
    </div>
    <div class="panel-body">
        <ul class="list-unstyled statistics">
            <li style="width:0; height:0; overflow:hidden;"><a href="http://www.startbbs.com" target="_blank">StartBBS</a></li>
            <?php if($links){?>
            <?php foreach($links as $v){?>
            <?php if($v['is_hidden']==0){?>
            <li><a href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['name'];?></a></li>
            <?php } else {?>
            <li>暂无链接</li>
            <?php } ?>
            <?php }?>
            <?php } else {?>
            <li>暂无链接</li>
            <?php }?>
        </ul>
    </div>
</div>