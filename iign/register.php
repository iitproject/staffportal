<?php 
include("include/loader.php");
if($userobj->getVariable("register_submit")!="") {
	$data = array();
	$data["name"]		= $userobj->getVariable("firstname");
	$data["email"]		= $userobj->getVariable("email");
	$data["password"]	= $userobj->getVariable("password");
	$data["phone"]	= $userobj->getVariable("phone");
	$data["date_added"]	= date("Y-m-d H:i:s"); 
	$user_id = $sqlobj->save("tbl_users", $data); 
	if($user_id) {

		$login_time = time()+19820;
		$logdata = array();
		$logdata["user_id"]	= $user_id;
		$logdata["name"]	= $data["name"];
		$data["user_email"]	= $data["email"];
		$data["user_ip"]	= $userobj->get_client_ip();
		$data["user_login"]	= date('Y-m-d H:i:s', $login_time);
		$sqlobj->save("tbl_login_log", $data);

		$sesobj->assign("login_id", $user_id);
		$sesobj->assign("login_name", $data["name"]);
		if($user_id == 1) {
			$sesobj->assign("login_as_admin", 1);
		}
		$sesobj->assign("login_email", $data["email"]);
		header("Location: quiz.php"); exit;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register | Quiz</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/val.js"></script>
<script>
	required.add('firstname','NOT_EMPTY','Name');
	required.add('email','NOT_EMPTY','Email');
	required.add('password','NOT_EMPTY','Password');
	required.add('phone','NOT_EMPTY','Phone');
</script>
</head>
<body>
	<form id="frmRegister"  method="post" onsubmit="return validate.check( this );" action="">
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle" style="padding-top:100px">
					<table border="0" cellpadding="0" cellspacing="0" class="loginbox">
					<tr>
						<td colspan="3" align="center" class="title"><b>Registration</b></td>
					</tr>
					<tr>
						<td>Name <br><input type="text" name="firstname" id="firstname" class="textbox" placeholder="Enter your name:" required/></td>
						<td width="20">&nbsp;</td>
						<td>Email <br><input type="email" name="email" id="email" class="textbox" placeholder="Enter your email:"  required/></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td>Password <br><input type="password" name="password" id="password" class="textbox" placeholder="Enter your password" required/></td>
						<td width="20">&nbsp;</td>
						<td>Confirm Password <br><input type="password" id="password" name="confirm_password" class="textbox" placeholder="Confirm your password" required /></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td>Phone <br><input type="text" name="phone" id="phone" class="textbox" placeholder="Enter your phone:" required/></td>
					</tr>
					<tr>
						<td colspan="3" align="center"><input type="submit" name="register_submit" class="btn" value=" Submit "></td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>