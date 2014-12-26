<?php

/* include_once("phpmailer.inc.php");

$pm = new phpmailer();
$pm->IsSMTP(true);
$pm->SMTPDebug  = 1;
$pm->Host = 'tls://smtp.gmail.com:587';
$pm->SMTPAuth = true;
$pm->Username = 'panneerselvam28@gmail.com';
$pm->Password = 'selvam*2086';

$pm->AddAddress("selvam4win@gmail.com");
$pm->Subject  = "An HTML Message";
$pm->Body     = "Hello, <b>my friend</b>! \n\n This message uses HTML entities!";

$result = $pm->Send();

if($result)
	echo "Success";
else
	echo "Failure"; */
echo 'Current PHP version: ' . phpversion()."&&";

include_once("phpmailer.inc.php");

$mail = new phpmailer(); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
$mail->Username   = "panneerselvam28@gmail.com";  // GMAIL username
$mail->Password   = "selvam*2086";            // GMAIL password
$mail->AddAddress('selvam4win@gmail.com', 'Raja');
$mail->From = 'panneerselvam28@gmail.com';
$mail->Subject = 'After PHPMailer Test Subject via mail(), advanced';
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
$mail->Body = '<br>test Body';
if($mail->Send())
echo "Message Sent OK<p></p>\n";
else
echo "Message Not Sent<p></p>\n";
?>
