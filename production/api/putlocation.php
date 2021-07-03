<?php

require "../Db/Analytics.php";
require "../Db/backed.php";
require "../Db/CallAPI.php";

$data = $_GET["data"];
$id = $_GET["i"];


$anal = new Analytics();

echo $anal->Putlocation($data,$id);


?>