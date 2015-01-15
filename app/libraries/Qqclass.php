<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Qqclass {

	//登陆函数
    function qq_login($state, $appid, $scope, $callback)
	{
		$login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
			. $appid . "&redirect_uri=" . urlencode($callback)
			. "&state=" . $state
			. "&scope=".$scope;
		header("Location:$login_url");
	}
	//登陆返回函数
	function qq_callback($inputs, $appid, $appkey, $callback)
	{
		//debug
		//print_r($inputs);
		//print_r($qqlogin);
		//var_dump($inputs);
		if($inputs['state'] == $inputs['state']) //csrf
		{
			$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
				. "client_id=" . $appid. "&redirect_uri=" . urlencode($callback)
				. "&client_secret=" . $appkey. "&code=" . $inputs["code"];
	
			$response = file_get_contents($token_url);
			if (strpos($response, "callback") !== false)
			{
				$lpos = strpos($response, "(");
				$rpos = strrpos($response, ")");
				$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
				$msg = json_decode($response);
				if (isset($msg->error))
				{
					//echo "<h3>error:</h3>" . $msg->error;
					//echo "<h3>msg  :</h3>" . $msg->error_description;
					exit;
				}
			}
	
			$params = array();
			parse_str($response, $params);
	
			//debug
			//print_r($params);
	
			//set access token to session
			return $params["access_token"];
		}
		/*else 
		{
			echo("The state does not match. You may be a victim of CSRF.");
		}*/
	}
	
	function get_openid($inputs,$access_token)
	{
		$graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" . $access_token;
	
		$str  = file_get_contents($graph_url);
		if (strpos($str, "callback") !== false)
		{
			$lpos = strpos($str, "(");
			$rpos = strrpos($str, ")");
			$str  = substr($str, $lpos + 1, $rpos - $lpos -1);
		}
	
		$user = json_decode($str);
		if (isset($user->error))
		{
			//echo "<h3>error:</h3>" . $user->error;
			//echo "<h3>msg  :</h3>" . $user->error_description;
			exit;
		}
	
		//debug
		//echo("Hello " . $user->openid);
	
		//set openid to session
		return $user->openid;
		//var_dump();
	}
	//获取用户信息
	function get_user_info($access_token, $appid, $open_id)
	{
		$get_user_info = "https://graph.qq.com/user/get_user_info?"
			. "access_token=" . $access_token
			. "&oauth_consumer_key=" . $appid
			. "&openid=" . $open_id
			. "&format=json";
	
		$info = file_get_contents($get_user_info);
		$arr = json_decode($info, true);
	
		return $arr;
	}
}

/* End of file Qqloginclass.php */