<?php
require "../Db/CartControl.php";
require "../Db/ProductsControl.php";
require "../snippets/Widgets.php";
require "../Db/backed.php";
require "../Db/StorageControl.php";
require "../Db/CallAPI.php";


$cc = new CartControl();
$pc = new Products();

$pdet = $cc->ChangeQuantity($_GET["email"],$_GET["id"],$_GET["q"]);
$carter = $pdet['cart_items'];

$products = array();

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

?>