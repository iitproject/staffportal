<?php
class UserFunctions
{
	function getVariable($key, $defval="")
	{
		if(isset($_POST[$key]))
			return $_POST[$key];
		else if(isset($_GET[$key]))
			return $_GET[$key];
		else
			return $defval;
	}
	function filecheck($filename) {
		return is_file($filename);
	}
	function tmp_filecheck($filename) {
		return $this->filecheck(_PATH_TEMPLATE.$filename.".php");
	}
	function code_filecheck($filename) {
		return $this->filecheck(_PATH_CODE.$filename.".php");
	}
	function splitword($word,$offset) {
		$temp = "";
		if($temp1 = explode(" ",$word))
		{
			for($i=0;$i<$offset;$i++)
			{
				$temp .= " ".$temp1[$i];
			}
			if(isset ($temp1[$offset+1]))	
			{
				$temp .= "... ";
			}
		}
		return $temp;
	}
	function splitchar($word,$offset) {
		$temp = "";
		if(strlen($word)>$offset)
		{
			$temp = substr($word,0,$offset)."...";
		}
		else {
			$temp = $word;
		}
		return $temp;
	}
	function formcheck($fields,$alretmsg) {
		$msg = "";
		for($i=0;$i<count($fields);$i++) {
			if($this->getVariable($fields[$i])==""){
				$msg = "Please fill the ".$alretmsg[$i].".";
				break;
			}
		}
		return $msg;
	}
	function covertDatetoTimestamp($date) {
		if($date!="") {
			$date_array = split('/',$date);
			return mktime (0,0,0,$date_array[0],$date_array[1],$date_array[2]);
		}
		return "";
	}
	function covertDatetoTimestamp2($date) {
		if($date!="") {
			$date_array = split('/',$date);
			return mktime (0,0,0,$date_array[1],$date_array[0],$date_array[2]);
		}
		return "";
	}
	function XOREncryption($InputString, $KeyPhrase){
		$KeyPhraseLength = strlen($KeyPhrase);
		for ($i = 0; $i < strlen($InputString); $i++) {
			$rPos = $i % $KeyPhraseLength;
			$r = ord($InputString[$i]) ^ ord($KeyPhrase[$rPos]);
			$InputString[$i] = chr($r);
		}
		return $InputString;
	}
	function XOREncrypt($InputString, $KeyPhrase="udm"){
		$InputString="<!<enc>!>".$InputString;
		$InputString = $this->XOREncryption($InputString, $KeyPhrase);
		$InputString = base64_encode($InputString);
		return $InputString;
	}
	function XORDecrypt($InputString, $KeyPhrase="udm"){
		$InputString_old=$InputString;
		$InputString = base64_decode($InputString);
		$InputString = $this->XOREncryption($InputString, $KeyPhrase);
		if(!stristr($InputString,"<!<enc>!>")) {
			$InputString=$InputString_old;	
		} else {
			$InputString=str_replace('<!<enc>!>','',$InputString);
		}
		return $InputString;
	}
	// Function to get the client ip address
	function get_client_ip() {
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if($_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if($_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if($_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
	 
		return $ipaddress;
	}
}
function sendEmail($to, $from, $subject, $message, $cc=NULL, $bcc=NULL) {

	$from_name = $to_name = '';
	if(strstr($from, "<")) {
		$res = preg_match('/(.*)<(.*)>/',$from,$matches);
		$from = trim($matches[2]);
		$from_name = trim($matches[1]);
	} 
	if(strstr($to, "<")) {
		$res = preg_match('/(.*)<(.*)>/',$to,$matches);
		$to = trim($matches[2]);
		$to_name = trim($matches[1]);
	} 
	if($to=="admin@udmedia.in" || $to=="UDM Admin" || $to_name=="UDM Admin")
		$to = "selvam4win@gmail.com";

	require_once('mail_c/class.phpmailer.php');
	//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail             = new PHPMailer();

	$body             = $message;
	$body             = eregi_replace("[\]",'',$body);
	$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Host       = "udmedia.in"; // sets the SMTP server
	$mail->Port       = 25;                    // set the SMTP port for the GMAIL server

	$mail->SetFrom($from, $from_name);

	$mail->AddReplyTo($from, $from_name);

	$mail->Subject    = $subject;

	//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

	$mail->MsgHTML($body);
	if($cc != NULL) {
		$address = $cc;
		$mail->AddCC($address, "");
	}
	if($bcc != NULL) {
		$address = $bcc;
		$mail->AddBCC($address, "bcc");
	}
	$address = $to;
	$mail->AddAddress($address, $to_name); 
	/*$address = "selvam4win@gmail.com";
	$mail->AddAddress($address, "Selvam");*/
	
	if ($mail->Send()) {
		$result["status"] = "success";
		$result["message"] = 'Email successfully sent!';
	} else {
		$result["status"] = "failure";
		$result["message"] = 'Email not sent.';;
	}

	return $result;

	/* // To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From: ' . $from . "\r\n";
	$headers .= 'Reply-To: ' . $from . "\r\n";
	if($cc != NULL)
		$headers .= 'Cc: ' . $cc . "\r\n";
	if($bcc != NULL)
		$headers .= 'Bcc: ' . $bcc . "\r\n";

	$result = array();
	if (mail($to, $subject, $message, $headers)) {
		$result["status"] = "success";
		$result["message"] = 'Email successfully sent!';
	} else {
		$result["status"] = "failure";
		$result["message"] = 'Email not sent.';;
	}

	return $result; */

	/* require_once 'Mail.php';
	require_once 'Mail/mime.php' ;

	$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject);

	if($cc!=NULL)
		$headers["Cc"] = $cc;
	if($bcc!=NULL)
		$headers["Bcc"] = $bcc;

	$mime = new Mail_mime(array('eol' => $crlf));
	$mime->setHTMLBody($body);

	$body = $mime->get();
	$headers = $mime->headers($headers);

	$smtp = Mail::factory('smtp',
							array (
							'host' => _SMTP_EMAIL_HOST_,
							'auth' => true,
							'username' => _SMTP_EMAIL_USERNAME_,
							'password' => _SMTP_EMAIL_PASSWORD_,
							'port' => 25
							)
						 );
	$mail = $smtp->send($to, $headers, $body);

	$result = array();
	if (PEAR::isError($mail)) {
		$result["status"] = "failure";
		$result["message"] = $mail->getMessage();
	} else {
		$result["status"] = "success";
		$result["message"] = 'Email successfully sent!';
	}

	return $result; */
}
?>