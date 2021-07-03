<?php 
class Payments{
	
	function StartPayment($email,$bag,$amount,$profile,$method) {
		$ser = new backed();
		$coulmn = '`email`,`orderid`,`amount`,`bag`,`method`, `serververified`, `Status`, `ErrorStatus`,`profile`';
		$values = "'".$email."',0,'".$amount."','".$bag."','".$method."','0','Started','','".$profile."'";
		return $ser->Insert("payments",$coulmn,$values);
	}
	
	
	function ServerVerified($txnid,$bankname)
	{
		$Db = new DBController();
	
		$query = "UPDATE `payments` SET `Status` = ?, `serververified` = ?,`ErrorStatus` = ?
		WHERE `id` = ?";
   
		$result = $Db->update($query,"sisi", array("Verified",1,$bankname,$txnid));
		
		
		
	}
	
	function ErrorReport($txnid,$Error)
	{
		$Db = new DBController();
	
		$query = "UPDATE `payments` SET `Status` = ?, `ErrorStatus` = ?
		WHERE `id` = ?";
   
		$result = $Db->update($query,"ssi", array("Error",$Error,$txnid));
	}
	
	function Checkstatus($txnid)
	{
		$Db = new DBController();
        $result = $Db->runQuery("SELECT `Status` FROM payments WHERE `id` = ?", "i", array($txnid));
        return $result[0]['Status'];
	}
	
	function GetTxn($txnid)
	{
		$Db = new DBController();
        $result = $Db->runQuery("SELECT * FROM payments WHERE `id` = ?", "i", array($txnid));
        return $result[0];
	}
	
	
	


	
}


?>