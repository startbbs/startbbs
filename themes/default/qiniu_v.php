<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?=$title?> - <?=$settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
        <!--<script src="http://malsup.github.com/jquery.form.js"></script> 
        <script> 
            // wait for the DOM to be loaded 
            $(document).ready(function() { 
                // bind 'myForm' and provide a simple callback function 
                $('#myForm').ajaxForm(
                        {
                            dataType:'json',
                            beforeSubmit: function(){
                                        $('#loading').css('visibility', 'visible');
                                        $('#myForm').hide();
                                    },
                            success:function(data){
                                        $('#image').attr('src', 'http://stbimg.u.qiniudn.com/'+ data.key);
                                        $('#loading').hide();
                                        $('#success').css('visibility', 'visible');
                                    },
                            error:function(){
                                        $('#loading').hide();
                                        $('#error').html('图片上传失败，请刷新后重试。')
                                    }
                        });
                }); 
        </script> -->
</head>

<body id="startbbs">
<a id="top" name="top"></a>
<?php $this->load->view('common/header');?>

<div id="wrap">
<div class="container" id="page-main">
<div class="row">
<div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box'>
<div class='inner'>
<div class='page'>
<article>
<h1 class='page-header'>
<?=$title?>
</h1>
<form id="myForm" action="<?php site_url('upload/qiniu')?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>" id="token">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="submit" value="提交" />
</form>
</article>
</div>
<div id="loading" style="visibility:hidden">
        <img src="http://loadinggif.com/images/image-selection/3.gif"><br />图片上传中....
    </div>
   <div id="success" style="visibility:hidden">
        <img id="image" />
    </div>

   <div id="error"></div>


    
</div>
</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('common/sidebar_login');?>

<?php $this->load->view('common/sidebar_ad');?>




</div>
</div></div></div>
<?php $this->load->view('common/footer'); ?>