<?php

require "../Db/CartControl.php";
require "../Db/ProductsControl.php";
require "../snippets/Widgets.php";
require "../Db/backed.php";
require "../Db/StorageControl.php";
require "../Db/CallAPI.php";

header('Access-Control-Allow-Origin: *');

$cc = new CartControl();
$pc = new Products();

$pdet = $cc->GetCart($_GET["email"]);
$carter = $pdet['cart_items'];

$products = array();
if($carter != null)
{
foreach($carter as $pp)
{
	$pd = $pc->GetProductbyID($pp->id);
	$image = 1;
	$row['final_price'] = $pd['final_price'];
	$row['quantity']  = $pp->quantity;
	$row['final'] = $row['final_price'] * $row['quantity'];
		$row['Images'] = $pd['Images'];
	array_push($products,$row);
}

$wid = new Widgets();

echo $wid->ViewCart($products,$_GET["email"],false);
}

?>