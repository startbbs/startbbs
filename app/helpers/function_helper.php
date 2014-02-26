<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 截取中英混排字符串
 * @param (string) $string
 * @param (int) $length
 * @param (string) $dot
 * @param (string) $charset
 */
function sb_substr( $string, $length, $dot = '..', $charset='utf-8' ) {
	$slen = strlen($string);
    if( $slen <= $length ) {
        return $string;
    }
	if( function_exists( 'mb_substr' ) ) {
		return mb_substr( $string, 0, $length, $charset ) . $dot;
	}
    $strcut = '';
    if(strtolower($charset) == 'utf-8') {
        $n = $tn = $noc = 0;
        while($n < $slen) {
            $t = ord($string[$n]);
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 1;
            } elseif(224 <= $t && $t < 239) {
                $tn = 3; $n += 3; $noc += 1;
            } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 1;
            } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 1;
            } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 1;
            } else {
                $n++;
            }
            if($noc >= $length) {
                break;
            }
        }
        if($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
    } else {
        for($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
        }
    }
    
    return $strcut.$dot;
}

/**
 * 清除HTML标记
 *
 * @param	string	$str
 * @return  string
 */
function cleanhtml($str)
{
	$str = strip_tags($str);
	$str = htmlspecialchars($str);
	$str=preg_replace("/\s+/"," ", $str); //过滤多余回车
	 $str = preg_replace("/ /","",$str);
	 $str = preg_replace("/&nbsp;/","",$str);
	 $str = preg_replace("/　/","",$str);
	 $str = preg_replace("/\r\n/","",$str);
	 $str = str_replace(chr(13),"",$str);
	 $str = str_replace(chr(10),"",$str);
	 $str = str_replace(chr(9),"",$str);
	return $str;
}


function check_auth()
{
	$url = 'http://www.startbbs.com/authorize/check_auth/'.get_domain();
	if(function_exists('file_get_contents')) {
		$data=file_get_contents($url);
	} else {
		$ch = curl_init();
		$timeout = 5; 
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
	}
	$data = json_decode($data);
	return $data->product;
}

function get_domain($url=''){
	$host=$url?$url:@$_SERVER[HTTP_HOST]; 
	$host=strtolower($host); 
	if(strpos($host,'/')!==false){ 
		$parse = @parse_url($host); 
		$host = $parse['host']; 
	}
	$topleveldomaindb=array('com','edu','gov','int','mil','net','org','biz','info','pro','name','museum','coop','aero','xxx','idv','mobi','cc','me','cn','tv','in','hk','de','us','tw');
	$str=''; 
	foreach($topleveldomaindb as $v){ 
		$str.=($str ? '|' : '').$v;
	} 
	$matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
	if(preg_match("/".$matchstr."/ies",$host,$matchs)){ 
		$domain=$matchs['0'];
	}else{ 
		$domain=$host; 
	}
	return $domain; 
}

	//无编辑器的过滤
	/*function filter_check ($data)
	{
		$pattern="/<pre>(.*?)<\/pre>/si";
		preg_match_all ($pattern, $data, $matches);
		foreach( $matches[1] as $val ){
			@$replace[] = htmlspecialchars($val);
		}
		$data = str_replace($matches[1], @$replace, $data);
		if(!$matches[1]){
			$data = nl2br($data);
		}
		$data = str_replace('</p><br />','</p>',$data);
		return $data = strip_tags($data,"<p> <font> <img> <b> <strong> <br> <pre> <br /> <span>");
	}*/
	//无编辑器的过滤
	function filter_check ($str)
	{
		$pattern="/<pre[^>]*>(.*?)<\/pre>/si";
		preg_match_all($pattern, $str, $matches);
		$str=htmlspecialchars_decode($str);
		$str=stripslashes($str);
		if($matches[1]){
			foreach($matches[1] as $v){
				$replace[]= addslashes(htmlspecialchars(trim($v)));
			}
			$str = str_replace($matches[1], $replace, $str);
		} else{
			$str=strip_tags($str,"<img> <pre> <a> <font> <span> <em>");
		}
		$str = nl2br($str);
		
		return $str;
	}

function send_mail($username,$password,$to,$subject,$message)
{
	$ci	= &get_instance();
	$config['protocol']=$ci->config->item('protocol');
	$config['smtp_host']=$ci->config->item('smtp_host');
	$config['smtp_user']=$ci->config->item('smtp_user');
	$config['smtp_pass']=$ci->config->item('smtp_pass');
	$config['smtp_port']=$ci->config->item('smtp_port');
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	
	$ci->load->library('email',$config);
	$ci->email->from($config['smtp_user'],'');
	$ci->email->to($to);
	$ci->email->subject($subject.'-'.$ci->config->item('site_name'));
	$ci->email->message($message);
	if($ci->email->send()){
		return true;
	} else
	{
		return false;
	}
}


	function auto_link_pic($str, $type = 'both', $popup = FALSE)
	{
		if ($type != 'email')
		{
			if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches))
			{
				$pop = ($popup == TRUE) ? " target=\"_blank\" " : "";

				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['6'][$i]))
					{
						$period = '.';
						$matches['6'][$i] = substr($matches['6'][$i], 0, -1);
					}
					$img_ext = array('jpg','png','gif','jpeg');
					$file_ext=strtolower(end(explode(".",$matches['0'][$i])));
					if(in_array($file_ext,$img_ext)){
						$str = str_replace($matches['0'][$i],
											$matches['1'][$i].'<img src="http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'" alt="">'.
											$period, $str);
					} else {
						$str = str_replace($matches['0'][$i],
											$matches['1'][$i].'<a href="http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'"'.$pop.'>http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'</a>'.
											$period, $str);
					}
				}
			}
		}

		if ($type != 'url')
		{
			if (preg_match_all("/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $str, $matches))
			{
				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['3'][$i]))
					{
						$period = '.';
						$matches['3'][$i] = substr($matches['3'][$i], 0, -1);
					}

					$str = str_replace($matches['0'][$i], safe_mailto($matches['1'][$i].'@'.$matches['2'][$i].'.'.$matches['3'][$i]).$period, $str);
				}
			}
		}

		return $str;
	}


	function br2nl($text)
	{
		return preg_replace('/<br\\s*?\/??>/i', '', $text);
	}

	//过滤XSS攻击
	function clearxss($val) {
		$val = preg_replace ( '/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val );
		$search = 'abcdefghijklmnopqrstuvwxyz';
		$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$search .= '1234567890!@#$%^&*()';
		$search .= '~`";:?+/={}[]-_|\'\\';
		for($i = 0; $i < strlen ( $search ); $i ++) {
			$val = preg_replace ( '/(&#[xX]0{0,8}' . dechex ( ord ( $search [$i] ) ) . ';?)/i', $search [$i], $val ); // with a ;
			$val = preg_replace ( '/(&#0{0,8}' . ord ( $search [$i] ) . ';?)/', $search [$i], $val ); // with a ;
		}
		$ra1 = Array ('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base' );
		$ra2 = Array ('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload' );
		$ra = array_merge ( $ra1, $ra2 );
		$found = true; // keep replacing as long as the previous round replaced something
		while ( $found == true ) {
			$val_before = $val;
			for($i = 0; $i < sizeof ( $ra ); $i ++) {
				$pattern = '/';
				for($j = 0; $j < strlen ( $ra [$i] ); $j ++) {
					if ($j > 0) {
						$pattern .= '(';
						$pattern .= '(&#[xX]0{0,8}([9ab]);)';
						$pattern .= '|';
						$pattern .= '|(&#0{0,8}([9|10|13]);)';
						$pattern .= ')*';
					}
					$pattern .= $ra [$i] [$j];
				}
				$pattern .= '/i';
				$replacement = substr ( $ra [$i], 0, 2 ) . '<x>' . substr ( $ra [$i], 2 ); // add in <> to nerf the tag
				$val = preg_replace ( $pattern, $replacement, $val ); // filter out the hex tags
				if ($val_before == $val) {
					$found = false;
				}
			}
		}
		return $val;
	}

	function randkey($length)
	{
		 $pattern='1234567890abcdefghijklmnopqrstuvwxyz$#&^@!';
		 for($i=0;$i<$length;$i++)
		 {
		   $key .= $pattern{mt_rand(0,35)};    //生成php随机数
		 }
		 return $key;
	}
/* End of file function_helper.php */
/* Location: ./system/helpers/function_helper.php */