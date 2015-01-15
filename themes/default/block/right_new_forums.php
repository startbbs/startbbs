<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">最新贴子</h3>
    </div>
    <ul class="list-group">
    <?php if(isset($new_forums)) foreach($new_forums as $v){?>
        <li class="list-group-item">
            <span><a href="<?php echo site_url('forum/view/'.$v['fid']);?>" class="startbbs"><?php echo sb_substr($v['title'],14);?></a><span class="pull-right gray"><?php echo $this->myclass->friendly_date($v['updatetime']);?></span></span>
        </li>
<?php }?>
    </ul>
</div>