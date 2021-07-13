<?php

require "../Db/Location.php";

require "../Db/CallAPI.php";


$loc = new Location();




echo $loc->DatefromPincode($_GET["pc"]);

?>