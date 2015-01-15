<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?php $this->load->view ( 'common/header-meta' ); ?>

<title>安装向导 | Powered By StartBBS</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">安装向导 >> 检测环境</div>
                    <div class="panel-body table-responsive">
                        <h3 style="margin: 10px 0;"><b>环境检测</b></h3>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>检测项目</th>
                                    <th>推荐配置</th>
                                    <th>最低要求</th>
                                    <th>当前状态</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($environment as $item) : ?>
                                <tr>
                                    <td><?php echo $item['name'];?></td>
                                    <td><?php echo $item['recommend'];?></td>
                                    <td><?php echo $item['lowest'];?></td>
                                    <td><?php echo mb_strimwidth($item['current'], 0, 30, '...')?></td>
                                    <td>
                                        <?php
                                        if ($item['isok']) {
                                            echo '<font color="green">ok<span class="glyphicon glyphicon-ok"></span></font>';
                                        } else {
                                            echo '<font color="red">No<span class="glyphicon glyphicon-remove"></span></font>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <h3 style="margin: 10px 0;"><b>目录、文件权限检查</b></h3>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>检测项目</th>
                                    <th>安装需求</th>
                                    <th>当前状态</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($filemod as $item) : ?>
                                <tr>
                                    <td><?php echo $item['name'];?></td>
                                    <td><?php echo $item['needmod'];?></td>
                                    <td>
                                        <?php
                                        if ($item['mod']) {
                                            echo '<font color="green">可写 <span class="glyphicon glyphicon-ok"></span></font>';
                                        } else {
                                            echo '<font color="red">不可写 <span class="glyphicon glyphicon-remove"></span></font>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <center>
                            <br><br>
                            <?php if ($do_next) : ?>
                            <a class="btn btn-success btn-block" href="<?php echo site_url('install/process');?>" role="button">下一步</a>
                            <?php else : ?>
                            <a class="btn btn-danger btn-block" href="<?php echo site_url('install/check');?>" role="button">重新检测</a>
                            <a class="btn btn-default btn-block" href="<?php echo site_url('install/process');?>" role="button">强制安装</a>
                            <?php endif; ?>
                        </center>
                    </div>
                    <center class="panel-footer">
                        Copyright © 2014 <a href="http://startbbs.com">StartBBS</a>. All rights reserved.
                    </center>
                </div>
            </div>
        </div>
    </div>
</body>
</html>