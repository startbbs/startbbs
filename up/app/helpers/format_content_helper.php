<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('format_content'))
{
	function format_content($text)
	{
		//pic
		//$imgurl = '/<img[^>]*src="(http://(.+)/(.+).(jpg|jpe|jpeg|gif|png))"/isU';
//		$img_url = '/(http[s]?:\/\/?('.$options['safe_imgdomain'].').+\.(jpg|jpe|jpeg|gif|png))\w*/';
		//$img_url="/^(http?:\/\/)(.*?)\/(.*?)\.(jpg|jpeg|gif|png)/i";
		//$img_url = '/(http|https):\/\/([^"]+(?:jpg|gif|png|jpeg))/isU';
		$img_url="/(http[s]?:\/\/(.+)\/(.+).(jpg|jpeg|gif|png))/isU";
		//$img_url="/^(https?:\/\/)(.*?)\/(.*?)\.(jpg|gif|png|jpeg|jpe)/i";

		$img_tag='/<img.+src=(\'|\"|)?(.*)(\1)(?:[\s].*)?>/ismUe';
		//$img_tags=preg_match($img_tag, $text);
		preg_match_all($img_tag, $text, $src);
		if(count($src[2])>0){
			foreach( $src[2] as $k=>$v)
			{
				$text = str_replace($src[0][$k], $v, $text);
			}
		
		}

		if(preg_match($img_url, $text)){
			$text = preg_replace($img_url, '<img src="\1" alt="" />', $text);
	   	}
	   	//preg_match_all($img_url, $text,$arr);
   		
   		
   		//$text= $arr[0][0];

    	// 视频地址识别。
	    // youku
		if(strpos($text, 'player.youku.com')){
		    $text = preg_replace('/http:\/\/player.youku.com\/player.php\/sid\/([a-zA-Z0-9\=]+)\/v.swf/', '<embed src="http://player.youku.com/player.php/sid/\1/v.swf" quality="high" width="590" height="492" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $text);
		}
		
	    if(strpos($text, 'v.youku.com')){
	        $text = preg_replace('/http:\/\/v.youku.com\/v_show\/id_([a-zA-Z0-9\=]+)(\/|.html?)?/', '<embed src="http://player.youku.com/player.php/sid/\1/v.swf" quality="high" width="590" height="492" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $text);
	    }
	    // tudou
	    if(strpos($text, 'www.tudou.com')){
	        if(strpos($text, 'programs/view')){
	            $text = preg_replace('/http:\/\/www.tudou.com\/(programs\/view|listplay)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<embed src="http://www.tudou.com/v/\2/" quality="high" width="600" height="420" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $text);
	        }elseif(strpos($text, 'albumplay')){
	            $text = preg_replace('/http:\/\/www.tudou.com\/(albumplay)\/([a-zA-Z0-9\=\_\-]+)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<embed src="http://www.tudou.com/a/\2/" quality="high" width="600" height="420" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $text);
	        }else{
	            $text = preg_replace('/http:\/\/www.tudou.com\/(programs\/view|listplay)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<embed src="http://www.tudou.com/l/\2/" quality="high" width="600" height="420" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $text);
	        }
	    }


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
		return $text;
	}
}

/* End of file format_content_helper.php */
/* Location: ./system/helpers/format_content_helper.php */