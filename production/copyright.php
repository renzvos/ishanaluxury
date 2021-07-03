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
require "Db/ProductsControl.php";
require "Db/CartControl.php";
require "Db/Values.php";
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("Copyright");

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


$html = $html.$val->GoogleSignInit().'
<section>
<div class="container"><div class="row">';

$html = $html.$Sidebar->Build();
$html = $html.'<div class="col-sm-9 padding-right">';



$html = $html."


<h1>Disclaimer for ISHANALUXURY</h1>

<p>If you require any more information or have any questions about our site's disclaimer, please feel free to contact us by email at ishanaluxury@gmail.com.

<h2>Disclaimers for ishanaluxury.com</h2>

<p>All the information on this website - ishanaluxury.com - is published in good faith and for general information purpose only. ishanaluxury.com does not make any warranties about the completeness, reliability and accuracy of this information. Any action you take upon the information you find on this website (ishanaluxury.com), is strictly at your own risk. ishanaluxury.com will not be liable for any losses and/or damages in connection with the use of our website.</p>

<p>From our website, you can visit other websites by following hyperlinks to such external sites. While we strive to provide only quality links to useful and ethical websites, we have no control over the content and nature of these sites. These links to other websites do not imply a recommendation for all the content found on these sites. Site owners and content may change without notice and may occur before we have the opportunity to remove a link which may have gone 'bad'.</p>

<p>Please be also aware that when you leave our website, other sites may have different privacy policies and terms which are beyond our control. Please be sure to check the Privacy Policies of these sites as well as their Terms of Service before engaging in any business or uploading any information..</p>

<h2>Consent</h2>

<p>By using our website, you hereby consent to our disclaimer and agree to its terms.</p>

<h2>Update</h2>

<p>Should we update, amend or make any changes to this document, those changes will be prominently posted here.</p>


";

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