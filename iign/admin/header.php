<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Neosys</title>
<link href="../css/admin.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
	<div>
		<div class="logo">
			<a href="index.php"><img src="images/logo.gif" border="0" alt="" /></a>
		</div>
		<div class="login">Welcome <?php echo $sesobj->get("udm_login_name"); ?> | <a href="logout.php" title="Logout">Logout</a></div>
		<div class="cle"></div>
	</div>
	<div style="height:22px;">&nbsp;</div>
	<div class="bg"<?php echo ($pagename=='dashboard.php')?'style="padding:10px 15px;"':''; ?>>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="27%" align="left" valign="top"><?php require_once("leftnavi.php"); ?></td>
			<td width="2%">&nbsp;</td>
			<td width="71%" valign="top">