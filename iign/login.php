<?php 
include("include/loader.php");
$msg = $username = $password = "";
if($sesobj->isassign("user_id")) {
	header("Location: advertisement_list.php");	
}elseif($userobj->getVariable("cmd_submit")!="") {
	$username = $userobj->getVariable("txt_username");
	$password = $userobj->getVariable("txt_password");
	$where = "where user_name='".$username."' and password='".$password."' AND is_deleted = 0";
	$query = "SELECT user_id, user_name FROM users ".$where;  	
	$arrUsers = $sqlobj->getdatalistfromquery($query);
	if(count($arrUsers)>0) {			
		$sesobj->assign("user_id", $arrUsers[0]["user_id"]);
		$sesobj->assign("user_name", $arrUsers[0]["user_name"]);
		header("Location: advertisement_list.php");				
	} else {
		$msg = "Invalid Username/Password.";
	}
}
include_once("header.php");
?>
<div class="header-fixed-top sidebar-partial sidebar-visible-lg sidebar-no-animations" id="page-container">
        <div id="sidebar">
            <div class="sidebar-scroll">
                <div class="sidebar-content">
                    <a class="sidebar-brand" href="#"><i class="fa fa-graduation-cap"></i><strong>IIT </strong>
                        GN </a>
                    <div class="sidebar-section sidebar-user clearfix">
                      <!--  <div class="sidebar-user-avatar">
                            <a href="#">
                                <img alt="avatar" src="img/user_photo.jpg">
                            </a>
                        </div>
                        <div class="sidebar-user-name">
                            Cheekati Yeshwanth
                        </div>-->
                    </div>
               <ul class="sidebar-nav">
                        <li class="active"><a href="#"><i class="fa fa-file sidebar-nav-icon"></i>Application Form
                             </a></li>
                        <li ><a href="#"><i class="fa fa-info-circle sidebar-nav-icon"></i>
                            Instructions </a></li>
                    </ul> 
                </div>
            </div>
        </div>
        <div id="main-container">
        	 <header class="navbar navbar-default navbar-fixed-top">
               <ul class="nav navbar-nav-custom">
               
                  <li><a onclick="App.sidebar('toggle-sidebar');" href="javascript:void(0)"><i class="fa fa-bars fa-fw">
                     </i></a>
                  </li>
               </ul>

             <ul class="nav navbar-nav-custom pull-right">
                
                     <li>
                     <a style="color:#394263; font-size:20px; padding-right:20px;"> Student Admission Portal</a>
                  </li>
                

                  </ul> 
            </header>
            <div id="page-content"  >
               <form id="frmLogin" method="post" action="">
					<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td align="center" valign="middle" style="padding-top:100px">
								<table border="0" width="400" cellpadding="0" cellspacing="0" class="loginbox">
								<tr>
									<td colspan="3" align="center" class="title"><b>Login</b></td>
								</tr>
								<tr>
									<td style="padding-left:40px">Username <br><input type="text" name="txt_username" id="txt_username" class="txtbox" style="width:250px;margin-top:10px" />&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td style="padding-left:40px">Password <br><input type="password" name="txt_password" id="txt_password" class="txtbox" style="width:250px;margin-top:10px" />&nbsp;</td>
								</tr>
								<tr>
									<td colspan="3" align="center" style="padding-top:10px;"><input type="submit" name="cmd_submit" class="btn" value=" Submit "></td>
								</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>
			</div>         
        </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {		
		// validate signup form on keyup and submit
		$("#frmLogin").validate({
			rules: {
				txt_username: "required",
				txt_password: "required"
			},
			messages: {
				txt_username: "Required",
				txt_password: "Required"			
			}
		});
	});
</script>
<?php include_once("footer.php"); ?>
