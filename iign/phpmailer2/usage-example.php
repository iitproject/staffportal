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
define('DISPLAY_ERRORS', true);
define('DISPLAY_EXCEPTIONS', true);

set_time_limit(0);
ini_set('memory_limit',-1);
ini_set('max_execution_time',0);
ini_set('ignore_user_abort','On');
ini_set('display_errors', (DISPLAY_ERRORS)?(1):(0));
ini_set('display_startup_errors', (DISPLAY_ERRORS)?(1):(0));
error_reporting((DISPLAY_ERRORS)?(1):(0));
ignore_user_abort (true);
//date_default_timezone_set('Europe/Bucharest');
/*///////////////////////////////////////////////////////////////////////////////////////*/
require_once('email.php');

define('SMTP_SERVER','127.0.0.1');
define('SMTP_SERVER_PORT',25);

/*

GMail - TLS encryption example 
==============================================
define('SMTP_SERVER','tls://smtp.gmail.com');
define('SMTP_SERVER_PORT',587);

GMail - SSL encryption example 
==============================================
define('SMTP_SERVER','ssl://smtp.gmail.com');
define('SMTP_SERVER_PORT',465);

Yahoo Mail - SSL encryption example
==============================================
define('SMTP_SERVER','ssl://smtp.mail.yahoo.com');
define('SMTP_SERVER_PORT',465);

Windows Live.com - TLS encryption example
==============================================
define('SMTP_SERVER','tls://smtp.live.com');
define('SMTP_SERVER_PORT',587);

*/

define('SMTP_SERVER','tls://smtp.gmail.com');
define('SMTP_SERVER_PORT',587);
define('SMTP_USER','panneerselvam28@gmail.com');
define('SMTP_PASSWORD','selvam*2086');

define('FROM_NAME','Selvam');
define('FROM_EMAIL','panneerselvam28@gmail.com');

$subject     = 'SUBJECT';
$image       = './image.jpg';

$e1 = new eMail();
$e1->from = new eMailUser(FROM_NAME, FROM_EMAIL);
$e1->to = array(new eMailUser('Raja', 'selvam4win@gmail.com'),new eMailUser(NULL, 'selvam4win@gmail.com'));
$e1->subject = $subject;
$e1->htmlMessage = 'This is a HTML message!<br><img src="'.$e1->addImage($image).'" border="0">';
$e1->txtMessage = 'This is a TEXT message!';

$e2 = new eMail();
$e2->from = new eMailUser(FROM_NAME, FROM_EMAIL);
$e2->to = array(new eMailUser(NULL, 'testing.selvam@gmail.com'));
$e2->subject = $subject;
$e2->txtMessage = 'This is a TEST message!';


$smtp = new SMTP(SMTP_SERVER, SMTP_SERVER_PORT, SMTP_USER, SMTP_PASSWORD);
$smtp->send($e1,$e2); /* OR $smtp->send(array($e1,$e2));*/
var_dump($smtp->SMTPlog);
/*///////////////////////////////////////////////////////////////////////////////////////*/
?>
