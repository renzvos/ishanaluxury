<?php

require "../Db/Analytics.php";
require "../Db/backed.php";
require "../Db/CallAPI.php";

$page = $_GET["p"];
$id = $_GET["i"];


$anal = new Analytics();

echo $anal->MoreThan3sec($page,$id);


?>