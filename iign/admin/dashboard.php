<?php 
include("../include/loader.php");
if(!$sesobj->isassign("login_id")) {
	header("Location: index.php"); exit;
}
$user_id = $sesobj->isassign("login_id");
$query = "SELECT score, name, email from tbl_users where  userid != '1'";
$quizres = $sqlobj->getdatalistfromquery($query);
?>
<?php include_once("header.php"); ?>
<?php if($sesobj->isassign("msg")) {  ?>
<div class="success"><b><?php echo $sesobj->get("msg"); ?></b></div>
<?php $sesobj->unassign("msg"); 
} ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
		<?php foreach($quizres as $key => $val) { ?>
          ["<?php echo $val['name']; ?>", <?php echo $val['score']; ?>],
		<?php } ?>
        ]);
	
        // Set chart options
        var options = {'title':'Quiz Scores',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr height="450">
	<td align="center" valign="top" style="padding:30px 0px 0px 0px">
		<h1>Welcome to Administration Dashboard</h1>
	</td>
</tr>
</table>
<div id="chart_div"></div>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td style="text-align:right;padding:30px 10px 0px 0px;">Last Login: <?php echo date('d M Y H:i:s',convertDateTime($sesobj->get("lastlogin"), true)) ?></td>
</tr>
</table>
<?php include_once("footer.php"); ?>