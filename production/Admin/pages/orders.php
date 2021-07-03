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
require "../../Db/DeliveryOrderManagement.php";
//require "..\..\Db\UserControl.php";
require "../../Db/DeliveryStaff.php";


$wid = new Widgets();


$SidebarC = array();
array_push($SidebarC,array(false,"index.php","fingerprint","Dashboard"));
array_push($SidebarC,array(true,"orders.php","fingerprint","Orders"));
array_push($SidebarC,array(false,"stafflist.php","fingerprint","Staff"));
array_push($SidebarC,array(false,"productlist.php","fingerprint","Products"));
array_push($SidebarC,array(false,"sales.php","fingerprint","Sales"));
$Sidebar = new SideBar('RENZvos','purple','',$SidebarC);
$html = "";

$order = new Order();
//$user = new Users();
$staff = new DeliveryStaff();
$list = $order->GetNewOrder();

$header = array("ID","Customer Name","Price","Status","Location","Assigned Staff");
$rows =array();
$links = array();

 


if(count($list) != 0){
foreach($list as $row)
{

$st= $staff->GetStaff($row['deliverystaff']);
switch($row['status']){
		case 'Ordered':
		$status = '<form method="post"><input type="submit" name="dispatched'.$row['id'].'" class="btn btn-warning btn-round" value="'.$row['status'].'"></form>';
		if(isset($_POST['dispatched'.$row['id']])){$order->UpdateStatus("Dispatched",33,$row['id']);header('Location:orders.php');}
		break;
		case 'Refund Initiated':
		$status = '<form method="post"><input type="submit" name="refund'.$row['id'].'" class="btn btn-danger btn-round" value="'.$row['status'].'"></form>';
		if(isset($_POST['refund'.$row['id']])){$order->UpdateStatus("Refunded",100,$row['id']);header('Location:orders.php');}
		break;
		case 'Refunded':
		
		break;
		case 'Dispatched':
		$status = '<form method="post"><input type="submit" name="delivery'.$row['id'].'" class="btn btn-warning btn-round" value="'.$row['status'].'"></form>';
		if(isset($_POST['delivery'.$row['id']])){$order->UpdateStatus("Delivery",66,$row['id']);header('Location:orders.php');}
		break;
		case 'Delivery':
		$status = '<form method="post"><input type="submit" name="finish'.$row['id'].'" class="btn btn-success btn-round" value="'.$row['status'].'"></form>';
		if(isset($_POST['finish'.$row['id']])){$order->UpdateStatus("Delivered",100,$row['id']);header('Location:orders.php');}
		break;
		case 'Delivered':
		
		break;
		default:
		
}	
	
	
	array_push($rows,array($row['id'],$row['FirstName'],$row['final_price'],$status,$row['Country'].','.$row['State'],$st['Name']));
	array_push($links,"invoice.php?id=".$row['id']);
	
	
}
$html = $html.$wid->CreateTable("Undelivered Orders","",$header,$rows,$links);
}






$Main = new Main($html);
$content = new Content("Dashboard",$Main);
$layout = new Layout($Sidebar,$content);

echo $layout->Build();
last:
?>