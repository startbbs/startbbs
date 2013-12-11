<!DOCTYPE html><html><head><meta content='## 电子邮件&#x000A;&#x000A;daqing1986@gmail.com&#x000A;&#x000A;## QQ&#x000A;&#x000A;420771712 (请注明 rabel)&#x000A;&#x000A;&#x000A;' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title;?>列表 - <?=$settings['site_name']?></title>
<?php $this->load->view('header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('header');?>

<div id="wrap"><div class="container" id="page-main"><div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box'>
<div class='inner'>
<div class='page'>
<article>
<h1 class='page-header'>
<?php echo $title;?><span class="red"><?php echo $q;?></span>列表
</h1>
<!-- Put the following javascript before the closing </head> tag. -->
  
<script>
  (function() {
    var cx = 'partner-pub-0724371017144625:2619846736';
    var gcse = document.createElement('script'); gcse.type = 'text/javascript'; gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.cn/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
  })();
</script>
<!-- Place this tag where you want the search results to render -->
<gcse:searchresults-only></gcse:searchresults-only>
</article>
</div>
</div>
</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>

<?php $this->load->view('block/right_login');?>

<div class='box'>
<div class='box-header'>
社区运行状态
</div>
<div class='inner'>
<table border='0' cellpadding='3' cellspacing='0' width='100%'>
<tr>
<td align='right' width='60'>
<span class='gray'>注册会员</span>
</td>
<td align='left'>
<strong>468</strong>
</td>
</tr>
<tr>
<td align='right' width='50'>
<span class='gray'>话题</span>
</td>
<td align='left'>
<strong>193</strong>
</td>
</tr>
<tr>
<td align='right' width='50'>
<span class='gray'>回复</span>
</td>
<td align='left'>
<strong>1060</strong>
</td>
</tr>
</table>
</div>
</div>

<?php $this->load->view('block/right_ad');?>

</div>
</div></div></div>

<?php $this->load->view('footer');?>