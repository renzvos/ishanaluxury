<?php
require "..\Db\backed.php";
require "..\Db\Payments.php";

$payer = new Payments();

$order= $payer->GetTxn('26');
$profile = json_decode($order['profile']);
print_r($profile);
echo $profile->displayname;

?>