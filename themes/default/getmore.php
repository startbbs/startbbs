							<?php if($topic_list) foreach ($topic_list as $v):?>
                            <li class="media topic-list">
                                <div class="pull-right">
                                    <span class="badge badge-info topic-comment"><a href="<?php echo url('topic_show',$v['topic_id']).'#reply';?>"><?php echo $v['comments'] ;?></a></span>
                                </div>
                                <a class="media-left" href="<?php echo site_url('user/profile/'.$v['uid']);?>"><img class="img-rounded" src="<?php echo base_url($v['avatar'].'normal.png');?>" alt="<?php echo $v['username']?> medium avatar"></a>
                                <div class="media-body">
                                    <h2 class="media-heading topic-list-heading"><a href="<?php echo url('topic_show',$v['topic_id']);?>"><?php echo $v['title'];?></a><?php if( $v['is_top'] == '1' ) echo '<span class="badge badge-info">置顶</span>'; ?></h2>
                                    <p class="text-muted">
                                        <span><a href="<?php echo url('node_show',$v['node_id']);?>"><?php echo $v['cname']?></a></span>&nbsp;•&nbsp;
                                        <span><a href="<?php echo site_url('user/profile/'.$v['uid']);?>"><?php echo $v['username'];?></a></span>&nbsp;•&nbsp;
                                        <span><?php echo friendly_date($v['updatetime'])?></span>&nbsp;•&nbsp;
                                        <?php if ($v['rname']!=NULL) : ?>
                                            <span>最后回复来自 <a href="<?php echo site_url('user/profile/'.$v['ruid']);?>"><?php echo $v['rname']; ?></a></span>
                                        <?php else : ?>
                                            <span>暂无回复</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </li>
                            <?php endforeach;?>