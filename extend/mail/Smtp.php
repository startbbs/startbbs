<?php
/*
*	@smtp.php
*	Copyright (c)2013-2018 StartBBS.com
*/
namespace Mail;
class Smtp
{
	private $fp;
	public $error;
	public $host;
	public $port = 25;
	public $user;
	public $pswd;
	public $cmd;
	
	public function __construct($setting = array())
    {
		$this->set($setting);
	}
	
	public function set($setting)
    {
		$setting['host'] && $this->host = $setting['host'];
		$setting['port'] && $this->port = $setting['port'];
		$setting['user'] && $this->user = $setting['user'];
		$setting['pswd'] && $this->pswd = $setting['pswd'];
		return $this;
	}
	
	public function check($mail)
    {
		if(!$this->host || !$this->port || !$this->user || !$this->pswd){
			$this->error = 'unsetting';
			return -1;
		}
		if(!$mail['from'] || !$mail['to'] || !$mail['title'] || !$mail['content']){
			$this->error = 'unconfig';
			return 0;
		}
		return 1;
	}
	
	public function sendmail(array $mail)
    {
		!$mail['from'] && $mail['from'] = $this->user;
		$status = $this->check($mail);
		if($status != 1){
			return false;
		}
		//connect
		if($this->connect() != 220){
			return false;
		}
		if($this->cmd('EHLO '.$this->host) != 250){
			return false;
		}
		//auth
		if($this->cmd('AUTH LOGIN') != 334){
			return false;
		}
		if($this->cmd(base64_encode($this->user)) != 334){
			return false;
		}
		if($this->cmd(base64_encode($this->pswd)) != 235){
			return false;
		}
		//ready
		if($this->cmd('MAIL FROM: <'.$mail['from'].'>') != 250){
			return false;
		}
		
		$to = is_array($mail['to']) ? $mail['to'] : array($mail['to']);
		foreach($to as $email){
			$status = $this->cmd('RCPT TO: <'.$email.'>');
			if(!in_array($status, array(250, 251))){
				return false;
			}
		}
		
		if($this->cmd('DATA') != 354){
			return false;
		}
		//send
		$title = str_replace("\r\n.\r\n", ".", $mail['title']);
		$content = str_replace("\r\n.\r\n", ".", $mail['content']);
		$body = "Date: ".date('r')."\r\n";
		$body .= "Return-Path: ".$mail['from']."\r\n";
		$body .= "From: ".$this->user."<".$mail['from'].">\r\n";
		$body .= "Reply-to: ".$this->user."<".$mail['from'].">\r\n";
		foreach($to as $email){
			$body .= "To: <".$email.">\r\n";
		}
		$body .= "Subject: =?UTF-8?B?".base64_encode($title)."?=\r\n";
		$body .= "Message-ID: <".base64_encode($this->user)."@".$this->host.">\r\n";
		$body .= "X-Priority: 3\r\n";
		$body .= "X-Has-Attach: no\r\n";
		$body .= "X-Mailer: PHP\r\n";
		$body .= "Mime-Version: 1.0\r\n";
		$body .= "Content-Type: text/html; charset=utf-8;\r\n";
		$body .= "\r\n";
		$body .= "$content";
		$body .= "\r\n.";
		if($this->cmd($body) != 250){
			return false;
		}
		$this->cmd('QUIT');
		$this->close();
		return true;
	}
	
	private function connect()
	{
		$this->fp = fsockopen($this->host, $this->port, $errno, $errstr, 10);
		if(!$this->fp){
			$this->error = $errno;
			return false;
		}
		stream_set_timeout($this->fp, 30);
		return $this->getstatus();
	}
	
	private function close()
	{
		@fclose($this->fp);
	}
	
	private function cmd($cmd)
	{
		$this->cmd .= "$cmd\r\n";
		fwrite($this->fp, "$cmd\r\n");
		return $this->getstatus();
	}
	
	private function getstatus()
	{
		$res = fread($this->fp, 1024);
		$this->error = $res;
		return intval(substr($res, 0, 3));
	}
}