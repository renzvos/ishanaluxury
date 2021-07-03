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
require "Db/Payments.php";
require "Db/Values.php";
require "Db/StorageControl.php";
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("Checkout");

$cc = new CartControl();
$prod = new Products();
$payer = new Payments();
$val = new Values();




// Checking for google login

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

//Create cart if authenticated

if(isset($_SESSION["authenticated"]))
{
if(is_null($cc->GetCart($_SESSION["email"])))
{$cc->CreateCart($_SESSION["email"]);}
else
{}
}


// Checking if buy now or cart buy

if(isset($_GET["product"]))
{
	
	$pd = $prod->GetProductbyID($_GET["product"]);
	$pd['quantity'] = 1;
	$products = array($pd);
	$bag = '[{"id":"'.$_GET["product"].'","quantity":1}]'; // For Transaction Details
	$price = EstimateTotal(0,$bag,$prod); // Trans Data
	
	
}
else
{
	if(isset($_SESSION["authenticated"]))
	{
		$cart = $cc->GetCart($_SESSION["email"]);
		$carter = $cart['cart_items'];
		$products = array();
		foreach($carter as $pp)
		{
			$pd = $prod->GetProductbyID($pp->id);
			$image = 1;
			$row['final_price'] = $pd['final_price'];
			$row['quantity']  = $pp->quantity;
			$row['final'] = $row['final_price'] * $row['quantity'];
			$row['Images'] = $pd['Images'];
			array_push($products,$row);
		}
		
		$bag = json_encode($cart['cart_items']);
		$price = EstimateTotal(0,$bag,$prod);
		
	}	
	else
	{
		header('Location:404.html');
	}
	
	
	
	
}

// If billing submitted 

if(isset($_POST['paysubmit']))
{	if(isset($_SESSION["authenticated"])){
	$post['displayname'] = $_SESSION["name"];
	$post['billname'] = $_POST['billname'];
	$post['email'] = $_SESSION["email"];
	$post['firstname'] = $_POST['firstname'];
	$post['middlename'] = $_POST['middlename'];
	$post['lastname'] = $_POST['lastname'];
	$post['address1'] = $_POST['address1'];
	$post['address2'] = $_POST['address2'];
	$post['country'] = $_POST['country'];
	$post['postalcode'] = $_POST['postalcode'];
	$post['state'] = $_POST['state'];
	$post['phone'] = $_POST['phone'];
	$post['fax'] = $_POST['fax'];
	$post['promocode'] = $_POST['promocode'];
	$post['token'] = $_SESSION["token"];

	if(isset($_GET["product"]))
	{$post['buycover'] = '[{"id":"'.$_GET["product"].'","quantity":"1"}]';
	$post['amount'] = EstimateTotal(0,$bag,$prod);}
	else
	{	
		$cart = $cc->GetCart($_SESSION["email"]);
		$post['buycover'] = json_encode($cart['cart_items']);
		$post['amount'] = EstimateTotal(0,$bag,$prod);
	}
	echo
	'
	<form id="myForm" action="pay.php" method="post">';
	
    foreach ($post as $a => $b) {
        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
    }

	echo '</form>
	<script type="text/javascript">
    document.getElementById("myForm").submit();
	</script>
	
	';
	
}
else
{
	echo '<script>alert("Sign In to Checkout");</script>';
}
	
}






$wid = new Widgets();




$wid = new Widgets();


$html = "";


$html = $html.'
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="992932959857-fkhi7blmcqg577mkq2odg9kcrqjig6ci.apps.googleusercontent.com">

		
		


	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Check out</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="step-one">
				<h2 class="heading">Step 1</h2>
			</div>
			<div class="checkout-options">
				<h3>Sign In</h3>
				<p>Available Options</p>
				<table>
				<tr>
				<th><div class="g-signin2" data-onsuccess="onSignIn" style="width:130px"></div></th>
				<th>
				';
				
				if(isset($_SESSION["authenticated"]))
				{	
					$html = $html.$_SESSION["gm"];
				}
				
				$html = $html.'</th>
				</table>
				
				
			</div><!--/checkout-options-->




			<div class="step-one">
				<h2 class="heading">Step 2</h2>
			</div>

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-3">
						<div class="shopper-info">
							<p>Shopper Information</p>
							<form method="post">';
							if(isset($_SESSION["name"]))
							{$html = $html.'
								<input name="displayname" type="text" placeholder="'.$_SESSION["name"].'">';
							}
							$html = $html.'
							</form>	
							
						</div>
					</div>
					<div class="col-sm-3 clearfix">
						<div class="bill-to">
							<p>Bill To</p>
							<div class="shopper-info">
							<form method="post">
									<input name="billname" type="text" placeholder="Name">
									<input name="email" type="text" placeholder="Email*" required>
									<input name="firstname" type="text" placeholder="First Name *" required>
									<input name="middlename" type="text" placeholder="Middle Name">
									<input name="lastname" type="text" placeholder="Last Name *" required>
									<input name="address1" type="text" placeholder="Address 1 *"required>
									<input name="address2" type="text" placeholder="Address 2"required>
									<select  name="country">
										<option disabled>-- Country --</option>
										<option selected>India</option>
									</select>
									<input  name="postalcode" onchange="pincodechange()" id="pincode" type="text" placeholder="Zip / Postal Code *" required>
									<h6><div id="deldate" style="color: green;"></div></h6>
									<select  name="state" required>
									<option>Andhra Pradesh</option>	
									<option>Arunachal Pradesh</option>	
									<option>Assam</option>	
									<option>Bihar</option>	
									<option>Chattisgarph</option>	
									<option>Goa</option>	
									<option>Gujrat</option>	
									<option>Haryana</option>	
									<option>Himachal Pradesh</option>	
									<option>Jharkand</option>	
									<option>Karnataka</option>	
									<option>Kerala</option>	
									<option>Madhya Pradesh</option>	
									<option>Maharasthra</option>	
									<option>Manipur</option>	
									<option>Meghalaya</option>	
									<option>Mizoram</option>	
									<option>Nagaland</option>	
									<option>Odisha</option>	
									<option>Punjab</option>	
									<option>Rajasthan</option>	
									<option>Sikkim</option>	
									<option>Tamil Nadu</option>	
									<option>Telanhana</option>	
									<option>Uttar Pradesh</option>	
									<option>Uttarakhand</option>	
									<option>West Bengal</option>	
									<option>Andhra Pradesh</option>	
									</select>
									<input  name="phone" type="text" placeholder="Phone *" value="+91" required>
									<input  name="fax" type="text" placeholder="Fax">
								
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="order-message">
							<p>Shipping Order</p>
							<textarea name="message"  placeholder="Notes about your order, Special Notes for Delivery" rows="16"></textarea>
						</div>	
					</div>					
				</div>
			</div>
			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div> 
			<div id="cartcontent">';
			
			$html = $html.$wid->ViewCart($products,"",true).'
			</div>
			
				
					<table class="table table-condensed total-result">
									<tbody><tr>
										<td>Cart Sub Total</td>
										<td>'.($price-3).'<td>
									</tr>
									<tr>
										<td >Exo Tax</td>
										<td>3</td>
									</tr>
									<tr class="shipping-cost">
										<td>Shipping Cost</td>
										<td>Free</td>										
									</tr>
									<tr>
										<td >Total</td>
										<td><span><div class="cart_total_price">'.$price.'</div></span></td>
									</tr>
								</tbody></table>
								
		
			
				<div class="row"><input type="text" style="padding: 10px;margin: 20px;" name="promocode" placeholder="PROMOCODE" class="pull-right"></div>
				<input class="btn btn-default get pull-right" style="padding: 20px;margin: 20px;" type="submit" name="paysubmit" value="Proceed to Checkout">
				
			</form>
			
		</div>
	</section> <!--/#cart_items-->
	
	
	<script>
	
	function onSignIn(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
';

if(isset($_GET["product"]) && !isset($_SESSION["authenticated"]) && !isset($_GET["google"]) )
{$html = $html.'window.location.href = "checkout.php?product='.$_GET["product"].'&google=" + id_token;';}
else if(!isset($_SESSION["authenticated"])  && !isset($_GET["google"])  )
{$html = $html.'window.location.href = "checkout.php?google="+id_token;';}

$html = $html.'
}




function pincodechange()
{
	var pincode = document.getElementById("pincode").value;
	if(pincode.length == 6)
	{
		document.getElementById("deldate").innerHTML = "Please wait";
		const Http = new XMLHttpRequest();
		const url= "http://ishanaluxury.com/api/pincode.php?pc=" + pincode;
		Http.open("GET", url);
		Http.send();
		Http.onreadystatechange = (e) => {
		document.getElementById("deldate").innerHTML = Http.responseText;
		}
	}
}

	</script>
';


$content = new Content($html);
$layout = new Layout($val->DefaultHead(),$content);






function EstimateTotal($distance,$buy,$pc)
	{
		$items = json_decode($buy);
		$final_amount = 0.0;
		foreach($items as $key => $value) {
			
			$single_price = $pc->GetPrice($value->id);
			$price = $single_price * $value->quantity;
			$final_amount = $final_amount + $price;
		
		}
		
		//$pref = new FrontPage();
		$fixedcharge = 0 ;//$pref->FixedRate();
		$kmcharge = 0 ;//$pref->KmRate();


		$delivery = $fixedcharge + $distance * $kmcharge;

		$final_amount = $final_amount + $delivery + 3;
		
		//$this->UpdatePrice($email,$final_amount,$delivery);
		
		
		return $final_amount;
		
	}


echo $layout->Build();

?>