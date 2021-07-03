<?php
session_start();
if(isset($_SESSION["ADMIN"])){}
else{
if(isset($_POST['submit']) && $_POST['pass'] == "ARSHADNZR") //submit nekiyal
{$_SESSION["ADMIN"]  = true;}
else
{
	echo '<html><form method="post"><input type="password" name="pass"><input type="submit" name="submit" value="submit"></form></html>';
	goto last;	
}
}

require "../snippets/sidebar.php";
require "../snippets/Layout.php";
require "../snippets/content.php";
require "../snippets/Main.php";
require "../snippets/Widgets.php";
require "../../Db/backed.php";
require "../../Db/DeliveryOrderManagement.php";
//require "..\..\Db\UserControl.php";
require "../../Db/DeliveryStaff.php";
require "../../Db/ProductsControl.php";

$wid = new Widgets();
$html = "";

$SidebarC = array();
array_push($SidebarC,array(true,"index.php","fingerprint","Dashboard"));
array_push($SidebarC,array(false,"orders.php","fingerprint","Orders"));
array_push($SidebarC,array(false,"stafflist.php","fingerprint","Staff"));
array_push($SidebarC,array(false,"productlist.php","fingerprint","Products"));
array_push($SidebarC,array(false,"sales.php","fingerprint","Sales"));


$Sidebar = new SideBar('RENZvos','purple','',$SidebarC);
$id = $_GET["id"];

$OM = new Order();
//$UserC = new Users();
$Staff = new DeliveryStaff();
$pd = new Products();


$order = $OM->GetOrder($id);
$user = $order['FirstName'];
$customerName = $order['DisplayName'];
$customerNumber = $order['Phone'];
$location = $order['location'];
$ordertime = "";
$deliverytime = "";
$status = $order['status'];
$itemrows = array();
$list = $order['orderitems'];
$finalprice = $order['final_price'];
$delivery = $order['deliverycharge'];
$counter = 0;
foreach($list as $row)
{$counter = $counter + 1;
$product = $pd->GetProductbyID($row->id);
$price = $product['final_price'];
$total = $price * $row->quantity;
array_push($itemrows,array($counter,$product['product_Name'],$row->quantity,$price,$total));
}

$html = $html.$wid->CreateInvoice($customerName,$customerNumber,$location,$ordertime,$deliverytime,$status,$itemrows,$finalprice,$delivery);
/*
//$header = array("id","Name","Age");
$rows = array();
if(count($list) != 0){
foreach($list as $row)
{
$customer = $user->UserDetails($row['userid']);
	array_push($rows,array($row['id'],$customer['Name'],$row['final_price'],$row['status'],$row['location'],$row['deliverystaff']));
}
$html = $html.$wid->CreateTable("Undelivered Orders","",$header,$rows);
}

*/





//$itemrows = array(array("1","thenga","3","20","60"),array("1","thenga","3","20","60"));

//$html = $html.$wid->CreateInvoice("Arshad","9526669445","abc","122495","1234559","Ready to Dispatch",$itemrows);


//$html = $html.$wid->EditProduct("","","","");

$Main = new Main($html);


$content = new Content("Dashboard",$Main);



$layout = new Layout($Sidebar,$content);

echo $layout->Build();
last:

?>