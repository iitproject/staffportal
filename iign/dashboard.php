<?php 
include("include/loader.php");
if(!$sesobj->isassign("udm_login_id")) {
	header("Location: index.php"); exit;
} 
$query = "SELECT job.*, client.client_name FROM tbl_jobs AS job INNER JOIN tbl_clients AS CLIENT ON client.client_id = job.client_id ".$joinQuery." WHERE job_type=0 ORDER BY job.job_id DESC LIMIT 0,10";
$arrJobs = $sqlobj->getdatalistfromquery($query);
if(count($arrJobs)>0) {
	foreach($arrJobs as $jkey=>$jvalue) {
		$query = "SELECT job_status FROM tbl_job_status WHERE job_id='".$jvalue["job_id"]."' ORDER BY status_date DESC LIMIT 0,1";
		$arrStatus = $sqlobj->getdatalistfromquery($query);
		$status = "";
		if(count($arrStatus)>0) {
			$status = $arrStatus[0]["job_status"];
		}
		$arrJobs[$jkey]["job_status"] = $status;
	}
}

$arrEstimateType = array("creative"=>"CR", "press"=>"PS", "productions"=>"PD");
$query = "SELECT job.job_id, job.job_no, job.job_title, job.job_date, client.client_name, est.estimate_no, est.estimate_type, est.estimate_id, est.estimate_status FROM tbl_jobs AS job INNER JOIN tbl_clients AS CLIENT ON client.client_id = job.client_id INNER JOIN tbl_estimates as est ON est.job_id = job.job_id ".$where." WHERE job_type=0 AND job.estimate_flag=1 ORDER BY job.job_id DESC";
$arrEstimates = $sqlobj->getdatalistfromquery($query);
if(count($arrEstimates)>0) {
	foreach($arrEstimates as $jkey=>$jvalue) {
		$query = "SELECT job_status FROM tbl_job_status WHERE job_id='".$jvalue["job_id"]."' ORDER BY status_date DESC LIMIT 0,1";
		$arrStatus = $sqlobj->getdatalistfromquery($query);
		$status = "";
		if(count($arrStatus)>0) {
			$status = $arrStatus[0]["job_status"];
		}
		$arrEstimates[$jkey]["job_status"] = $status;
	}
}

$today_timestamp = strtotime('+5 hours 30mins');
$today_date = date('Y-m-d', $today_timestamp);

$tomorrow_timestamp = strtotime('+1 day 5 hours 30mins');
$tomorrow_date = date('Y-m-d', $tomorrow_timestamp);

$userid = $sesobj->get("udm_login_id");
$deadline_reminder = $today_my_reminder = $tomorrorw_my_reminder = 0;

$today_query = 'SELECT count(reminder_id) as today_cnt FROM tbl_reminders WHERE reminder_status="Active" AND userid="'.$userid.'" AND reminder_date="'.$today_date.'"';
$arrReminders = $sqlobj->getdatalistfromquery($today_query);
if(count($arrReminders)>0)
	$today_my_reminder = $arrReminders[0]['today_cnt'];

$tomorrow_query = 'SELECT count(reminder_id) as tomorrow_cnt FROM tbl_reminders WHERE reminder_status="Active" AND userid="'.$userid.'" AND reminder_date="'.$tomorrow_date.'"';
$arrReminders = $sqlobj->getdatalistfromquery($tomorrow_query);
if(count($arrReminders)>0)
	$tomorrow_my_reminder = $arrReminders[0]['tomorrow_cnt'];

$userid = 2;
$deadline_query = 'SELECT count(job.job_id) as jobcount FROM tbl_jobs AS job INNER JOIN tbl_clients AS CLIENT ON client.client_id = job.client_id INNER JOIN tbl_allocate_job AS allocation ON allocation.job_id = job.job_id AND (doneby="'.$userid.'" OR reportto="'.$userid.'") WHERE job_type=0 AND reminder_status =1 ORDER BY doneby ASC, job_id ASC';
$arrAllocation = $sqlobj->getdatalistfromquery($deadline_query);
if(count($arrAllocation)>0)
	$deadline_reminder = $arrAllocation[0]['jobcount'];

?>
<?php include_once("header.php"); ?>
<?php if($sesobj->isassign("msg")) {  ?>
<div class="success"><b><?php echo $sesobj->get("msg"); ?></b></div>
<?php $sesobj->unassign("msg"); 
} ?>
<div class="content">
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:right"><a href="deadline_filter.php">My Deadline Jobs</a> | <a href="my_reminders.php">My Reminders</a> | <a href="change_profile.php">Change Profile</a></td>
	</tr>
	<tr>
		<td>
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="49%" style="vertical-align:top;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="text-align:right;height:20px;"><a href="joblist.php" title=""><b>View All Jobs</b></a></td>
					</tr>
					</table>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td class="head"><div align="left">&nbsp;&nbsp;&nbsp;Latest Jobs</div></td>
					</tr>
					<tr>
						<td class="report">
							<table width="100%" cellpadding="10" cellspacing="1" border="0" bgcolor="#000000">
							<tr height="35" bgcolor="#ECECEC">
								<td width="10%"><strong>Job No.</strong></td>
								<td width="10%"><strong>Job Date</strong></td>
								<td width="62%"><strong>Title</strong></td>
								<td width="8%"><strong>Action</strong></td>
							</tr>
							<?php 
							if(count($arrJobs)>0) { 
								foreach($arrJobs as $key=>$value) {
							?>
							<tr bgcolor="#ECECEC">
								<td align="center"><?php echo $value["job_no"];?></td>
								<td><?php echo date('d-m-Y', strtotime($value["job_date"]));?></td>
								<td><?php echo $value["job_title"];?></td>
								</td>
								<td style="text-align:center;"><a href="view_job_list.php?id=<?php echo $value["job_id"] ?>" title="View"><img src="images/view.png" border="0" alt="" width="20" height="20"></a></td>
							</tr>
							<?php 
								}	
							} else { ?>
							<tr bgcolor="#ECECEC">
								<td colspan="4" align="center" style="color:#CC0000;text-align:center;"><b>No job available...</b></td>
							</tr>
							<?php } ?>
							</table>
						</td>
					</tr>
					</table>
				</td>
				<td width="2%">&nbsp;</td>
				<td width="49%" style="vertical-align:top;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="text-align:right;height:20px;"><a href="estimate_list.php" title=""><b>View All Estimates</b></a></td>
					</tr>
					</table>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td class="head"><div align="left">&nbsp;&nbsp;&nbsp;Latest Estimates</div></td>
					</tr>
					<tr>
						<td class="report">
							<table width="100%" cellpadding="10" cellspacing="1" border="0" bgcolor="#">
							<tr height="35" bgcolor="#ECECEC">
								<td width="10%"><strong>Estimate No</strong></td>
								<td width="7%"><strong>Job No.</strong></td>
								<td width="63%"><strong>Title</strong></td>
								<td width="20%"><strong>Others</strong></td>
							</tr>
							<?php 
							if(count($arrEstimates)>0) { 
								foreach($arrEstimates as $key=>$value) {
							?>
							<tr bgcolor="#ECECEC">
								<td><?php echo "ES / ".$arrEstimateType[$value["estimate_type"]]." / ".$value["estimate_no"];; ?></td>
								<td><?php echo $value["job_no"];?></td>
								<td><?php echo $value["job_title"];?></td>
								<td align="center"><?php if($flag_job_estimate==true) { ?><a href="estimate.php?type=<?php echo $value["estimate_type"]."&mode=edit&id=".$value["job_id"]."&eid=".$value["estimate_id"]; ?>" title="Edit"><img src="images/edit.png" border="0" alt="" width="20" height="20"></a>&nbsp;<a href="view_estimate.php?id=<?php echo $value["job_id"]."&eid=".$value["estimate_id"]; ?>" title="View"><img src="images/view.png" border="0" alt="" width="20" height="20"></a>&nbsp;<?php } ?><?php if($flag_job_invoice==true) { ?><a href="invoice.php?id=<?php echo $value["job_id"]."&eid=".$value["estimate_id"]; ?>" title="Invoice"><img src="images/invoice.png" border="0" alt="" width="20" height="20"></a><?php } ?></td>
							</tr>
							<?php 
								}	
							} else { ?>
							<tr bgcolor="#ECECEC">
								<td colspan="4" align="center" style="color:#CC0000;text-align:center;"><b>No job available...</b></td>
							</tr>
							<?php } ?>
							</table>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:right;padding:30px 10px 0px 0px;">Last Login: <?php echo date('d M Y H:i:s',convertDateTime($sesobj->get("lastlogin"), true)) ?></td>
	</tr>
	</table>
</div>
<?php if($deadline_reminder!=0 || $today_my_reminder!=0 || $tomorrorw_my_reminder!=0) { ?>
<div id="pinnote">
	<table border="0" width="300" cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:center;"><div style="display:inline-block;"><img src="images/pinnote.png" border=0 alt="" class="absmiddle"></div> <div class="pintitle"><b>Reminder</b></div><div style="display:inline-block;float:right;"><img id="img_close" src="images/close2.png" border=0 alt="Close" title="Close"></div></td>
	</tr>
	<?php if($deadline_reminder!=0) {?>
	<tr>
		<td style="color:#900100;"><b>Deadline Reminder:</b></td>
	</tr>
	<tr>
		<td>You have <?php echo $deadline_reminder; ?> deadlines pending. <a href="deadline_filter.php" title="View">View</a></td>
	</tr>
	<?php } ?>
	<?php if($today_my_reminder!=0 || $tomorrorw_my_reminder!=0) { ?>
	<tr>
		<td style="padding-top:10px;color:#900100;"><b>Personal Reminders:</b></td>
	</tr>
	<?php if($today_my_reminder!=0) { ?>
	<tr>
		<td>* Today you have <?php echo $today_my_reminder; ?> reminders. <a href="my_reminders.php" title="View">View</a></td>
	</tr>
	<?php } ?>
	<?php if($tomorrorw_my_reminder!=0) { ?>
	<tr>
		<td>* Tomorrow you have <?php echo $tomorrorw_my_reminder; ?> reminders. <a href="my_reminders.php" title="View">View</a></td>
	</tr>
	<?php } ?>
	<?php } ?>
	</table>
</div>
<script language="javascript" type="text/javascript">
	jQuery(document).ready(function () {
		jQuery("#img_close").click(function () {
			jQuery("#pinnote").slideUp(1000);
		});
	});
</script>
<?php } ?>
<?php include_once("footer.php"); ?>