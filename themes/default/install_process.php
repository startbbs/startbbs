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
                    <div class="panel-heading">安装向导 >> 创建数据</div>
                    <div class="panel-body">
                        <?php echo form_open('install/process', array('class' => 'form-horizontal', 'role' => 'form', 'onsubmit' => 'return validate_form(this)'));?>
                            <div class="form-group">
                                <label class="col-md-offset-1 control-label"><h3><b>数据库信息：</b></h3></label>
                            </div>
                            <div class="form-group">
                                <label for="dbhost" class="col-md-2 col-md-offset-1 control-label">数据库服务器</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="dbhost" name="dbhost" value="<?php echo $item['dbhost'];?>" placeholder="localhost">
	                            	<span class="help-block red"><?php echo form_error('dbhost');?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="port" class="col-md-2 col-md-offset-1 control-label">数据库端口</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="port" name="port" value="<?php echo $item['port'];?>" placeholder="3306">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dbuser" class="col-md-2 col-md-offset-1 control-label">数据库用户名</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="dbuser" name="dbuser" value="<?php echo set_value('dbuser')?>" placeholder="">
	                            	<span class="help-block red"><?php echo form_error('dbuser');?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dbpsw" class="col-md-2 col-md-offset-1 control-label">数据库密码</label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" id="dbpsw" name="dbpsw" value="<?php echo set_value('password')?>" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dbname" class="col-md-2 col-md-offset-1 control-label">数据库名</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="dbname" name="dbname" value="<?php echo set_value('dbname')?>">
	                            	<span class="help-block red"><?php echo form_error('dbname');?></span>
                                </div> 
                            </div>
                             <div class="form-group">
                                <label for="dbprefix" class="col-md-2 col-md-offset-1 control-label">数据库表前缀</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="dbprefix" name="dbprefix" value="<?php echo $item['dbprefix'];?>" placeholder="stb_">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="dbprefix" class="col-md-2 col-md-offset-1 control-label">安装目录</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="base_url" name="base_url" value="<?php echo set_value('base_url')?>" placeholder="根目录请留空,子目录请填目录名">
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-md-10  col-md-offset-3">
                                    <p class="form-control-static text-primary" id="testdb"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-offset-1 control-label"><h3><b>创始人信息：</b></h3></label>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-md-2 col-md-offset-1 control-label">管理员</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $item['username'];?>" placeholder="username">
	                            	<span class="help-block red"><?php echo form_error('username');?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-2 col-md-offset-1 control-label">密码</label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password')?>" placeholder="Password">
	                            	<span class="help-block red"><?php echo form_error('password');?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-2 col-md-offset-1 control-label">邮箱</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="email" name="email" value="startbbs@126.com" placeholder="startbbs@126.com">
                                </div>
                            </div>
                            <center>
                                <br>
                                <button type="submit" class="btn btn-primary btn-block">创建数据</button>
                            </center>

                        </form>
                    </div>
                    <center class="panel-footer">
                        Copyright © 2014 <a href="http://startbbs.com">StartBBS</a>. All rights reserved.
                    </center>
                </div>
            </div>
        </div>
    </div>
                            <script type="text/javascript">
                            $(document).ready(function(){
                                $("#dbname").blur(function(){
                                    $.ajax({
                                        url: '<?php echo site_url('install/testdb');?>'+'/'+document.getElementById("dbhost").value+'/'+document.getElementById("dbuser").value+'/'+document.getElementById("dbpsw").value+'/'+document.getElementById("dbname").value+'/'+document.getElementById("port").value,
                                        success: function(data) {
                                          $("#testdb").html(data);
                                      }});
                                });
                            });
                            </script>
</body>
</html>