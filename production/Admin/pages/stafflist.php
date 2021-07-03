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
require "../../Db/DeliveryStaff.php";
require "../../Db/StorageControl.php";


$wid = new Widgets();

$SidebarC = array();
array_push($SidebarC,array(false,"index.php","fingerprint","Dashboard"));
array_push($SidebarC,array(false,"orders.php","fingerprint","Orders"));
array_push($SidebarC,array(true,"stafflist.php","fingerprint","Staff"));
array_push($SidebarC,array(false,"productlist.php","fingerprint","Products"));
array_push($SidebarC,array(false,"sales.php","fingerprint","Sales"));

$Sidebar = new SideBar('RENZvos','purple','',$SidebarC);
$staff = new DeliveryStaff();
$list = $staff->GetAllStaff();

$header = array("ID","Name","Availability","Location","Current Order");
$html = "";
$html = $html.$wid->LeftButton("Add New staff","NewStaff.php");
$rows =array();

if(count($list) != 0){
foreach($list as $row)
{
 if($row['online'] == 1){
	 $status = '<a href="javascript:;" class="btn btn-success btn-round">Online<div class="ripple-container"></div></a>';
	 }else if($row['online'] == 0)
	 {$status = '<a href="javascript:;" class="btn btn-danger btn-round">Offline<div class="ripple-container"></div></a>';}
 array_push($rows,array($row['id'],$row['Name'],$status,$row['last_location'],$row['current_order'],$row['temp'],$row['dp']));
}
$html = $html.$wid->ViewStaff($rows);
}

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