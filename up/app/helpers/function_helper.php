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
	$str=preg_replace("/\s+/"," ", $str); //过滤多余回车
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




/* End of file function_helper.php */
/* Location: ./system/helpers/function_helper.php */