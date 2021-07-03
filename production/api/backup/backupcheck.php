<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");


require "../../Db/Production.php";
$prod = new Production();
 //ENTER THE RELEVANT INFO BELOW
    $user      = $prod->user;
    $pass      = $prod->password;
    $host      = $prod->host;
    $name             = $prod->database;


$mysqli = new mysqli($host,$user,$pass,$name); 
$queryTables    = $mysqli->query('SHOW TABLES'); 
$output = array();

foreach ($queryTables as $tab) {

	$table['name'] =  $tab["Tables_in_".$name];
	$c    = $mysqli->query('SELECT COUNT(*) FROM '.$table['name']); 
	$counter = $c->fetch_assoc()['COUNT(*)'];
	
	$table['count'] = $counter + 0;

	array_push($output,$table);
}


$json = json_encode($output);
echo $json;



?>