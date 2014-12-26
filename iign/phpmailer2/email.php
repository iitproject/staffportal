<?php
/**
*
* SMTP4PHP :  PHP powerful tool for sending e-mails fast and easily.
*
* SMTP4PHP is a collection of PHP classes, dedicated for composing and sending 
* multipart/mixed email messages quickly and easily, with or without embedded 
* images and/or attachments.
*
* Copyright (c) 2011 - 2012, Raul IONESCU <ionescu.raul@gmail.com>, 
* Bucharest, ROMANIA
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @package      SMTP4PHP
* @author       Raul IONESCU <ionescu.raul@gmail.com>
* @copyright    Copyright (c) 2011 - 2012, Raul IONESCU.
* @license      http://www.opensource.org/licenses/mit-license.php The MIT License
* @version      2011, 6th release  
* @link         https://plus.google.com/u/0/109110210502120742267
* @access       public
*
* PHP versions 5.3 or greater
*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
function exception_error_handler($errno, $errstr, $errfile, $errline ) 
{ throw new ErrorException($errstr, $errno, 0, $errfile, $errline); }
/*///////////////////////////////////////////////////////////////////////////////////////*/
set_error_handler("exception_error_handler");
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
class eMailUser implements Iterator
{
const VERSION = eMail::VERSION;
const RELEASE = eMail::RELEASE;

protected $user;
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __construct($name = NULL, $email = NULL) 
{ 
if($email) { $this->email = self::validateEmail($email); }
if($name)  { $this->name = trim($name); }
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __get($property) 
{
switch($property = strtoupper(trim($property)))
	{
         case 'NAME':
	 case 'EMAIL':
		return (isset($this->user[$property]))?($this->user[$property]):(NULL);
                
	 default:
		return NULL;
	}
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __set($property, $value)
{
switch($property = strtoupper(trim($property)))
        {
         case 'NAME':
                return $this->user[$property] = trim($value);
        
         case 'EMAIL':
                return $this->user[$property] = self::validateEmail($value);
                
	 default:
		return NULL;
        }
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public static function validateEmail($email)  
{ 
if(filter_var($email = strtolower(trim($email)), FILTER_VALIDATE_EMAIL)) { return $email; } 
else { throw new Exception('Invalid e-mail address: "'.$email.'" !'); }
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __toString()            { return (($this->name)?('"'.$this->name.'" '):('')).(($this->email)?('<'.$this->email.'>'):('')); }
public function __invoke($property)     { return $this->$property; }
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function current()               { return current($this->user); }
public function key()                   { return key($this->user); }
public function next()                  { return next($this->user); }
public function rewind()                { return reset($this->user); }
public function valid()                 { return isset($this->user[$this->key()]); }
/*///////////////////////////////////////////////////////////////////////////////////////*/
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
class eMail
{
const VERSION = 2011;
const RELEASE = 6;
const PRIORITY_LOW = 5;
const PRIORITY_NORMAL = 3;
const PRIORITY_HIGH = 1;
const CONTENT_TRANSFER_ENCODING_TEXT = 1;
const CONTENT_TRANSFER_ENCODING_BASE64 = 2;

protected $mixedBoundary;
protected $altBoundary;
protected $returnPath;
protected $returnReceipt;
protected $from;
protected $replyTo;
protected $to;
protected $cc;
protected $bcc;
protected $priority;
protected $charset;
protected $contentTransferEncoding;
protected $subject;
protected $htmlMessage;
protected $textMessage;
protected $images;
protected $attachments;



protected function _generateRandomString() { return md5(uniqid(rand(),true)); }
protected function _generateBoundary()     { return $this->_generateRandomString().(($this->from) && (preg_match('/(@.+)$/i',$this->from->email, $m) && is_array($m) && ($m = $m[0]))?($m):($this->_generateRandomString())); }
public function __construct(eMailUser $from = NULL, $to = NULL, $subject = NULL, $htmlMessage = NULL, $textMessage = NULL)
{
$this->From = $from;
$this->To = $to;
$this->priority = self::PRIORITY_NORMAL;
$this->charset = 'iso-8859-1';
$this->contentTransferEncoding = self::CONTENT_TRANSFER_ENCODING_BASE64;
$this->Subject = $subject;
$this->HTMLMessage = $htmlMessage;
$this->TXTMessage = $textMessage;
$this->images = array();
$this->attachments = array();
$this->mixedBoundary = '--=_'.$this->_generateBoundary();
$this->altBoundary  = '--=_'.$this->_generateBoundary();
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __get($property)
{
switch(strtoupper(trim($property)))
	{
		case 'PRIORITY':
                        return $this->priority;
                        
                case 'CONTENTTRANSFERENCODING': 
                        return $this->contentTransferEncoding;
                        
		case 'RETURNPATH':
                        return $this->returnPath;
                        
		case 'RETURNRECEIPT':
                        return $this->returnReceipt;
                        
		case 'FROM':
                        return $this->from;
                        
		case 'REPLYTO':
                        return $this->replyTo;
                        
		case 'TO':
                        return $this->to;
                        
		case 'CC':
                        return $this->cc;
                        
		case 'BCC':
                        return $this->bcc;
                        
		case 'SUBJECT':
                        return $this->subject;
                        
		case 'HTMLMESSAGE':
                        return $this->htmlMessage;
                        
                case 'TEXTMESSAGE':
                case 'TXTMESSAGE':
                        return $this->textMessage; 
                        
                case 'RAWMESSAGE':
                        return $this->__toString();
                        
		default:
                        return NULL;
	}

}
/*///////////////////////////////////////////////////////////////////////////////////////*/
protected function _set(&$property,&$value)
{
try
	{
	 if($value)
         	{ 
                 if($value instanceof eMailUser) { return $property = array($value); }
                 else if(is_array($value))
				{
				 $values = new stdClass();
                                 $values->values = array();
				 array_walk_recursive($value, create_function('$value, $key, $obj', 'array_push($obj->values, $value);'), $values);  
                                 $values = $values->values;
                                 foreach($values as $k=>$v) { if(!$v instanceof eMailUser) { unset($value[$k]); } }
                                 return $property = $values; 
                                }
         	}
	 else { if(empty($property)) { return $property = array(); } }
	}
catch(Exception $e) { return NULL; }
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __set($property, $value)
{
switch(strtoupper(trim($property)))
	{
		case 'PRIORITY':
                        return $this->priority = ((($value == self::PRIORITY_HIGH) || ($value == self::PRIORITY_LOW))?($value):(self::PRIORITY_NORMAL));
                        
                case 'CONTENTTRANSFERENCODING':
                        return $this->contentTransferEncoding = (($value == self::CONTENT_TRANSFER_ENCODING_BASE64)?(self::CONTENT_TRANSFER_ENCODING_BASE64):(self::CONTENT_TRANSFER_ENCODING_TEXT));
                        
		case 'RETURNPATH':
                        return ($value && ($value instanceof eMailUser))?($this->returnPath = $value):(NULL);
                        
                case 'RETURNRECEIPT':
                        return ($value && ($value instanceof eMailUser))?($this->returnReceipt = $value):(NULL);
                        
		case 'FROM':
                        return ($value && ($value instanceof eMailUser))?($this->from = $value):(NULL);
                        
		case 'REPLYTO':
                        return ($value && ($value instanceof eMailUser))?($this->replyTo = $value):(NULL);
                        
		case 'TO':
                        return $this->_set($this->to, $value);
                        
		case 'CC':
                        return $this->_set($this->cc, $value);
                        
		case 'BCC':
                        return $this->_set($this->bcc, $value);
                        
		case 'SUBJECT':
                        return $this->subject = trim(strip_tags($value));
                        
		case 'HTMLMESSAGE':
                        return $this->htmlMessage = trim($value);
                        
                case 'TEXTMESSAGE':
                case 'TXTMESSAGE':
                        return $this->textMessage = preg_replace('/[\f\t ]{2,}/mS', ' ', trim(strip_tags($value)));
                        
		default:
                        return NULL;
	}
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function addImage($imageURI)
{
try
        {
	 $info = getimagesize($imageURI);         
	 $cid = $this->_generateRandomString();

         $msg  = '--'.$this->mixedBoundary.PHP_EOL;
         $msg .= 'Content-Location: "'.basename($imageURI).'"'.PHP_EOL;
         $msg .= 'Content-Type: '.image_type_to_mime_type($info[2]).PHP_EOL; 
         $msg .= 'Content-Transfer-Encoding: base64'.PHP_EOL;
         $msg .= 'Content-ID: <'.$cid.'>'.PHP_EOL;
         $msg .= 'Content-Disposition: inline; filename="'.basename($imageURI).'"'.PHP_EOL.PHP_EOL;

         $msg .= chunk_split(base64_encode(file_get_contents($imageURI))).PHP_EOL;
         $this->images[$cid] = $msg;
         return 'cid:'.$cid;
        }
catch(Exception $e) { return NULL; }
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function addAttachment($attachmentURI)
{
try
        {
         $cid = $this->_generateRandomString();
         
         $msg  = '--'.$this->mixedBoundary.PHP_EOL;
         $msg .= 'Content-Type: binary/octet-stream'.PHP_EOL; 
         $msg .= 'Content-Transfer-Encoding: base64'.PHP_EOL;
         $msg .= 'Content-ID: <'.$cid.'>'.PHP_EOL;
         $msg .= 'Content-Disposition: attachment; filename="'.basename($attachmentURI).'"'.PHP_EOL.PHP_EOL;
         
         $msg .= chunk_split(base64_encode(file_get_contents($attachmentURI))).PHP_EOL;
         $this->attachments[$cid] = $msg;
         return $cid;
        }
catch(Exception $e) { return NULL; }
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __toString() 
{
try
        {
         $msg = '';
	 if($this->returnPath) { $msg .= 'Return-Path: <'.$this->returnPath->email.'>'.PHP_EOL; }
         if($this->replyTo)    { $msg .= 'Reply-To: '.$this->replyTo.PHP_EOL; }
         $msg .= 'From: '.$this->from.PHP_EOL; 
	 if(($this->to)  && is_array($this->to) && count($this->to))    { $msg .= 'To: '.implode(', ',$this->to).PHP_EOL; }
	 if(($this->cc)  && is_array($this->cc) && count($this->cc))    { $msg .= 'Cc: '.implode(', ',$this->cc).PHP_EOL; }
         $msg .= 'Subject: '.$this->subject.PHP_EOL;
         $msg .= 'X-Priority: '.$this->priority.PHP_EOL;				
         $msg .= 'X-MSMail-Priority: '.(($this->priority == self::PRIORITY_HIGH)?('High'):(($this->priority == self::PRIORITY_LOW)?('Low'):('Normal'))).PHP_EOL;
         $msg .= 'X-Mailer: SMTP4PHP '.(self::VERSION).', '.(self::RELEASE).'th release / PHP '.phpversion().PHP_EOL;
         if($this->returnReceipt) { $msg .= ' X-Confirm-Reading-To: '.$this->returnReceipt.PHP_EOL; }
         $msg .= 'MIME-Version: 1.0'.PHP_EOL;
         $msg .= 'Content-Type: multipart/mixed; boundary="'.$this->mixedBoundary.'"'.PHP_EOL; 
         $msg .= 'Date: '.date('r').PHP_EOL;
         if($this->returnReceipt) { $msg .= 'Disposition-Notification-To: '.$this->returnReceipt.PHP_EOL; }
         if($this->returnReceipt) { $msg .= 'Return-Receipt-To: '.$this->returnReceipt.PHP_EOL; }
	 $msg .= PHP_EOL;
         $msg .= '--'.$this->mixedBoundary.PHP_EOL;
         $msg .= 'Content-Type: multipart/alternative; boundary="'.$this->altBoundary.'"'.PHP_EOL.PHP_EOL;       
         $msg .= '--'.$this->altBoundary.PHP_EOL;
         /*/////////////////////////////////////////*/
         /* text message */
         /*/////////////////////////////////////////*/
         $msg .= 'Content-Type: text/plain; charset="'.$this->charset.'"'.PHP_EOL;
         if($this->contentTransferEncoding == self::CONTENT_TRANSFER_ENCODING_BASE64)
                {
                 $msg .= 'Content-Transfer-Encoding: base64'.PHP_EOL.PHP_EOL;
                 $msg .= chunk_split(base64_encode($this->textMessage));
                }
         else   {
                 $this->textMessage = preg_replace('/^\.$/imsSU','..',$this->textMessage);
                 $msg .= 'Content-Transfer-Encoding: 8bit'.PHP_EOL.PHP_EOL;
                 $msg .= $this->textMessage;
                }         
         $msg .= PHP_EOL.PHP_EOL;
         $msg .= '--'.$this->altBoundary.PHP_EOL;
         /*/////////////////////////////////////////*/         
         /* html message */
         /*/////////////////////////////////////////*/
         if(empty($this->htmlMessage))
                { $this->htmlMessage = nl2br($this->TXTMessage); }
         $msg .= 'Content-type: text/html; charset="'.$this->charset.'"'.PHP_EOL; 
         if($this->contentTransferEncoding == self::CONTENT_TRANSFER_ENCODING_BASE64)
                { $msg .= 'Content-Transfer-Encoding: base64'; }
         else   { $msg .= 'Content-Transfer-Encoding: 8bit'; }       
         $msg .= PHP_EOL.PHP_EOL;
         if(preg_match('/<\/{0,1}(html|head|body.*)>/imsSU',$this->htmlMessage))
                { 
                 $htmlMsg = $this->htmlMessage; 
                 if($this->contentTransferEncoding == self::CONTENT_TRANSFER_ENCODING_BASE64)
                        { $htmlMsg = chunk_split(base64_encode($htmlMsg));  }
                }
         else
                {
                 $htmlMsg  = '<html>'.PHP_EOL;
                 $htmlMsg .= '<head>'.PHP_EOL;
                 $htmlMsg .= '<meta http-equiv="content-type" content="text/html; charset="'.$this->charset.'">'.PHP_EOL;
                 $htmlMsg .= '</head>'.PHP_EOL;
                 $htmlMsg .= '<body style="margin-top:0px; margin-bottom:0px; margin-right:0px; margin-left:0px;">'.PHP_EOL;
                 $htmlMsg .= $this->htmlMessage.PHP_EOL;
                 $htmlMsg .= '<br><br></body></html>'; 
                 if($this->contentTransferEncoding == self::CONTENT_TRANSFER_ENCODING_BASE64)
                        { $htmlMsg = chunk_split(base64_encode($htmlMsg));  }
                } 
         $msg .= $htmlMsg; unset($htmlMsg);         
         $msg .= PHP_EOL.PHP_EOL;
         $msg .= '--'.$this->altBoundary."--".PHP_EOL.PHP_EOL;
         /*/////////////////////////////////////////*/
         /* add images */
         /*/////////////////////////////////////////*/
         $msg .= implode('',$this->images); 
         /*/////////////////////////////////////////*/
         /* add attachments */
         /*/////////////////////////////////////////*/
         $msg .= implode('',$this->attachments); 
         $msg .= '--'.$this->mixedBoundary.'--'.PHP_EOL;
	 $msg .= '.'.PHP_EOL; 
         
         return $msg;
        } 
catch(Exception $e) { return NULL; }
}
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
class SMTP
{
const VERSION = eMail::VERSION;
const RELEASE = eMail::RELEASE;

private $bufferSize = 8192;
private $ip;

protected $encryption;
protected $smtpConnect;

protected $SMTPlog;
protected $SMTPserver;
protected $SMTPport;
protected $SMTPconnectionTimeout;
protected $SMTPuser;
protected $SMTPpassword;
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __construct($SMTPserver = '', $SMTPport = 25, $SMTPuser = '', $SMTPpassword = '')
{
$this->SMTPServer   = $SMTPserver;
$this->SMTPPort     = (($SMTPport)?($SMTPport):(25));
$this->SMTPUser     = $SMTPuser;
$this->SMTPPassword = $SMTPpassword;
$this->SMTPConnectionTimeout = 30;
$this->ip = (isset($_SERVER['LOCAL_ADDR']))?($_SERVER['LOCAL_ADDR']):(gethostbyname(gethostbyaddr('127.0.0.1')));
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __destruct()
{ $this->_disconnect(); }
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __get($property)
{
switch(strtoupper(trim($property)))
	{
		case 'SERVER':
                case 'SMTPSERVER':
                        return $this->SMTPserver;
                        
                case 'PORT':
                case 'SMTPPORT':
                        return $this->SMTPport;
                        
                case 'CONNECTIONTIMEOUT':
                case 'SMTPCONNECTIONTIMEOUT':
                        return $this->SMTPconnectionTimeout;
                        
                case 'USER':
                case 'SMTPUSER':
                        return $this->SMTPuser;
                        
                case 'PASSWORD':
                case 'SMTPPASSWORD':
                        return $this->SMTPpassword;
                        
		case 'LOG':
		case 'SMTPLOG':
                        return implode('', $this->SMTPlog);
                        
		default:
                        return NULL;
	}
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function __set($property, $value)
{

switch(strtoupper(trim($property)))
	{
		case 'SERVER':
                case 'SMTPSERVER':
                        $value = trim($value);
                        $this->encryption = (preg_match('/^(ssl|tls):\/\//i',$value,$m) && is_array($m) && isset($m[1]))?(strtolower($m[1])):('');
                        $this->SMTPserver = preg_replace('/^.*:\/\//','',$value,1); 
                        return $this->SMTPserver;
                        
                case 'PORT':
                case 'SMTPPORT':
                        $value = abs(intval(preg_replace('/[^0-9]/','',$value)));
                        return $this->SMTPport = ($value)?($value):(25);
                        
                case 'CONNECTIONTIMEOUT':                                
                case 'SMTPCONNECTIONTIMEOUT':
                        $value = abs(intval(preg_replace('/[^0-9]/','',$value)));
                        return $this->SMTPconnectionTimeout = ($value)?($value):(30);
                        
                case 'USER':
                case 'SMTPUSER':
                        return $this->SMTPuser = trim($value);
                        
                case 'PASSWORD':
                case 'SMTPPASSWORD':
                        return $this->SMTPpassword = $value;
                        
		default:
                        return NULL;
	}
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
protected function _read()
{ 
$response='';
while($chunk = fread($this->smtpConnect,$this->bufferSize))
        { 
         $response .= $chunk;
         if(feof($this->smtpConnect) || preg_match('/^\d{3}[^-]/mSU',$chunk)) { break; }
        }
return $this->SMTPlog[] = $response;        
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
protected function _write($smtpCommand)
{ 
return fputs($this->smtpConnect, $this->SMTPlog[] = $smtpCommand); 
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
protected function _exec($smtpCommand, $expectedResponse = NULL)
{
$smtpCommand = trim($smtpCommand).PHP_EOL;
$this->_write($smtpCommand); 
$smtpResponse = $this->_read();
if($expectedResponse && (!preg_match('/^'.$expectedResponse.'/S', $smtpResponse))) { throw new Exception('Unexpected SMTP error! (SMTP command: "'.$smtpCommand.'" SMTP response: "'.$smtpResponse.'")'); }
return $smtpResponse;
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
protected function _disconnect()
{
if(!empty($this->smtpConnect)) 
        { 
         try { $this->_exec('QUIT'); } catch(Exception $e) { }
         try { fclose($this->smtpConnect); } catch(Exception $e) { } 
        }
$this->smtpConnect = NULL;
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
protected function _connect()
{
if(empty($this->smtpConnect))
        {
         $this->smtpConnect = fsockopen((($this->encryption == 'ssl')?($this->encryption.'://'):('')).$this->SMTPserver, $this->SMTPport, $errno, $errstr, $this->SMTPconnectionTimeout); 
         $smtpResponse = trim($this->_read());
         if(empty($this->smtpConnect)) { throw new Exception('SMTP connection error!'.($smtpResponse)?(' ('.$smtpResponse.')'):('')); }
         $xxLO = (stripos($smtpResponse,'ESMTP') !== FALSE)?('EHLO'):('HELO'); 
         
         stream_set_blocking($this->smtpConnect, true);
         $smtpResponse = $this->_exec($xxLO.' '.$this->ip,'250');
         
         if($this->encryption == 'tls')
                {
                 $this->_exec('STARTTLS','220');
                 if(!stream_socket_enable_crypto($this->smtpConnect, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) { throw new Exception('Unexpected TLS encryption error!'); }
                }

         if(($this->SMTPuser) || (preg_match('/\d{3} AUTH LOGIN/imsSU',$smtpResponse)))
                { 
                 $this->_exec('AUTH LOGIN','334');
                 $this->_exec(base64_encode($this->SMTPuser),'334');
                 $this->_exec(base64_encode($this->SMTPpassword),'235');
                }
        }        
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
public function send()
{ 
try
        {
         $functionArguments = func_get_args();
         $emails = new stdClass();
         $emails->emails = array();
	 array_walk_recursive($functionArguments, create_function('$value, $key, $obj', 'array_push($obj->emails, $value);'), $emails);  
	 unset($functionArguments);
         $emails = $emails->emails;
         
         $this->SMTPlog = array();
         $this->_connect();
                
         foreach($emails as $e)
		{
                 if($e instanceof eMail) 
			{ 
                         try { $this->_exec('MAIL FROM: <'.$e->from->email.'>','250'); }
                         catch(Exception $e) { $this->_exec('RSET'); throw $e; }

			 if(is_array($e->to))   { foreach($e->to  as $rcpt) { $this->_exec('RCPT TO: <'.$rcpt->email.'>','250'); } }
			 if(is_array($e->cc))   { foreach($e->cc  as $rcpt) { $this->_exec('RCPT TO: <'.$rcpt->email.'>','250'); } }
			 if(is_array($e->bcc))  { foreach($e->bcc as $rcpt) { $this->_exec('RCPT TO: <'.$rcpt->email.'>','250'); } }
                                
                         try { $this->_exec('DATA','354'); }
                         catch(Exception $e) { $this->_exec('RSET'); throw $e; }

                         try { $this->_exec($e->RawMessage,'250'); }
                         catch(Exception $e) { $this->_exec('RSET'); throw $e; }

                         try { $this->_exec('NOOP','250'); } 
                         catch(Exception $e) { }
			} 
         	}
        }
catch(Exception $e)
        {
         $this->_disconnect();
	 throw $e;
        }
}
}
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////////////////////////////////////////*/

?>
