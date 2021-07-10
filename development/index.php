<?php
session_start();
require "snippets/sidebar.php";
require "snippets/Layout.php";
require "snippets/content.php";
require "snippets/Main.php";
require "snippets/Widgets.php";
require "snippets/Head.php";
require "snippets/slider.php";
require "apps/backend/code/run.php";
require "Db/JS.php";
require "Db/ProductsControl.php";
require "Db/CartControl.php";
require "Db/Values.php";
require "Db/StorageControl.php";
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("Index");


$wid = new Widgets();
$val = new Values();
$prod = new Products();
$fp = $prod->GetProductBySold();
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
			$anal->Login($_SESSION['sesid'],$result->email);
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




$Sidebar = new SideBar($val->DefaultSidebar());
$slider = new Slider();
$wid = new Widgets();




$html = "";

$html = $html.$slider->Build();
$html = $html.$val->GoogleSignInit().'
<section>
<div class="container"><div class="row">';

$html = $html.$Sidebar->Build();
$html = $html.'<div class="col-sm-9 padding-right">';



$html = $html.$wid->Featured($fp,'Featured Items');

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