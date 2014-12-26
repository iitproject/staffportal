<?php 

$fp   =   fsockopen("www.google.com",   80,   &$errno,   &$errstr,   10);  // work fine
  if(!   $fp)  
      echo   "www.google.com -  $errstr   ($errno)<br>\n";  
  else  
      echo   "www.google.com -  ok<br>\n";

  
      $fp   =   fsockopen("smtp.gmail.com",   465,   &$errno,   &$errstr,   10);   // NOT work
  if(!   $fp)  
      echo   "smtp.gmail.com 465  -  $errstr   ($errno)<br>\n";  
  else  
      echo   "smtp.gmail.com 465 -  ok<br>\n";  
      
      
      $fp   =   fsockopen("smtp.gmail.com",   587,   &$errno,   &$errstr,   10);   // NOT work
  if(!   $fp)  
      echo   "smtp.gmail.com 587  -  $errstr   ($errno)<br>\n";  
  else  
      echo   "smtp.gmail.com 587 -  ok<br>\n";        

echo "<br />".phpinfo(); 
      ?>
<?php 

require_once 'class.phpmailer.php';
$mail = new PHPMailer ();

$mail -> From = "panneerselvam28@gmail.com";
$mail -> FromName = "Selvam";
$mail -> AddAddress ("selvam4win@gmail.com");
$mail -> Subject = "Test";
$mail -> Body = "<h3>From GMail!</h3>";
$mail -> IsHTML (true);

$mail->IsSMTP();
$mail->SMTPDebug  = 1;  
$mail->Host = 'smtp.gmail.com';
$mail->SMTPSecure = ""; 
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'panneerselvam28@gmail.com';
$mail->Password = 'selvam*2086';

if(!$mail->Send()) {
        echo 'Error: ' . $mail->ErrorInfo;
}else {
	echo 'Mail sent!';
}
/* require_once('class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
$mail = new phpmailer(); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.udmedia.in"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
$mail->Username   = "panneerselvam28@gmail.com";  // GMAIL username
$mail->Password   = "selvam*2086";            // GMAIL password
$mail->AddAddress('selvam4win@gmail.com', 'John Doe');
$mail->From = 'panneerselvam28@gmail.com';
$mail->Subject = 'After PHPMailer Test Subject via mail(), advanced';
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
$mail->Body = '<br>test Body';
if($mail->Send())
echo "Message Sent OK<p></p>\n";
else
echo "Message Not Sent<p></p>\n"; */
