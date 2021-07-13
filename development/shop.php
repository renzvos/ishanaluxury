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


require "webapp/JS.php";
require "CommonHTML.php";

require "Apps/backend/code/run.php";
require "Apps/Product-Control/code/run.php";
require "Apps/Ecommerce-Cart-Control/code/run.php";
require "Apps/Storage-Control/code/run.php";
require "Apps/rex-client-php/code/run.php";
require "Apps/Ecommerce-Order-Control/code/run.php";



$anal = new AnalyticsClient("Shop");


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




if(isset($_GET["color"]))
{
	$fp = $prod->GetProductByAttribute("Color",$_GET["color"]);
}
else if(isset($_GET["sex"]))
{	
	$mix =  $prod->GetProductByAttribute("Sex","FM");
	$q = $prod->GetProductByAttribute("Sex",$_GET["sex"]);
	$fp = array_merge($q,$mix);
	
}
else if(isset($_GET["brand"]))
{}
else if(isset($_GET["key"]))
{
	$fp = $prod->Keyword($_GET["key"]);
}
else
{
	header('Location:404.html');
}

$Sidebar = new SideBar($val->DefaultSidebar());

$html = '';
$html = $html.'
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="992932959857-fkhi7blmcqg577mkq2odg9kcrqjig6ci.apps.googleusercontent.com">
<section>
<div class="container"><div class="row">';

$html = $html.$Sidebar->Build();
$html = $html.'<div class="col-sm-9 padding-right">';


if(is_null($fp))
{$html = $html.'<h3><center>Sorry, No Results </center></h3>';
}
else{
$html = $html.$wid->Featured($fp,'Results');
}

$html = $html.'</div>';
$html = $html.'</div></div></section>
<script>
function onSignIn(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
  window.location.href = "index.php?google="+id_token;
}
</script>
';




$content = new Content($html);






$layout = new Layout($val->DefaultHead(),$content);

echo $layout->Build();


?>