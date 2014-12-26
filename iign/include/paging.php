<?PHP
class Pageing {

	var $CurrRow = 0;
	var $size=3; // No. of Records per page
	var $MaxPage = 0;
	var $pageno = 1;
	var $totalrc = 0;
	var $rc1 = 0;
	var $functionflag = true ;
	var $formid = 0;

	function Pageing($size) {
		$this->size = $size;
	}

	function setForm($formid) {
		$this->formid = $formid;
	}

	function setPagesize($size) {
		$this->size = $size;
	}

	function getLimit($PageNo,$totalrc) {
		$this->size;
		$this->totalrc = $totalrc;
		$this->MaxPage = ceil($this->totalrc/$this->size);
		$this->pageno = ($this->MaxPage >= $PageNo)?$PageNo:1;
		$this->CurrRow = ($this->pageno - 1) * $this->size;
		$limit = " LIMIT"." ".$this->CurrRow.",".$this->size ;
		return $limit;
	}

	function showPageing() {
		
		//		Coded by Selvam
		$StartPage = $this->pageno;
		if((($StartPage+10) > $this->MaxPage)&&($this->MaxPage >= 10)) {
			$StartPage = $this->MaxPage - 9 ;
		}
		$EndPage = $StartPage+10;
		if($this->MaxPage <= 10) {
			$EndPage = $this->MaxPage+1;
			$StartPage=1;
		} 

		/*		Coded by Senthil
		$StartPage = $this->pageno;
		
		if((($StartPage+10) >= $this->MaxPage)&&($this->MaxPage >= 10)){$StartPage = $this->MaxPage - 9 ;}
		$EndPage = $StartPage+10;
		if($this->MaxPage <= 10){$EndPage = $this->MaxPage+1;$StartPage=1;} 
		if(($StartPage-5)>0){$StartPage -= 5; $EndPage -= 5;}
		*/

		echo $pre = ($this->pageno==1)?"&lt;&nbsp;Prev&nbsp;|&nbsp;":"<a href='#' onclick='javascript:return paging(document.getElementById(\"".$this->formid."\"),\"".($this->pageno - 1)."\")'>&lt;&nbsp;Prev</a>&nbsp;|&nbsp; ";
		
		for($i=$StartPage;$i<$EndPage;$i++) {
			$startrec = ($i-1)*$this->size;
			$endrec = $startrec + $this->size; 
			if($i==$EndPage-1){$hifstr="";}else{$hifstr="&nbsp;|&nbsp;";}
			if ($this->pageno == $i){echo "<b> ".($startrec+1)."-".$endrec."  </b> $hifstr";}
			else{echo '<a href="#" onclick="javascript:return paging(document.getElementById(\''.$this->formid.'\'),\''.$i.'\')">'.($startrec+1)."-".$endrec.'</a> '.$hifstr ;} 
		}
		echo $next = ($this->MaxPage==$this->pageno)?"&nbsp;|&nbsp;Next&nbsp;&gt; ":"&nbsp;|&nbsp;<a href='#' onclick='javascript:return paging(document.getElementById(\"".$this->formid."\"),\"".($this->pageno + 1)."\")'>Next&nbsp;&gt;</a> ";
		if($this->functionflag)
		{
		echo '<input type="hidden" name="PageNo" value="'.$this->pageno.'">';
		echo '<script language="javascript">function paging(formobj,n){formobj.PageNo.value = n;formobj.action="";formobj.submit();return false;}</script>';
		$this->functionflag = false ;
		}
	}
}
?>