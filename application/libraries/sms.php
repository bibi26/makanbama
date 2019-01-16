<?php
/*
dev@epishkhan.ir
usage:
				require_once 'class.smspishkhan.php';
				$mobile = '09123307854';
				$sms = new Smspishkhan();
				$sms->sendasms("test message", $mobile);

		
*/


//You need last nusoap ver
require_once APPPATH."/third_party/nusoap.php";

//A simple wrapper class to smspishkhan.ir sms service
class Sms
{

	var $db,$error,$user='mohammadi',$pass='mypass',$url='http://ws.smspishkhan.ir/SmsService.asmx?wsdl',$lineNo='10007727';

	function Smspishkhan($username=NULL,$password=NULL,$url=NULL)
	{
		$this->user = ($username !== NULL) ? $username : $this->user;
		$this->pass = ($password !== NULL) ? $password : $this->pass;
		if($url !== NULL)
		{
			$this->url = $url;
		}
	}

	private function setHeaders($client)
	{
		$headers = <<<EOT
    <AccountCredentials xmlns="http://smspishkhan.ir/webservices/">
      <username>{$this->user}</username>
      <password>{$this->pass}</password>
    </AccountCredentials>
EOT;
		$client->setHeaders($headers);
		return $client;
	}

	function sendasms($body,$number,$lineNumber=NULL,$type=0,$scheduleTime=NULL)
	{
		$client = new nusoap_client($this->url, TRUE);
		$this->error = $client->getError();
		if ($this->error)
		{
			return $this->error;
		}
		else
		{
			$client->soap_defencoding = 'UTF-8';
			//disable dual utf8 encoding to correct farsi sms issue
			$client->decode_utf8 = false;
			$result = $client->call('sendGeneral', array('username' => $this->user, 'password' => $this->pass, 
					'message' => $body, 'toNumbers' => $number));
                        return $result;
                        
		}
	}

}
?>