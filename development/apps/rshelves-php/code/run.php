<?php


class BackupSource{
public  $TurnON = false;
public $backupAPPID = 1;
public $url;

	function __construct()
	{
		$prod = new Production();
		$this->url = $prod->backupapi;
	}
	
	function Insert($table,$col,$val){if($this->TurnON){
		$call = new CallAPI();
		$data = array("table"=>$table, "col"=>$col, "val"=>$val, "id" => $this->backupAPPID);
		$returncode = $call->CallPostAPI($this->url."insert.php",$data);
		//echo $returncode;
	}}
	
	function Update($query, $param_type, $param_value_array){if($this->TurnON){
		$call = new CallAPI();
		$json = json_encode($param_value_array);
		$data = array("query"=>$query, "type"=>$param_type, "array"=>$json, "id" => $this->backupAPPID);
		$returncode = $call->CallPostAPI($this->url."update.php",$data);
		//echo $returncode;
	}}


	



	
	

	
	
	
	
}

?>