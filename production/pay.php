
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
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("Pay");
$wid = new Widgets();
$OM = new Order();
$prod = new Products();
$cc = new CartControl();
$production = new Production();


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


$HeadC = array();
array_push($HeadC,array('href="#"','<i class="fa fa-user"></i>',"Home",true));
if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"','<i class="fa fa-user"></i>',"Orders",false));}
array_push($HeadC,array('href="#"','<i class="fa fa-user"></i>',"Checkout",false));
if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"  onclick="ViewCart()"','<i class="fa fa-user"></i>','Cart</a>',false));}
if(!isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"','<div class="g-signin2" data-onsuccess="onSignIn" style="width:130px"></div>',"",false));}
if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"',$_SESSION["gm"],"",false));}


$Head = new Head('',"","fb.com","twitter.com","instagram.com","lkd.com",$HeadC);

$row1 = array('Color',array(array("Red","#"),array("Blue","#"),array("Green","#")));
$row2 = array('Sex',array(array("Male","#"),array("Female","#")));
$row3 = array('Brand',array(array("LinenClub","#"),array("Raymond","#")));

$SidebarC = array($row1,$row2,$row3);



$html = '';


// set URL and other appropriate options
//http://localhost/payments/');

$api = new CallAPI();
$sender = array();
$sender['stream'] = 1;
$sender['amount'] = $_POST['amount'];
$buycover = $_POST['buycover'];

$profile;
$profile['email'] = $_POST['email'];
$profile['displayname'] = $_POST['displayname'];
$profile['billname'] = $_POST['billname'];
$profile['billemail'] = $_POST['email'];
$profile['firstname']= $_POST['firstname'];
$profile['middlename'] = $_POST['middlename'];
$profile['lastname'] = $_POST['lastname'];
$profile['address1']= $_POST['address1'];
$profile['address2'] = $_POST['address2'];
$profile['country'] = $_POST['country'];
$profile['postalcode'] = $_POST['postalcode'];
$profile['state'] = $_POST['state'];
$profile['phone'] = $_POST['phone'];
$profile['fax'] = $_POST['fax'];
$profile['promocode'] = $_POST['promocode'];
$profile['token'] = $_POST['token'];

$data['profile'] = $profile;
$data['cart'] = json_decode($buycover);
$sender['data'] = json_encode($data);

$html = $api->CallPostAPI($production->paymentsapi,$sender);


	

$content = new Content($html);





$layout = new Layout($Head,$content);

echo $layout->Build();

	