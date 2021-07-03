<?php 
class DeliveryStaff
{
	function AddStaff($Name,$dp)
	{
	$ser = new backed();
	$coulmn = ' `Name`, `online`, `last_location`, `current_order` ,`dp`';
	$values =  "'".$Name."','0','{}','0','".$dp."'";
	$ser->Insert("delivery",$coulmn,$values);
	return 1;
	}
	
	
	
	function Online($id,$status)
	{
		$Db = new DBController();
		$query = "UPDATE `delivery` SET `online` = ? WHERE `id` = ?";
   		$result = $Db->update($query,"si", array($status,$id));
	}
	
	function Updatelocation($loc,$id)
	{
		$Db = new DBController();
		$query = "UPDATE `delivery` SET `last_location` = ? WHERE `id` = ?";
   		$result = $Db->update($query,"si", array($loc,$id));
	}
	
	function UpdateTemp($id,$temp)
	{
		$Db = new DBController();
		$query = "UPDATE `delivery` SET `temp` = ? WHERE `id` = ?";
   		$result = $Db->update($query,"si", array($temp,$id));
	}
	
	function Set_Order($orderid,$delid)
	{
		$Db = new DBController();
		$query = "UPDATE `delivery` SET `current_order` = ? WHERE `id` = ?";
   		$result = $Db->update($query,"si", array($orderid,$delid));}
	
	
	function GetAllStaff()
	{
		$Db = new DBController();
        $result = $Db->RawSQL("SELECT * FROM delivery");
        return $result;
	}
	
	function GetStaff($id)
	{
		$Db = new DBController();
        $result = $Db->runQuery("SELECT `Name`FROM delivery WHERE `id` = ?", "i", array($id));
        return $result[0];
	}
	
	
	
}
	
?>