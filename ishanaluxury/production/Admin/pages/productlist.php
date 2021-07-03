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
require "../../Db/backed.php";
require "../snippets/sidebar.php";
require "../snippets/Layout.php";
require "../snippets/content.php";
require "../snippets/Main.php";
require "../snippets/Widgets.php";
require "../../Db/ProductsControl.php";


$wid = new Widgets();

$SidebarC = array();
array_push($SidebarC,array(false,"index.php","fingerprint","Dashboard"));
array_push($SidebarC,array(false,"orders.php","fingerprint","Orders"));
array_push($SidebarC,array(false,"stafflist.php","fingerprint","Staff"));
array_push($SidebarC,array(true,"productlist.php","fingerprint","Products"));
array_push($SidebarC,array(false,"sales.php","fingerprint","Sales"));

$Sidebar = new SideBar('RENZvos','purple','',$SidebarC);
$html = "";
$html = $html.$wid->LeftButton("Add Product","EditProduct.php?id=0");

$pd = new Products();
$products = $pd->GetProductBySold();

if(count($products) != 0)
{	
	$header = array("id","Product Name","Old Price","New Price","Availability","Category");
	$rows = array();
	$links = array();
	foreach($products as $product)
	{	if($product['Instock'] == 0){$stock = '<i class="material-icons">check_box_outline_blank</i>';}else{$stock = '<i 		class="material-icons">check_box</i>';}
		
	
	
		array_push($rows,array($product['id'],$product['product_Name'],$product['price'],$product['final_price'],$stock,
	$product['Sex']));
	
		array_push($links,"ViewProduct.php?id=".$product['id']);
	}
	$html = $html.$wid->CreateTable("Products","Sorted by Most Used",$header,$rows,$links);
}



 
//$itemrows = array(array("1","thenga","3","20","60"),array("1","thenga","3","20","60"));

//$html = $html.$wid->CreateInvoice("Arshad","9526669445","abc","122495","1234559","Ready to Dispatch",$itemrows);


//$html = $html.$wid->EditProduct("","","","");

$Main = new Main($html);


$content = new Content("Dashboard",$Main);



$layout = new Layout($Sidebar,$content);

echo $layout->Build();
last:

?>