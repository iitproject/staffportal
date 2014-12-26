<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
include_once(__DIR__."/config.php");
/** Load Class Filess */
require_once(__DIR__."/session.php");
require_once(__DIR__."/mysql.php");
require_once(__DIR__."/db.php");
require_once(__DIR__."/userfunctions.php");
require_once(__DIR__."/paging.php");

/** Create database object */
$sqlobj=new dbconn(_HOSTNAME, _USERNAME, _PASSWORD, _DATABASE);
/** Create session object */
$sesobj=new SESSION_MANAGEMENT();

/** Create UserFunctions object */
$userobj=new UserFunctions();

/** Create Pageing Object */
$pageobj=new Pageing('5');

function imageResize($width, $height, $target) {
	if ($width > $height) {
		$percentage = ($target / $width);
	} else {
		$percentage = ($target / $height);
	}
	$width = round($width * $percentage);
	$height = round($height * $percentage);
	return "width=\"$width\" height=\"$height\"";
}

if (!function_exists('json_encode')) {
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}

function convertDate($str, $display=false) {
	if($str=="") 
		return "";
	$arrStr = explode("-", $str);
	if(count($arrStr)==3) {
		if($display==true)
			return mktime(0,0,0,$arrStr[1], $arrStr[2], $arrStr[0]);
		else
			return mktime(0,0,0,$arrStr[1], $arrStr[0], $arrStr[2]);
	} else {
		return "";
	}
}
function convertDateTime($str) {
	if($str=="") 
		return "";
	$arrStr = explode(" ", $str);
	if(count($arrStr)==2) {
		$arrDate = explode("-", $arrStr[0]);
		$arrTime = explode(":", $arrStr[1]);
		return mktime($arrTime[0], $arrTime[1], $arrTime[2], $arrDate[1], $arrDate[2], $arrDate[0]);
	} elseif(count($arrStr)==1) {
		$arrDate = explode("-", $arrStr[0]);
		return mktime(0, 0, 0, $arrDate[1], $arrDate[2], $arrDate[0]);
	} else {
		return "";
	}
}

$pagename = basename($_SERVER["PHP_SELF"]);

$str_pad = 4;
$invoice_prefix = 'ST/';

$flag_job_process = $flag_job_allocation = $flag_job_estimate = $flag_job_invoice = $flag_job_cancellation = false;
if($sesobj->isassign("udm_access") && is_array($sesobj->get("udm_access"))) {
	$arrPageAccess = $sesobj->get("udm_access");
	if($arrPageAccess["job_process"]==1) 
		$flag_job_process = true;
	if($arrPageAccess["job_allocation"]==1) 
		$flag_job_allocation = true;
	if($arrPageAccess["job_estimate"]==1) 
		$flag_job_estimate = true;
	if($arrPageAccess["job_invoice"]==1) 
		$flag_job_invoice = true;
	if($arrPageAccess["job_cancellation"]==1) 
		$flag_job_cancellation = true;
}

$arrTax = $sqlobj->getTax();
$arrUserNamesTemp = $sqlobj->getUsers();
$arrUserNames = array();
if(count($arrUserNamesTemp)>0) {
	foreach($arrUserNamesTemp as $ukey=>$uvalue) {
		$arrUserNames[$uvalue["userid"]] = $uvalue["name"];
	}
}

$arrUsersTemp = $sqlobj->getUsers();
$arrUsersData = array();
if(count($arrUsersTemp)>0) {
	foreach($arrUsersTemp as $key=>$value) {
		$arrUsersData[$value["userid"]] = $value;
	}
}
?>