<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Myclass {

	function __construct() {
	$this->ci = & get_instance ();
	}

//生成友好时间形式
function  friendly_date( $from ){
	static $now = NULL;
	$now == NULL && $now = time();
	! is_numeric( $from ) && $from = strtotime( $from );
	$seconds = $now - $from;
	$minutes = floor( $seconds / 60 );
	$hours   = floor( $seconds / 3600 );
	$day     = round( ( strtotime( date( 'Y-m-d', $now ) ) - strtotime( date( 'Y-m-d', $from ) ) ) / 86400 );
	if( $seconds == 0 ){
		return '刚刚';
	}
	if( ( $seconds >= 0 ) && ( $seconds <= 60 ) ){
		return "{$seconds}秒前";
	}
	if( ( $minutes >= 0 ) && ( $minutes <= 60 ) ){
		return "{$minutes}分钟前";
	}
	if( ( $hours >= 0 ) && ( $hours <= 24 ) ){
		return "{$hours}小时前";
	}
	if( ( date( 'Y' ) - date( 'Y', $from ) ) > 0 ) {
		return date( 'Y-m-d', $from );
	}
	
	switch( $day ){
		case 0:
			return date( '今天H:i', $from );
		break;
		
		case 1:
			return date( '昨天H:i', $from );
		break;
		
		default:
			//$day += 1;
			return "{$day} 天前";
		break;
	}
}

	function notice($str)
	{	
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script>'.$str.'</script>';
	}

	/**
	 * 文件或目录权限检查函数
	 *
	 * @access          public
	 * @param           string  $file_path   文件路径
	 * @param           bool    $rename_prv  是否在检查修改权限时检查执行rename()函数的权限
	 *
	 * @return          int     返回值的取值范围为{0 <= x <= 15}，每个值表示的含义可由四位二进制数组合推出。
	 *                          返回值在二进制计数法中，四位由高到低分别代表
	 *                          可执行rename()函数权限、可对文件追加内容权限、可写入文件权限、可读取文件权限。
	 */
	function is_write($file_path)
	{
		/* 如果不存在，则不可读、不可写、不可改 */
		if (!file_exists($file_path))
		{
			return false;
		}
		$mark = 0;
		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
		{
			/* 测试文件 */
			$test_file = $file_path . '/cf_test.txt';
			/* 如果是目录 */
			if (is_dir($file_path))
			{
				/* 检查目录是否可读 */
				$dir = @opendir($file_path);
				if ($dir === false)
				{
					return $mark; //如果目录打开失败，直接返回目录不可修改、不可写、不可读
				}
				if (@readdir($dir) !== false)
				{
					$mark ^= 1; //目录可读 001，目录不可读 000
				}
				@closedir($dir);
				/* 检查目录是否可写 */
				$fp = @fopen($test_file, 'wb');
				if ($fp === false)
				{
					return $mark; //如果目录中的文件创建失败，返回不可写。
				}
				if (@fwrite($fp, 'directory access testing.') !== false)
				{
					$mark ^= 2; //目录可写可读011，目录可写不可读 010
				}
				@fclose($fp);
				@unlink($test_file);
				/* 检查目录是否可修改 */
				$fp = @fopen($test_file, 'ab+');
				if ($fp === false)
				{
					return $mark;
				}
				if (@fwrite($fp, "modify test.\r\n") !== false)
				{
					$mark ^= 4;
				}
				@fclose($fp);
				/* 检查目录下是否有执行rename()函数的权限 */
				if (@rename($test_file, $test_file) !== false)
				{
					$mark ^= 8;
				}
				@unlink($test_file);
			}
			/* 如果是文件 */
			elseif (is_file($file_path))
			{
				/* 以读方式打开 */
				$fp = @fopen($file_path, 'rb');
				if ($fp)
				{
					$mark ^= 1; //可读 001
				}
				@fclose($fp);
				/* 试着修改文件 */
				$fp = @fopen($file_path, 'ab+');
				if ($fp && @fwrite($fp, '') !== false)
				{
					$mark ^= 6; //可修改可写可读 111，不可修改可写可读011...
				}
				@fclose($fp);
				/* 检查目录下是否有执行rename()函数的权限 */
				if (@rename($test_file, $test_file) !== false)
				{
					$mark ^= 8;
				}
			}
		}
		else
		{
			if (@is_readable($file_path))
			{
				$mark ^= 1;
			}
			if (@is_writable($file_path))
			{
				$mark ^= 14;
			}
		}
		return $mark;
	}


	function get_ip() {
		$url = 'http://iframe.ip138.com/ic.asp';
		if(function_exists('curl_init')){
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$a = curl_exec($ch);
		} else
		{
			$a = @file_get_contents($url);
		}
		preg_match('/\[(.*)\]/', $a, $ip);
		return @$ip[1];
	}
	//

function get_domain($url){ 
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

}

/* End of file Myclass.php */