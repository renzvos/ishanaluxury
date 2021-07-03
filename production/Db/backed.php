<?php 
require "DBController.php" ;
require "Production.php";
require "CallAPI.php";
require "BackupSource.php";
$Db = new DBController();

class backed {

 
	
	function GetTableCount($table,$col)
	{$Db = new DBController();
		$sql = "SELECT COUNT(".$col.") AS count FROM ".$table;
		
		$result = $Db->RawSQL($sql);
		return $result[0]['count'];
		}
		

	
		
	 function Insert($table, $col,$val) {
		$Db = new DBController();
        $sql = "INSERT INTO ".$table."(".$col.") VALUES (".$val.")";
		$result = $Db->RawSQL($sql);
		$sql;

		$backup = new BackupSource();
        echo $backup->Insert($table,$col,$val);

	    return $result;
    }
	
	function GetTable($table,$wheresql,$limit)
	{	$Db = new DBController();
		$sql = "SELECT * FROM ".$table;
		
		if($wheresql != ""){
		 $sql = $sql." WHERE ".$wheresql;
		}
		
		if($limit != 0)
		{ $sql = $sql." LIMIT ".$limit;
			}
			
		$result = $Db->RawSQL($sql);
		return $result;
		
	}
	
	function GetDisticntRow($table,$row)
	{	$Db = new DBController();
		$sql = "SELECT DISTINCT `".$row."` FROM `".$table."`";
		$result = $Db->RawSQL($sql);
		return $result;
		
		}
		
	function GetPref($key)
	{
		$Db = new DBController();
		$sql = "SELECT  `value` FROM `preferences` WHERE `key_` = '".$key."'";
		$result = $Db->RawSQL($sql);
		 return $result[0]['value'];
		
	
	}
	
	

}
?>