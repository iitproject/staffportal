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
<title>Home | Quiz</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form id="frmRegister"  method="post" action="">
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle" style="padding-top:100px">
					<table border="0" width="400" height="200" cellpadding="0" cellspacing="0" class="loginbox">
					<tr>
						<td colspan="3" align="center" class="title" style="padding-top:30px;font-size:30px;"><b>Welcome to Staff System</b></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td align="center"><a href="login.php" title="Login" class="link02">Login</a><br>[Already registered]</td>
						<td width="20">&nbsp;</td>
						<td align="center"><a href="register.php" title="Register" class="link02">Register</a><br>[For new user]</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
