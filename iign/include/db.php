<?php
class dbconn extends DBConnection {
	function dbconn($host, $username, $password, $dbname) {
		$this->openDB($host, $username, $password, $dbname);
	}

	function getdatalistfromquery($dataquery) {		
		$result = $this->query($dataquery);
		$datalist =  $this->fetchAll($result);
		$this->FreeResult($result);
		return $datalist;
	}

	function getdatalist($fields, $tables, $where=NULL, $sortstr=NULL, $start=NULL, $offset=NULL) {
		$dataquery = "Select {$fields} from $tables where 1=1";
		if($where != NULL)
			$dataquery .= " and ({$where})";
		if($sortstr != NULL)
			$dataquery .= " {$sortstr}";
		if($start != NULL)
			$dataquery .= " LIMIT {$start}, {$offset}";
		$result = $this->query($dataquery);
		$datalist =  $this->fetchAll($result);
		$this->FreeResult($result);
		return $datalist;
	}

	function getlimiteddata($fields, $tables, $limitstr=NULL, $where=NULL, $sortstr=NULL) {
		$dataquery = "Select {$fields} from $tables where 1=1";
		if($where != NULL)
			$dataquery .= " and ({$where})";
		if($sortstr != NULL)
			$dataquery .= " {$sortstr}";
		if($limitstr != NULL)
			$dataquery .= " {$limitstr}";
		$result = $this->query($dataquery);
		$datalist =  $this->fetchAll($result);
		$this->FreeResult($result);
		return $datalist;
	}

	function getuniondata($fields, $tables, $where=array(), $sortstr=NULL, $limitstr=NULL) {
		if(!is_array($fields) || !is_array($tables) || count($fields)!=count($tables)) {
			return array();
		}
		$dataquery = array();
		$query = "";
		for($i=0; $i<count($fields); $i++) {
			$dataquery[$i] = "Select ".$fields[$i]." from ".$tables[$i]." where 1=1";
			if(isset($where[$i]) && $where[$i] != NULL)
				$dataquery[$i] .= " and (".$where[$i].")";
		}
		for($i=0; $i<count($dataquery); $i++) {
			$query .= "(".$dataquery[$i].")";
			$query .= ((count($dataquery)-1)!=$i)?" UNION ":" ";
		}
		if($sortstr != NULL)
			$query .= " {$sortstr}";
		if($limitstr != NULL)
			$query .= " {$limitstr}";
		$result = $this->query($query);
		$datalist =  $this->fetchAll($result);
		$this->FreeResult($result);
		return $datalist;
	}

	function save($table, $data, $where = "") {
		$dataset_a = array();
		foreach($data as $k=>$w) {
			if($w != NULL)
				$dataset_a[] = "$k = '".addslashes($w)."'";
			else
				$dataset_a[] = "$k=NULL";
		}
		
		$dataset = implode(" , " , $dataset_a);
		if ($where) {
		    // echo "UPDATE $table SET $dataset WHERE $where"; die();
			$this->query("UPDATE $table SET $dataset WHERE $where");
			$inst_id = $this->AffectRows();
		} else {
			//echo "INSERT INTO $table SET $dataset"; die;
			$inst_id = $this->execute("INSERT INTO $table SET $dataset");
		}
		return $inst_id;
	}

	function delete_rows($table, $where) {
		$delquery = "DELETE FROM ".$table." WHERE ".$where;
		$this->query($delquery);
	}
	######## Add new ##################
	function getUsers($filter=NULL) {
		$query = "SELECT * FROM tbl_users WHERE 1=1 ".$filter." ORDER BY name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getClientNames($clientid) {
		$query = "SELECT person_id, person_name FROM tbl_contact_persons WHERE client_id='".$clientid."' AND person_status=1 GROUP BY person_name ORDER BY person_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getAllClients() {
		$query = "SELECT client_id, client_name FROM tbl_clients WHERE client_status=1 ORDER BY client_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getJobStatus($jobid) {
		$query = "SELECT job_status FROM tbl_job_status WHERE job_id='".$jobid."' ORDER BY status_id DESC LIMIT 0,1";
		$result = $this->getdatalistfromquery($query);
		return (isset($result[0]["job_status"])?$result[0]["job_status"]:"");
	}
	function getAllocation($jobid=NULL) {
		$query = "SELECT al.*, u1.name AS donebyname, u2.name AS reporttoname FROM tbl_allocate_job AS al INNER JOIN tbl_users AS u1 ON u1.userid = al.doneby INNER JOIN tbl_users AS u2 ON u2.userid = al.reportto WHERE al.job_id='".$jobid."'";
		return $this->getdatalistfromquery($query);
	}
	function getEstimate($jobid,$eid=NULL) {
		$where = ($eid!=NULL)?' AND estimate_id="'.$eid.'"':'';
		$query = "SELECT * FROM tbl_estimates WHERE job_id='".$jobid."'".$where;
		return $this->getdatalistfromquery($query);
	}
	function getEstimateData($jobid) {
		$query = "SELECT * FROM tbl_estimate_data WHERE estimate_id='".$jobid."' ORDER BY data_id ASC";
		return $this->getdatalistfromquery($query);
	}
	function getEstimateNotes($jobid) {
		$query = "SELECT * FROM tbl_estimate_notes WHERE estimate_id='".$jobid."'";
		return $this->getdatalistfromquery($query);
	}
	function getJobTypes() {
		$query = "SELECT job_type_id, job_type_name FROM tbl_job_type WHERE job_type_status=1 ORDER BY job_type_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getProductionSizes() {
		$query = "SELECT size_id, size_name FROM tbl_production_size WHERE size_status=1 ORDER BY size_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function fetchAnswers($question_id) {
		$query = "SELECT question_id, answer_id, answer from tbl_quiz_answers where question_id = '".$question_id."' ";	
		$arrAnswers = $this->getdatalistfromquery($query);
		return $arrAnswers;		
	}
	function getPublications() {
		$query = "SELECT publication_id, publication_name FROM tbl_publication WHERE publication_status=1 ORDER BY publication_name ASC";
		$arrPublicationsTemp = $this->getdatalistfromquery($query);
		if(count($arrPublicationsTemp)>0) {
			$i=0;
			$temp = array();
			foreach($arrPublicationsTemp as $pkey=>$pvalue) {
				if($pvalue["publication_name"]=="Others") {
					$temp = $pvalue;
				} else {
					$arrPublications[$i++] = $pvalue;
				}
			}
			if(isset($temp)) 
				$arrPublications[$i] = $temp;
		} else {
			$arrPublications = $arrPublicationsTemp;
		}
		return $arrPublications;
	}
	function getPublicationFormats() {
		$query = "SELECT format_id, format_name FROM tbl_publication_format WHERE format_status=1 ORDER BY format_name ASC";
		$arrPublicationFormatsTemp = $this->getdatalistfromquery($query);
		if(count($arrPublicationFormatsTemp)>0) {
			$i=0;
			$temp = array();
			foreach($arrPublicationFormatsTemp as $pkey=>$pvalue) {
				if($pvalue["format_name"]=="Others") {
					$temp = $pvalue;
				} else {
					$arrPublicationFormats[$i++] = $pvalue;
				}
			}
			if(isset($temp)) 
				$arrPublicationFormats[$i] = $temp;
		} else {
			$arrPublicationFormats = $arrPublicationFormatsTemp;
		}
		return $arrPublicationFormats;
	}
	function getJobPublicationData($jobid) {
		$query = 'SELECT publication.publication_name AS name, pub.size, pformat.format_name AS format, pub.publication_id, pub.format AS format_id  FROM tbl_job_publication AS pub INNER JOIN tbl_publication AS publication ON publication.publication_id = pub.publication_id AND publication.publication_status=1 INNER JOIN tbl_publication_format AS pformat ON pformat.format_id = pub.format AND pformat.format_status =1 WHERE jobid="'.$jobid.'" ORDER BY pub.pub_id ASC';
		return $this->getdatalistfromquery($query);
	}
	function getJobProductonData($jobid) {
		$query = 'SELECT jtype.job_type_name AS name, psize.size_name AS size, prod.prod_description AS description, prod.job_type_id, prod_size  FROM tbl_job_production AS prod INNER JOIN tbl_job_type AS jtype ON jtype.job_type_id = prod.job_type_id AND jtype.job_type_status=1 INNER JOIN tbl_production_size AS psize ON psize.size_id = prod.prod_size AND psize.size_status=1 WHERE jobid="'.$jobid.'" ORDER BY prod.prod_id ASC';
		return $this->getdatalistfromquery($query);
	}
	function getTax() {
		$arrResult = array();
		$query = 'SELECT * FROM tbl_tax ORDER BY tax_name ASC';
		$arrData = $this->getdatalistfromquery($query);
		/* if(count($arrData)>0) {
			foreach($arrData as $key=>$value) {
				$arrResult[$value["tax_type"]][] = $value;
			}
		} */
		return $arrData;
	}
	function getInvoiceData($invid) {
		$query = "SELECT * FROM tbl_invoice_bank WHERE invoiceid='".$invid."'";
		return $this->getdatalistfromquery($query);
	}
	function getPageAccess($userid) {
		$query = "SELECT * FROM tbl_access WHERE user_id='".$userid."'";
		return $this->getdatalistfromquery($query);
	}
	function getAllocationList($jobid) {
		$query = 'SELECT layout_deadline,artwork_deadline,production_deadline,deadline,`work`, doneby, reportto, job_title, client_name, brand_name FROM tbl_allocate_job AS allocation INNER JOIN tbl_jobs AS jobs ON jobs.job_id = allocation.job_id INNER JOIN tbl_clients ON tbl_clients.client_id = jobs.client_id INNER JOIN tbl_brands ON tbl_brands.brand_id = jobs.brand_id WHERE allocation.job_id="'.$jobid.'"';
		return $this->getdatalistfromquery($query);
	}
	function updateLoginTime($userid) {
		$query = 'UPDATE tbl_users SET lastlogin2=lastlogin, lastlogin= NOW() WHERE userid="'.$userid.'"';
		return $this->query($query);
	}
	######## Add new ##################

	######## for admin ##################
	function getClientsList() {
		$query = "SELECT * FROM tbl_clients ORDER BY client_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getBrandsList() {
		$query = "SELECT tbl_brands.*, tbl_clients.client_name FROM tbl_brands INNER JOIN tbl_clients ON tbl_clients.client_id = tbl_brands.client_id ORDER BY tbl_clients.client_name ASC, tbl_brands.brand_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getPublicationsList() {
		$query = "SELECT * FROM tbl_publication ORDER BY publication_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getPublicationsFormatList() {
		$query = "SELECT * FROM tbl_publication_format ORDER BY format_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getProductionSizeList() {
		$query = "SELECT * FROM tbl_production_size ORDER BY size_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getContactPersonsList() {
		$query = "SELECT tbl_contact_persons.*, tbl_brands.brand_name, tbl_clients.client_name FROM tbl_contact_persons INNER JOIN tbl_clients ON tbl_clients.client_id = tbl_contact_persons.client_id INNER JOIN tbl_brands ON tbl_brands.brand_id = tbl_contact_persons.brand_id ORDER BY tbl_clients.client_name ASC, tbl_brands.brand_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getClientBrandsList($clientid) {
		$query = "SELECT * FROM tbl_brands WHERE client_id='".$clientid."' ORDER BY brand_name ASC";
		return $this->getdatalistfromquery($query);
	}
	function getJobLatestStatus($jobid) {
		$latest_status = '';
		$query = "SELECT job_status FROM tbl_job_status WHERE job_id='".$jobid."' ORDER BY status_id DESC LIMIT 1";
		$status_data = $this->getdatalistfromquery($query);
		if($status_data[0]['job_status']!='')
			$latest_status = $status_data[0]['job_status'];
		return $latest_status;
	}
}
?>