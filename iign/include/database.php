<?php
	set_time_limit(0);
	ini_set('max_execution_time', 1500); //1500 seconds = 25 minutes

	@include_once("config.php");

	/* backup the db OR just a table */
	function backup_tables($host,$user,$pass,$name,$tables = '*') {
		
		$link = mysql_connect($host,$user,$pass);
		mysql_select_db($name,$link);
		
		//get all of the tables
		if($tables == '*') {
			$tables = array();
			$result = mysql_query('SHOW TABLES');
			while($row = mysql_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		} else {
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		if(isset($_POST['txt_exclude_tables']) && trim($_POST['txt_exclude_tables'])!="") {
			$arrTables = explode(',', $_POST['txt_exclude_tables']);
			$arrTables = array_map('trim', $arrTables);
			$tables = array_diff($tables, $arrTables);
		}

		$dbcontent ="";
		//cycle through
		foreach($tables as $table) {
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			
			if($_POST['rdo_options']=="all" || $_POST['rdo_options']=="structure") {
				$dbcontent.= 'DROP TABLE '.$table.';';
				$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
				$dbcontent.= "\n\n".$row2[1].";\n\n";
			}

			if($_POST['rdo_options']=="all" || $_POST['rdo_options']=="data") {
				for ($i = 0; $i < $num_fields; $i++) 
				{
					while($row = mysql_fetch_row($result))
					{
						$dbcontent.= 'INSERT INTO '.$table.' VALUES(';
						for($j=0; $j<$num_fields; $j++) 
						{
							$row[$j] = addslashes($row[$j]);
							$row[$j] = ereg_replace("\n","\\n",$row[$j]);
							if (isset($row[$j])) { $dbcontent.= '"'.$row[$j].'"' ; } else { $dbcontent.= '""'; }
							if ($j<($num_fields-1)) { $dbcontent.= ','; }
						}
						$dbcontent.= ");\n";
					}
				}
				$dbcontent.="\n\n\n";
			}
		}
		
		//save file
		$sqlfile = 'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
		$handle = fopen('../../../'.$sqlfile,'w+');
		fwrite($handle,$dbcontent);
		fclose($handle);

		header('Content-disposition: attachment; filename='.$name.'.sql');
		ob_clean();
		flush();
		readfile("../../../".$sqlfile);
		unlink("../../../".$sqlfile);
		exit;
	}

	if(!isset($_POST['txt_server']) && defined('_HOSTNAME')) {
		$_POST['txt_server'] = _HOSTNAME;
		$_POST['txt_username'] = _USERNAME;
		$_POST['txt_password'] = _PASSWORD;
		$_POST['txt_database'] = _DATABASE;
	}
	$type = (isset($_POST['rdo_type']) && $_POST['rdo_type']!="")?$_POST['rdo_type']:"2";

	if(isset($_POST['cmd_export'])) {
		backup_tables($_POST['txt_server'],$_POST['txt_username'],$_POST['txt_password'],$_POST['txt_database']);
	}
?>
<style type="text/css">
body {
	font-family:verdana,arial;
	font-size:12px;
}
table {
	font-family:verdana,arial;
	font-size:12px;
}
td {
	font-family:verdana,arial;
	font-size:12px;
}
table.res {
	font-family:verdana,arial;
	font-size:11px;
}
table.res td {
	font-family:verdana,arial;
	font-size:11px;
}
.text {
	border-right: #000000 1px solid;
	border-top: #000000 1px solid;
	border-left: #000000 1px solid;
	border-bottom: #000000 1px solid;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	height: 20px;
	color: #474747;
}
.button {
	border-right: #000000 1px solid;
	border-top: #000000 1px solid;
	border-left: #000000 1px solid;
	border-bottom: #000000 1px solid;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	height: 20px;
	color: #000000;
}
.button1 {
	border-right: #000000 1px solid;
	border-top: #000000 1px solid;
	border-left: #000000 1px solid;
	border-bottom: #000000 1px solid;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	height: 20px;
	color: #000000;
	font-weight: bold;
}
</style>
<script language="javascript" type="text/javascript">
	function Trim(s) {
		while ((s.substring(0,1) == ' ') || (s.substring(0,1) == '\n') || (s.substring(0,1) == '\r'))
			s = s.substring(1,s.length);
		while ((s.substring(s.length-1,s.length) == ' ') || (s.substring(s.length-1,s.length) == '\n') || (s.substring(s.length-1,s.length) == '\r'))
			s = s.substring(0,s.length-1);
		return s;
	}
	function frmvalidation(frmobj) {
		var str = "";
		if(Trim(frmobj.txt_server.value)=="" || Trim(frmobj.txt_server.value)=="Server") 
			str += "Server.\n";
		if(Trim(frmobj.txt_username.value)=="" || Trim(frmobj.txt_username.value)=="Username") 
			str += "Username.\n";
		if(Trim(frmobj.txt_password.value)=="Password") 
			str += "Password.\n";
		if(Trim(frmobj.txt_database.value)=="" || Trim(frmobj.txt_database.value)=="Database") 
			str += "Database.\n";
		if(Trim(frmobj.txt_query.value)=="") 
			str += "SQL Query.\n";
		if(str!="") {
			var msg = "Please enter the following:\n";
			msg += "--------------------------------\n";
			msg += str;
			alert(msg);
			return false;
		} else {
			return true;
		}
	}
	function showHideOptions() {
		if(document.getElementById("td_export_options").style.display=='')
			document.getElementById("td_export_options").style.display='none';
		else 
			document.getElementById("td_export_options").style.display='';
		return false;
	}
</script>
<form name="frmtabledata" id="frmtabledata" action="" method="post">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="3" align="center" style="font-size:18px;"><strong>MySQL Query Analyser - Selvam</strong></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2"><strong>SQL Query:</strong></td>
				</tr>
				<tr>
					<td colspan="2"><textarea name="txt_query" rows="" cols="" style="width:500px;height:158px;margin-top:5px;" class="text"><?php echo stripslashes($_POST['txt_query']);?></textarea></td>
				</tr>
				<tr>
					<td style="padding-top:10px"><input type="submit" name="cmd_submit" value="Execute" class="button" style="width:75px;" onClick="javascript:return frmvalidation(this.form);" onMouseover="this.className='button1'" onMouseout="this.className='button'">&nbsp;&nbsp;<input type="reset" name="cmd_reset" name="Reset" class="button" style="width:55px;" onclick="window.location.href=window.location.href;" onMouseover="this.className='button1'" onMouseout="this.className='button'"></td>
					<td align="right" style="padding-right:10px"><input type="submit" name="cmd_export" class="button" value=" Export DB "> [<a href="#" onclick="javascript:return showHideOptions();">Options</a>]</td>
				</tr>
				<tr>
					<td id="td_export_options" colspan="2" align="right" style="display:none;padding-right:10px">
						<table border="0" cellpadding="3" cellspacing="3">
						<tr>
							<td><input type="radio" name="rdo_options" id="rdo_options1" value="all" checked/><label for="rdo_options1">Structure & Data</label></td>
							<td><input type="radio" name="rdo_options" id="rdo_options2" value="structure"/><label for="rdo_options2">Structure Only</label></td>
						</tr>
						<tr>
							<td colspan="2" ><input type="radio" name="rdo_options" id="rdo_options3" value="data"/><label for="rdo_options3">Data Only</label></td>
						</tr>
						<tr>
							<td colspan="2"  style="border-top:1px dotted #CCCCCC" >Exclude Tables:<br><textarea name="txt_exclude_tables" rows="" cols="" style="width:265px;height:70px;margin-top:5px;" ></textarea><br><i>Note: Tables separated by comma</i></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
			<td width="20">&nbsp;</td>
			<td valign="top">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><strong>Database Information</strong></td>
				</tr>
				<tr>
					<td valign="top" style="padding-top:5px">
						<input type="hidden" name="chk_passentry">
						<table border="0" cellpadding="7" cellspacing="0" style="border:1px solid #000000;">
						<tr>
							<td style="padding-top:12px"><input type="text" name="txt_server" class="text" value="<?php echo ($_POST['txt_server']!="")?$_POST['txt_server']:"Server";?>" style="width:200px;" <?php echo (($_POST['txt_server']=="")? "onfocus=\"javascript: if(Trim(this.value)=='Server') this.value='';\" onblur=\"javascript:if(Trim(this.value)=='')this.value='Server';\"":"")?>></td>
						</tr>
						<tr>
							<td><input type="text" name="txt_username" class="text" value="<?php echo ($_POST['txt_username']!="")?$_POST['txt_username']:"Username";?>" style="width:200px;" <?php echo (($_POST['txt_username']=="")? "onfocus=\"javascript: if(Trim(this.value)=='Username') this.value='';\" onblur=\"javascript:if(Trim(this.value)=='')this.value='Username';\"":"")?>></td>
						</tr>
						<tr>
							<td><input type="text" name="txt_password" class="text" value="<?php echo ($_POST['txt_username']!="")?$_POST['txt_password']:"Password";?>" style="width:200px;" <?php echo (($_POST['txt_password']=="")? "onfocus=\"javascript: if(Trim(this.value)=='Password') this.value='';this.form.chk_passentry.value='1';\" onblur=\"javascript:if(Trim(this.value)=='' && this.form.chk_passentry.value!='1')this.value='Password';\"":"")?>></td>
						</tr>
						<tr>
							<td style="padding-bottom:12px"><input type="text" name="txt_database" class="text" value="<?php echo ($_POST['txt_database']!="")?$_POST['txt_database']:"Database";?>" style="width:200px;" <?php echo (($_POST['txt_database']=="")? "onfocus=\"javascript: if(Trim(this.value)=='Database') this.value='';\" onblur=\"javascript:if(Trim(this.value)=='')this.value='Database';\"":"")?>></td>
						</tr>
						</table>					
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>	
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<?php
if($_POST['cmd_submit']!=NULL) {
	error_reporting(1);
	$con=mysql_connect($_POST['txt_server'],$_POST['txt_username'],$_POST['txt_password']);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($_POST['txt_database']);
	if($_POST['txt_query']=="1") {
		$fields = $_POST['txt_fields'];
		$tables = $_POST['txt_table'];
		$conditionall = stripslashes($_POST['txt_condition']);
		if($conditionall!="") {
			$conditionall = " and ".$conditionall;
		}
		$query = "select ".$fields." from ".$tables." where 1=1".$conditionall;
	} else {
		$query = stripslashes($_POST['txt_query']);
	}
	$result = mysql_query($query,$con);
	if (!$result) {
		die('Query failed: ' . mysql_error());
	}

?>
<tr>
	<td align="center">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td style="font-size:13px;"><strong>Rows: <?php echo mysql_num_rows($result);?></strong></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		</table>
		<table border="0" cellpadding="4" cellspacing="1" bgcolor="#000000">
		<tr bgcolor="#E3E3E3">
		<?php 
			$i=0;
			$fieldcount = mysql_num_fields($result);
			echo '<td align="center" nowrap><strong>Sl.No.</strong></td>';
			while ($i < mysql_num_fields($result)) {
				 $fielddata = mysql_fetch_field($result, $i);
				 echo '<td align="center"><strong>'.$fielddata->name.'</strong></td>';
				 $i++;
			}
		?>
		</tr>
		<?php 
			$j=1;
			while($row=mysql_fetch_array($result,MYSQL_BOTH)) {
				echo '<tr bgcolor="#FFFFFF">';
					echo '<td align="center" nowrap>'.$j.'</td>';
					for($i=0;$i<$fieldcount;$i++) {
						$value = ($row[$i]!=NULL)?$row[$i]:"&nbsp;";
						echo '<td align="'.(($i==0)?"left":"center").'">'.$value.'</td>';
					}
				echo '</tr>';
				$j++;
			}
		?>
		</table>
	</td>
</tr>
<?php }?>
</table>
</form>
