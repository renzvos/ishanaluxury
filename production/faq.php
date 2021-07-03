
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
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("FAQ");


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





$html = $val->GoogleSignInit().'
	 <div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					<h2 class="title text-center"> <strong>FAQ</strong></h2>    			    				    				
					
				</div>			 		
			</div>    	
<h4>    			
1.  WHERE DO I ENTER THE PROMO CODE???!?!!
</h4>
Your promo code can be entered in on page 2 of checkout. When you are ready to checkout, simply click the Sign in button and enter in your payment information whether you are logging into your account or paying by credit card (you will not be charged at this point). Once complete, you will be redirected back to the site final confirmation where you can enter in the code. Enjoy!

<h4>2.  DO YOU SHIP INTERNATIONALLY?</h4>
Yes, we do ship internationally, BUT shipping and handling rates as well as delivery times will vary depending on your location. If you are ordering from an international location, please contact us by email so that we can guide you throughout your ordering process. To see if your country is activated, please visit our Shipping Info page.

<h4>3. ARE YOUR PRODUCTS AVAILABLE FOR WHOLESALE OR DISTRIBUTION?</h4>
We are always growing and on a mission to reach our fans Worldwide. Please contact us to inquire about wholesale/distribution opportunities.

<h4>4. DO YOU HAVE A INFLUENCER TEAM?</h4>
We are currently gathering loyal fans to who wanna rep ISHANA Masks whether it be on the streets or through their social media feeds. Drop us an email and tell us how you wanna help out.

<h4>5. DO YOU GUYS SPONSOR?</h4>
Please forward us your info and tell us why you want to rep our products.
<br>
<br>
<br>


    			
	    	</div>  
    	</div>	
    </div><!--/#contact-page-->
	
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

	