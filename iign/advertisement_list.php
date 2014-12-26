<?php 
include("include/loader.php");
if(!$sesobj->isassign("user_id")) {
	header("Location: index.php");	
}else {
	$query = "SELECT * FROM staff_recruitment_advertisement WHERE status = 1 AND is_deleted = 0 AND closing_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)";
	$advertisement_list = $sqlobj->getdatalistfromquery($query);		
}
include_once("header.php");
?>
<div class="header-fixed-top sidebar-partial sidebar-visible-lg sidebar-no-animations"
        id="page-container">
        <div id="sidebar">
            <div class="sidebar-scroll">
                <div class="sidebar-content">
                    <a class="sidebar-brand" href="#"><i class="fa fa-graduation-cap"></i><strong>IIT </strong>
                        GN </a>
                    <!--       <div class="sidebar-section sidebar-user clearfix">
                        <div class="sidebar-user-avatar">
                            <a href="#">
                                <img alt="avatar" src="img/user_photo.jpg">
                            </a>
                        </div>
                        <div class="sidebar-user-name">
                            Priyadarshan
                        </div>
                        <div class="sidebar-user-links">
                            <a title="" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Profile">
                                <i class="fa fa-user"></i></a><a title="" data-placement="bottom" data-toggle="tooltip"
                                    href="#" data-original-title="Messages"><i class="fa fa-envelope"></i></a>
                            <a title="" data-placement="bottom" class="enable-tooltip" data-toggle="modal" href="#modal-user-settings"
                                data-original-title="Settings"><i class="fa fa-cog"></i></a><a title="" data-placement="bottom"
                                    data-toggle="tooltip" href="#   " data-original-title="Logout"><i class="fa fa-sign-out">
                                    </i></a>
                        </div>
                    </div>-->
                    <ul class="sidebar-nav">
                        <li class="active"><a href="#"><i class="fa fa-info-circle sidebar-nav-icon"></i>Instructions
                        </a></li>
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
             <!--  <form role="search" class="navbar-form-custom" method="post" action="">
                  <div class="form-group">
                     <input type="text" placeholder="Search.." class="form-control" name="top-search" id="top-search">
                  </div>
               </form>-->


             <ul class="nav navbar-nav-custom pull-right">            

                
                     <li>
                     <a style="color:#394263; font-size:20px; padding-right:20px;"> Staff Application Portal</a>
                  </li>
                

                  </ul> 
            </header>
            <div id="page-content">
                <!--   <ul class="breadcrumb breadcrumb-top">
                    <li><i class="fa fa-home"></i>Home </li>
                   <li>
                     <a href="">
                     Charts
                     </a>
                     </li>
                </ul>-->
                <h3>
                    Staff Recruitement Advertisement</h3>
                <div class="table-responsive">
                    <div role="grid" class="dataTables_wrapper" id="example-datatable_wrapper">
                        <div style="width: 100%; overflow: auto">
                            <table class="table table-vcenter table-condensed table-bordered dataTable" id="general-table"
                                style="background-color: White">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 30px;">
                                            #
                                        </th>
                                        <th class="text-center" style="width: 130px;">
                                            Advertisement No
                                        </th>
                                     
                                        <th>
                                            Position
                                        </th>
                                        <th>
                                            Pay band
                                        </th>
                                        <th>
                                            No of Vacancies
                                        </th>
                                        
                                        <th>
                                            Starting Date
                                        </th>
                                        <th>
                                            Closing Date
                                        </th>
                                         <th>
                                         Last date for submission of Hard Copies 
                                        </th>
                                        <th>
                                        Mode of Recruitment  
                                        </th>
                                        <th>
                                            Advertisement Details
                                        </th>
                                     
                                        <th class="text-center" style="width: 180px;">
                                            Online Application
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php if(!count($advertisement_list)) { ?>
                                	   <tr>
                                	       <td colspan="11">No records found</td>
                                	   </tr>
                                	<?php } else { ?>
                                	   <?php foreach($advertisement_list as $adv_key => $adv_val) { ?>
	                                	   <tr>
	                                	       <td class="text-center"><?php echo $adv_val['id'];  ?></td>
	                                	       <td class="text-center"><?php echo $adv_val['advt_no'];  ?></td>
	                                	       <td><?php echo $adv_val['position'];  ?></td>
	                                	       <td><?php echo $adv_val['pay_band'];  ?></td>
	                                	       <td><?php echo $adv_val['no_of_vacancies'];  ?></td>
	                                	       <td><?php echo date("d-m-Y", strtotime($adv_val['starting_date']));  ?></td>
	                                	       <td><?php echo date("d-m-Y", strtotime($adv_val['closing_date']));  ?></td>
	                                	       <td><?php echo date("d-m-Y", strtotime($adv_val['hard_copy_last_date']));  ?></td>
	                                	       <td><?php echo ucfirst($adv_val['recruitment_mode']); ?></td>
	                                	       <td><a href="#" class="btn btn-info btn-sm">View </a></td>
	                                	       <td><a href="advertisement_apply.php?id=<?php echo $adv_val['id']; ?>" class="btn btn-success btn-sm">Apply </a></td>
	                                	   </tr>
                                	   <?php } ?>
                                	<?php } ?>                                    
                                </tbody>
                            </table>
                        </div>                       
                    </div>
                </div>
            </div>
            <footer class="clearfix">
                    <div class="pull-left">
                       iProof
                    </div>
                </footer>
        </div>
    </div>
    <a id="to-top" href="#" style="display: inline;"><i class="fa fa-angle-double-up"></i>
    </a>    
<?php include_once("footer.php"); ?>
