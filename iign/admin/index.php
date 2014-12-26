<?php 
include("../include/loader.php");
$msg = $username = $password = "";
if($sesobj->isassign("login_as_admin")) {
	header("Location: admin/dashboard.php"); exit;	
} elseif($sesobj->isassign("login_id")) {
	header("Location: ../thanks.php"); exit;
} elseif($userobj->getVariable("cmd_submit")!="") {
	$username = $userobj->getVariable("txt_username");
	$password = $userobj->getVariable("txt_password");
	if(strpos($username,"@")!=-1) {
		$where = "where isadmin=1 and username='".$username."' and password='".$password."'";
	} else {
		$where = "where isadmin=1 and username like '".$username."@%' and password='".$password."'";
	}
	$query = "SELECT userid, name FROM tbl_users ".$where;
	$arrUsers = $sqlobj->getdatalistfromquery($query);
	if(count($arrUsers)>0) {
		$sesobj->assign("udm_admin_id", $arrUsers[0]["userid"]);
		$sesobj->assign("udm_admin_name", $arrUsers[0]["name"]);

		$arrPageAccess = $sqlobj->getPageAccess($arrUsers[0]["userid"]);

		$sqlobj->updateLoginTime($arrUsers[0]["userid"]);

		$where = ' AND userid="'.$arrUsers[0]["userid"].'"';
		$arrUserData = $sqlobj->getUsers($where);
		$sesobj->assign("lastlogin", $arrUserData[0]["lastlogin2"]);

		$sesobj->assign("udm_access", $arrPageAccess[0]);

		$sesobj->assign("msg", "Login successfully...");

		header("Location: dashboard.php"); exit;
	} else {
		$msg = "Invalid Username/Password.";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN</title>
<script src="../js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/val.js"></script>
<script>
	required.add('txt_username','NOT_EMPTY','User Name');
	required.add('txt_password','NOT_EMPTY','Password');
</script>
<style type="text/css">
body {
	width:450px;
	padding-top:200px;
	margin:auto;
	font-family:Arial, Helvetica, sans-serif;
	background:#8a8a8a;
	font-size:14px;
	color:#000000;
}
.user{
	padding:25px 25px 0px 25px ;
	background: url(../images/l_bg.gif) repeat-x;
	border-radius:10px;
	border-right:solid 5px #555555;
	border-bottom:solid 5px #555555;
}
.head{
	font-family:Arial, Helvetica, sans-serif;
	font-size:20px;
	font-weight:bold;
	text-align:center;
}	
.text {
	text-align:right;
	line-height:35px;
}
input.txtbox {
	width: 95%;
	border:1px solid #C2BDB1;
}
.btn2 {
	border:1px solid #5D5D5D;
	font-size:13px;
	padding:3px 4px;
	cursor:pointer;
	font-weight:bold;
}
</style>
</head>
<body>
	<div class="user">
		<table width="100%" cellpadding="0" cellspacing="0" background="0">
		<tr>
			<td width="100"><img src="../images/l_logo.gif" border="o"/></td>
			<td class="head">UDMedia - Administration</td>
		</tr>
		<tr>
			<td width="100">&nbsp;</td>
			<td >&nbsp;</td>
		</tr>
		<?php if($msg!="") { ?>
		<tr>
			<td align="center" colspan="2" style="color:#CC0000;padding:5px 0px;"><b><?php echo $msg; ?></b></td>
		</tr>
		<?php } ?>
		</table>
		<form id="frmLogin" onsubmit="return validate.check( this );" method="post" action="">
		<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="text" width="25%">User Name :</td>
			<td class="text" width="75%"><input type="text" name="txt_username" id="txt_username" class="txtbox" value="<?php echo $username; ?>"/></td>
		</tr>
		<tr>
			<td class="text">Password :</td>
			<td class="text"><input type="password" name="txt_password" id="txt_password" class="txtbox" value="<?php echo $password; ?>"/></td>
		</tr>
		<tr>
			<td class="text" colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="cmd_submit" id="cmd_submit" value="Login" class="btn2" /></td>
			<td class="text"></td>
		</tr>
		</table>
		</form>
		<script language="javascript" type="text/javascript">
			document.getElementById("txt_username").focus();
		</script>
	</div>
</body>
</html>
