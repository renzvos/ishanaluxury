<?php
session_start();
require "snippets/sidebar.php";
require "snippets/Layout.php";
require "snippets/content.php";
require "snippets/Main.php";
require "snippets/Widgets.php";
require "snippets/Head.php";
require "snippets/slider.php";
require "Db/backed.php";
require "Db/JS.php";
// require "..\..\Db\Categories.php";
require "Db/ProductsControl.php";
require "Db/CartControl.php";
require "Db/DeliveryOrderManagement.php";
require "Db/Values.php";
require "Db/StorageControl.php";
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("Orders");

$wid = new Widgets();
$OM = new Order();
$val = new Values();
$prod = new Products();

$cc = new CartControl();




if(isset($_GET["google"]))
{
	$api = new CallAPI();
	$result = json_decode($api->CallSimpleAPI("https://oauth2.googleapis.com/tokeninfo?id_token=".$_GET["google"]));
	if(!empty($result->error))
	{	if($result->error == 'invalid_token')
		{$_SESSION["gm"] = '<h5 style="color:rgba(232, 74, 74, 1);margin:10px;">Invalid Token</h5>';}
		
	}
	else
	{
		if(empty($result->email))
		{
			$_SESSION["gm"] = "Login must have an E-mail";
		}
		else
		{	$_SESSION["authenticated"]  = true;
			$_SESSION["email"] = $result->email;
			$_SESSION["name"] = $result->name;
			$_SESSION["image"] = $result->picture;
			$_SESSION["gm"] = '<h5 style="color:rgba(5, 143, 0, 1);margin:10px;">Logged in as '.$_SESSION["name"].'</h5>';
			$_SESSION["token"] = $_GET["google"];
		}
	}
}


if(isset($_SESSION["authenticated"]))
{
if(is_null($cc->GetCart($_SESSION["email"])))
{$cc->CreateCart($_SESSION["email"]);}
else
{}
}

else
{
	header('Location:404.html');
}






$data = $OM-> GetUserOrders($_SESSION["email"]);
$orders = array();
foreach($data as $order)
{	$pdet = $prod->GetProductbyID($order['product']);
	$neworder['id'] = $order['id'];
	$neworder['productname'] = $pdet['product_Name'];
	$neworder['price'] = $order['final_price'];
	$neworder['date'] = $order['Date'];
	$neworder['Images'] = $pdet['Images'];
	switch($order['status'])
	{
		case 'Ordered':
		$neworder['message'] = "You order is ready to dispatch";
		$neworder['Refundable'] = true;
		break;
		case 'Refund Initiated':
		$neworder['message'] = "Your refund has been initiated, Money will be back within 24 hours";
		$neworder['Refundable'] = false;
		break;
		case 'Refunded':
		$neworder['message'] = "Your money has been refunded";
		$neworder['Refundable'] = false;
		break;
		case 'Dispatched':
		$neworder['message'] = 'You package is on the way';
		$neworder['Refundable'] = false;
		break;
		case 'Delivery':
		$neworder['Refundable'] = false;
		$neworder['message'] = 'Your Package is out for Delivery';
		break;
		case 'Delivered':
		$neworder['message'] = 'Your Package has been delivered';
		$neworder['Refundable'] = false;
		break;
		default:
		$neworder['message'] = 'Invalid Message';
		$neworder['Refundable'] = false;
	}

	$neworder['percentage'] = $order['percentage'];

	
	array_push($orders,$neworder);
	
	if(isset($_POST['refund'.$neworder['id']]))
	{
		$OM->UpdateStatus("Refund Initiated",75,$neworder['id']);
		header('Location:orders.php');
	}
	
}


$Sidebar = new SideBar($val->DefaultSidebar());
$slider = new Slider();
$wid = new Widgets();

$html = '
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="992932959857-fkhi7blmcqg577mkq2odg9kcrqjig6ci.apps.googleusercontent.com">
<section>
<div class="container"><div class="row">';

$html = $html.$Sidebar->Build();
$html = $html.'<div class="col-sm-9 padding-right">';

$html = $html.$wid->OrdersList($orders);


$html = $html.'</div>';
$html = $html.'</div></div></section>
<script>
function onSignIn(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
  window.location.href = "orders.php?google="+id_token;
}
</script>
';






$content = new Content($html);





$layout = new Layout($val->DefaultHead(),$content);

echo $layout->Build();

?>