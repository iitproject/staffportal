<?php 
include("include/loader.php");
 if(!$sesobj->isassign("login_id")) {
	header("Location: index.php"); exit;
}
//$query = "SELECT question_id, question from tbl_quiz_questions";
$query = "SELECT * from tbl_quiz_questions";
$arrQuiz = $sqlobj->getdatalistfromquery($query);
$arrQuesAnswers = array();
if(count($arrQuiz) > 0)		{
	foreach($arrQuiz as $quesionid => $quesval) {
		$arrQuesAnswers[$quesval["question_id"]] = $quesval["answer_id"];
	}
}
if($userobj->getVariable("cmd_submit")!="") {
	$success_answers_cnt = 0;
	foreach($_POST as $key=>$value) {
		if(strstr($key,"rdo_quiz_")) {
			$questionid = str_replace("rdo_quiz_","", $key);

			$data = array();
			$data["user_id"] = $sesobj->get("login_id");
			$data["question_id"] = $questionid;
			$data["answer_id"] = $value;
			if($arrQuesAnswers[$questionid] == $value)
			{
				$success_answers_cnt++;	
			}
		}
	}
	if($success_answers_cnt > 0) {
		$scores = $success_answers_cnt * 10;
	}
	if($scores) {
		$where = ' userid = "'.$sesobj->get("login_id").'"';
		$userdata = array();
		$userdata['userid'] = $sesobj->get("login_id");
		$userdata['test_ends'] = date("Y-m-d H:i:s"); 
		$userdata['score'] = $scores;		
		$sqlobj->save("tbl_users", $userdata, $where);
	}
	header('Location: thanks.php');	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quiz</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="wrapper">		
		
		<div class="content">
			<form id="frmQuiz"  method="post" action="">
				<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="title">QUIZ</td>
				</tr>
				<tr>
					<td>
						<table border="0" width="100%" cellpadding="0" cellspacing="0" class="questions">
						<?php
						if(count($arrQuiz) > 0)		{
							foreach($arrQuiz as $quesionid => $quesval) {
								$answers = $sqlobj->fetchAnswers($quesval['question_id']);
						?>
						<tr>
							<td class="question"><?php echo $quesval['question']; ?></td>
						</tr>
						<tr>
							<td class="answer">
							<?php 
								foreach($answers as $answer_val) {
							?>
								<input type="radio" name="rdo_quiz_<?php echo $quesval['question_id']; ?>" value="<?php echo $answer_val['answer_id']; ?>" id="rdo_quiz_<?php echo $answer_val['answer_id']; ?>">
								<label for="rdo_quiz_<?php echo $answer_val['answer_id']; ?>"><?php echo $answer_val['answer']; ?></label>
							<?php
								}
							?>	
							</td>
						</tr>
						<?php 
							}
						}
						?>
						<tr>
							<td><input type="submit" name="cmd_submit" value=" Save " class="btn"></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</form>
		</div>
		
	</div>
</body>
</html>