
<?php
session_start();
require "snippets/sidebar.php";
require "snippets/Layout.php";
require "snippets/content.php";
require "snippets/Main.php";
require "snippets/Widgets.php";
require "snippets/Head.php";
require "snippets/slider.php";
require "Db/JS.php";
require "Db/backed.php";
// require "..\..\Db\Categories.php";
require "Db/ProductsControl.php";
require "Db/CartControl.php";
require "Db/DeliveryOrderManagement.php";
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("RefundPolicy");


$wid = new Widgets();
$OM = new Order();

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



$html = '
	 <div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					<h2 class="title text-center"> <strong>Generic Refund Policy</strong></h2>    			    				    				
					
				</div>			 		
			</div>    	


<h4>Generic Refund Policy Template for Physical Products</h4>
Thanks for purchasing our products at Ishanaluxury operated by Arshad Nazir.<br>
In order to be eligible for a refund, you have to return the product within 30 calendar days of your purchase. The product must be in the same condition that you receive it and undamaged in any way.<br>
After we receive your item, our team of professionals will inspect it and process your refund. The money will be refunded to the original payment method you’ve used during the purchase. For credit card payments it may take 5 to 10 business days for a refund to show up on your credit card statement.<br>
If the product is damaged in any way, or you have initiated the return after 30 calendar days have passed, you will not be eligible for a refund. <br>
If anything is unclear or you have more questions feel free to contact our customer support team. <br>










<p style="text-align: left; padding-left: 30px;"><br><strong>Contact Details:</strong></p>
<p style="text-align: left; padding-left: 30px;"><span style="white-space:pre-wrap;"><span id="span_id_contact_details" class="encours"><span class="variable_vide">________</span></span></span></p>
					</div>

	
			</div>  
    	</div>	
    </div><!--/#contact-page-->';
	
	

$content = new Content($html);





$layout = new Layout($Head,$content);

echo $layout->Build();

	