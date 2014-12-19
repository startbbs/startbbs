<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('format_content'))
{
	function format_content($text)
	{

		//if(preg_match($img_url, $text)){
		//	$text = preg_replace($img_url, '<img src="\1" alt="" />', $text);
	   //	}
	   	//preg_match_all($img_url, $text,$arr);
   		
   		
   		//$text= $arr[0][0];

    	// 视频地址识别。
	    // youku
		if(strpos($text, 'player.youku.com')){
		    $text = preg_replace('/http:\/\/player.youku.com\/player.php\/sid\/([a-zA-Z0-9\=]+)\/v.swf/', '<div class="embed-responsive embed-responsive-16by9"><embed src="http://player.youku.com/player.php/sid/\1/v.swf" quality="high" width="100%" height="auto" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed></div>', $text);
		}
		
	    if(strpos($text, 'v.youku.com')){
	        $text = preg_replace('/http:\/\/v.youku.com\/v_show\/id_([a-zA-Z0-9\=]+)(\/|.html?)?/', '<div class="embed-responsive embed-responsive-16by9"><embed src="http://player.youku.com/player.php/sid/\1/v.swf" quality="high" width="100%" height="auto" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed></div>', $text);
	    }

	    // tudou
	    if(strpos($text, 'www.tudou.com')){
	        if(strpos($text, 'programs/view')){
	            $text = preg_replace('/http:\/\/www.tudou.com\/(programs\/view|listplay)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<div class="embed-responsive embed-responsive-16by9"><embed src="http://www.tudou.com/v/\2/" quality="high" width="100%" height="auto" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed></div>', $text);
	        }elseif(strpos($text, 'albumplay')){
	            $text = preg_replace('/http:\/\/www.tudou.com\/(albumplay)\/([a-zA-Z0-9\=\_\-]+)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<embed src="http://www.tudou.com/a/\2/" quality="high" width="100%" height="auto" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $text);
	        }else{
	            $text = preg_replace('/http:\/\/www.tudou.com\/(programs\/view|listplay)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<div class="embed-responsive embed-responsive-16by9"><embed src="http://www.tudou.com/l/\2/" quality="high" width="100%" height="auto" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed></div>', $text);
	        }
	    }
	    $CI =& get_instance();
		$CI->load->helper('typography');
		$text = auto_link_pic($text, 'url', TRUE);
//$text = auto_link($text, 'url', TRUE);
	   	//url
	    /*if(strpos(' '.$text, 'http')){
	        $text = ' '.$text;
	        $text = preg_replace(
	        	'`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
	        	'$1<a href="$2" target="_blank" rel="nofollow">$2</a>',
	        	$text
	        );
	        $text = substr($text, 1);
	    }
	   	*/
		$text=str_replace('&lt;pre&gt;','<pre>',$text);
		$text=str_replace('&lt;/pre&gt;','</pre>',$text);
	   	$text=nl2br_except_pre($text);
		return $text;
	}


}

/* End of file format_content_helper.php */
/* Location: ./system/helpers/format_content_helper.php */