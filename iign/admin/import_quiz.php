<?php 
include("../include/loader.php");
if(!$sesobj->isassign("login_as_admin") && !$sesobj->isassign("login_id")) {
	header("Location: ../index.php"); exit;	
}
if($userobj->getVariable("cmd_submit")!="") {
	if($_FILES['quiz_file']['tmp_name'] != '') {
		$handle = fopen($_FILES['quiz_file']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			foreach($data as $key => $val) {
				if($key == 0) {
					$qdata["question"]	= $val;
					$qdata["date_added"]	= date('Y-m-d H:i:s');					
					$question_id = $sqlobj->save("tbl_quiz_questions", $qdata);
				}
				elseif($key > 0 && $key <=4)
				{
					$optdata["question_id"]	= $question_id;
					$optdata["answer"]	= $val;
					$answer_id = $sqlobj->save("tbl_quiz_answers", $optdata);
				}
				elseif($key == 5)
				{
					$query = "SELECT answer_id from tbl_quiz_answers where question_id = '".$question_id."' AND answer = '".$val."'";
					$quizans = $sqlobj->getdatalistfromquery($query);
					$correct_answer_id = $quizans[0]['answer_id'];
					$updata = array();
					$updata["answer_id"] = $correct_answer_id;
					$where = "question_id='".$question_id."'";
					$sqlobj->save("tbl_quiz_questions", $updata, $where);
				}
			}
		}
		$sesobj->assign('msg', 'Quiz Imported Successfully');
	}
}
?>
<?php include_once("header.php"); ?>
<?php if($sesobj->isassign("msg")) {  ?>
<div class="success"><b><?php echo $sesobj->get("msg"); ?></b></div>
<?php $sesobj->unassign("msg"); 
} ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td colspan="2"><img src="../images/trans.gif" width="100%" height="10"></td></tr>
<tr>
	<td colspan="2" align="center" valign="top">
		<form name="frmImportQuiz" id="frmImportQuiz" action="" method="post" enctype="multipart/form-data">
		<table border="0" width="65%" cellpadding="5" cellspacing="0">
			<tr>
				<td colspan="3" align="right"><a href="dashboard.php" title="">Back</a></td>
			</tr>
			</table>
			<table border="0" width="65%" cellpadding="5" cellspacing="0" style="border:1px solid #333333;">
				<tr>
					<td style="padding-left:15px">Name</td>
					<td width="30" align="center">:</td>
					<td><input type="file" name="quiz_file" class="txtbox" style="width:230px;"></td>
				</tr>		
				<tr>
					<td colspan="3" align="center"><input type="submit" name="cmd_submit" value="Submit" class="btn2"></td>
				</tr>
		</table>
		</form>
	</td>
</tr>
</table>
<?php include_once("footer.php"); ?>