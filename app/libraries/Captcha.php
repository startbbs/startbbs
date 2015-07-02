<?php 
class Captcha
{
	var $width='60';
	var $num='4';
	var $height='32';
	var $name='randcode';

	public function __construct($conf="")
	{
		if($conf!="")
		{
			foreach($conf as $key=>$value)
			{
				$this->$key=$value;
			}
		}

		
	}
	
	function show()
	{
		$CI = & get_instance();
		$CI->load->library('session');
	    
		//Header("Content-type: image/gif");
		/*
		* 初始化
		*/
		$border = 0; //是否要边框 1要:0不要
		$how = $this->num; //验证码位数
		$w = $this->width; //图片宽度
		$h = $this->height; //图片高度
		$fontsize = 24; //字体大小
		$alpha = "abcdefghijkmnpqrstuvwxyz"; //验证码内容1:字母
		$number = "23456789"; //验证码内容2:数字
		$randcode = ""; //验证码字符串初始化
		srand((double)microtime()*1000000); //初始化随机数种子
		
		$im = imagecreate($w,$h); //创建验证图片
		
		/*
		* 绘制基本框架
		*/
		$bgcolor = imagecolorallocate($im, 255, 255, 255); //设置背景颜色
		ImageFill($im, 0, 0, $bgcolor); //填充背景色
		if($border)
		{
			$black = ImageColorAllocate($im, 0, 0, 0); //设置边框颜色
			ImageRectangle($im, 0, 0, $w-1, $h-1, $black);//绘制边框
		}
		
		/*
		* 逐位产生随机字符
		*/
		for($i=0; $i<$how; $i++)
		{   
			$alpha_or_number = mt_rand(0, 1); //字母还是数字
			$str = $alpha_or_number ? $alpha : $number;
			$which = mt_rand(0, strlen($str)-1); //取哪个字符
			$code = substr($str, $which, 1); //取字符
			$j = !$i ? 4 : $j+15; //绘字符位置
			$color3 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //字符随即颜色

			// 把字符串写在图像左上角
			//imagestring($im, 5, $j, 6, $code, $color3);
			//ImageChar($im, $fontsize, $j, 6, $code, $color3); //绘字符
			// Add the text
			imagettftext($im, 14, 0, $j, 24, $color3, './system/fonts/texb.ttf', $code);
			$randcode .= $code; //逐位加入验证码字符串
		}
		
		/*
		* 添加干扰
		*/
		for($i=0; $i<5; $i++)//绘背景干扰线
		{   
			$color1 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰线颜色
			ImageArc($im, mt_rand(-5,$w), mt_rand(-5,$h), mt_rand(20,300), mt_rand(20,200), 55, 44, $color1); //干扰线
		}  
		for($i=0; $i<$how*5; $i++)//绘背景干扰点
		{   
			$color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰点颜色 
			ImageSetPixel($im, mt_rand(0,$w), mt_rand(0,$h), $color2); //干扰点
		}
		
		$CI->session->set_userdata($this->name, $randcode);
		//ob_clean();
		/*绘图结束*/
		if (imagetypes() & IMG_GIF) {
		    header ("Content-type: image/gif");
		    $img=imagegif ($im);
		}
		elseif (imagetypes() & IMG_JPG) {
        	header ("Content-type: image/jpeg");
		    $img=imagejpeg ($im, "", 0.5);
		}
		elseif (imagetypes() & IMG_PNG) {
        	header ("Content-type: image/png");
		    $img=imagepng ($im, "", 0.5);
	    }
	    return $img;
		ImageDestroy($im);
		/*绘图结束*/
	}
}
?>