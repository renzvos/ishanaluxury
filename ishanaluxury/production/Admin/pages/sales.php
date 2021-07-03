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


$wid = new Widgets();

$SidebarC = array();
array_push($SidebarC,array(false,"index.php","fingerprint","Dashboard"));
array_push($SidebarC,array(false,"orders.php","fingerprint","Orders"));
array_push($SidebarC,array(false,"stafflist.php","fingerprint","Staff"));
array_push($SidebarC,array(false,"productlist.php","fingerprint","Products"));
array_push($SidebarC,array(true,"sales.php","fingerprint","Sales"));

$Sidebar = new SideBar('RENZvos','purple','',$SidebarC);

//$header = array("id","Name","Age");
//$rows = array(array("1","Arshad","22"),array("2","Arshad","22"),array("3","Arshad","22"));
$html = "";

// $html = $wid->CreateTable("Created Table","Etho subtitle",$header,$rows);
//$itemrows = array(array("1","thenga","3","20","60"),array("1","thenga","3","20","60"));

//$html = $html.$wid->CreateInvoice("Arshad","9526669445","abc","122495","1234559","Ready to Dispatch",$itemrows);


//$html = $html.$wid->EditProduct("","","","");

$Main = new Main($html);


$content = new Content("Dashboard",$Main);



$layout = new Layout($Sidebar,$content);

echo $layout->Build();
last:
?>