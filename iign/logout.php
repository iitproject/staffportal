<?php 
include("include/loader.php");

$sesobj->unassign("login_id");
$sesobj->unassign("login_name");
$sesobj->unassign("login_as_admin");
header("Location: index.php"); exit;

?>