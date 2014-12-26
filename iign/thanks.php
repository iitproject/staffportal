<?php 
include("include/loader.php");
 if(!$sesobj->isassign("login_id")) {
	header("Location: index.php"); exit;
}
$query = "SELECT * from tbl_users where userid = '".$sesobj->get('login_id')."'";
$userDet = $sqlobj->getdatalistfromquery($query);
$score = $userDet[0]['score'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quiz</title>
<style type="text/css">
* {
	font-family:Tahoma, arial;
}
body {
	background: none repeat scroll 0 0 #8A8A8A;
	margin:0px;
	padding:0px;
}
.textbox {
	border:1px solid #CCCCCC;
	padding:5px;
	margin:3px 0px;
	width:200px;
}

.loginbox {
    background: repeat-x scroll 0 0 #FFFFFF;
    border-bottom: 8px solid #555555;
    border-radius: 10px;
    border-right: 8px solid #555555;
    padding: 10px 20px 20px 20px;
	font-size:13px;
}
.title {
	padding:10px 0px;font-size:18px;
}
.btn {
	border:1px solid #434445;
	background-color:#CCCCCC;
	border-radius: 5px;
	padding:5px;
	color:#000000;
	margin:20px 0px 0px 0px;
	font-weight:bold;
}
.wrapper {
	width:1004px;
	padding:0px;
	margin:0 auto;
	background: repeat-x scroll 0 0 #FFFFFF;
	font-size:13px;
}
.content {
	width:780px;
	padding:10px;
	margin:0 auto;
}
.question {
	font-size:15px;
	padding:10px 0px 0px 0px;
}
.answer {
	border-bottom:1px dotted #CCCCCC;
	padding:10px 0px;
}
</style>
</head>
<body>
	<div class="wrapper">		
		
		<div class="content">
			<form id="frmThanks"  method="post" action="">
				<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="title">Thank you</td>
					</tr>
					<tr>
						<td align="right"><a href="logout.php" title="">Logout</a></td>
					</tr>
					<tr>
						<td>Thanks for attending the Quiz. Your Score is <?php echo $score; ?></td>
					</tr>
				</table>
			</form>
		</div>
		
	</div>
</body>
</html>