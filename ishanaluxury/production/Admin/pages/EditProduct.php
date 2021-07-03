<?php
session_start();
if(isset($_SESSION["ADMIN"])){}
else{
if(isset($_POST['submit']) && $_POST['pass'] == "ARSHADNZR") 
{$_SESSION["ADMIN"]  = true;}
else
{
	echo '<html><form method="post"><input type="password" name="pass"><input type="submit" name="submit" value="submit"></form></html>';
	goto last;	
}
}

require "../snippets/sidebar.php";
require "..\snippets\Layout.php";
require "..\snippets\content.php";
require "..\snippets\Main.php";
require "..\snippets\Widgets.php";
require "..\..\Db\backed.php";
require "..\..\Db\StorageControl.php";
require "..\..\Db\Categories.php";
require "..\..\Db\ProductsControl.php";




$wid = new Widgets();


$SidebarC = array();
array_push($SidebarC,array(true,"index.php","fingerprint","Dashboard"));
array_push($SidebarC,array(false,"orders.php","fingerprint","Orders"));
array_push($SidebarC,array(false,"stafflist.php","fingerprint","Staff"));
array_push($SidebarC,array(false,"productlist.php","fingerprint","Products"));
array_push($SidebarC,array(false,"sales.php","fingerprint","Sales"));


$Sidebar = new SideBar('RENZvos','purple','',$SidebarC);
$html = "";
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
$pd = new Products();
$id = $_GET['id'];
if($id == 0)
{
	 $html = $html.$wid->EditProduct("","","","","","","[2,2,2,2]");
	 // 2 is the sample image when there is no image 
}
else
{
	$product = $pd->GetProductbyID($id);
	if($product['Instock'] == 0)
	{$stock = false;}else if($product['Instock'] == 1){$stock = true;}
	$html = $html.$wid->EditProduct($product['product_Name'],$product['price'],$product['final_price'],$product['description'],
	$product['category'],$stock,$product['Images']);
}

// $html = $html.$wid->EditProduct("","","","");

$Main = new Main($html);


$content = new Content("Dashboard",$Main);



$layout = new Layout($Sidebar,$content);

echo $layout->Build();
last:
?>