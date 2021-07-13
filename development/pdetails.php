<?php
session_start();
require "snippets/sidebar.php";
require "snippets/Layout.php";
require "snippets/content.php";
require "snippets/Main.php";
require "snippets/Widgets.php";
require "snippets/Head.php";
require "snippets/slider.php";

require "webapp/JS.php";
require "CommonHTML.php";

require "Apps/backend/code/run.php";
require "Apps/Product-Control/code/run.php";
require "Apps/Ecommerce-Cart-Control/code/run.php";
require "Apps/Storage-Control/code/run.php";
require "Apps/rex-client-php/code/run.php";
require "Apps/Ecommerce-Order-Control/code/run.php";




$anal = new AnalyticsClient("ProductView:".$_GET["pid"]);


$wid = new Widgets();
$OM = new Order();
$val = new Values();
$prod = new Products();
$recc = $prod->GetProductBySoldLimit(6);
$stor = new Storage();



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





if(isset($_POST['submit']))
{	$det = $prod->GetProductbyID($_GET["pid"]);
	$reviews = $det['reviews'];
	$RW = json_decode($reviews);
	if(is_null($RW))$RW = array();
	$review = new \stdClass();
	$review->Name = $_POST['Name'];
	$review->Email = $_POST['Email'];
	$review->Date =  date('d-m-Y');    
	$review->Time =  date('H:i:s');    
	$review->Data = $_POST['Content'];
	array_push($RW,$review);

	$prod->UpdateReview(json_encode($RW),$_GET["pid"]);
	
}


$det = $prod->GetProductbyID($_GET["pid"]);
$imglink = $det['Images'];
$name  = $det['product_Name'];
$price = $det['price'];
$color = $det['Color'];
$brand = $det['Brand'];
$description = json_decode($det['description']);
$details = $description->details;
$companyProfile = $description->companyProfile;
$reviews = $det['reviews'];
$RW = json_decode($reviews);
$images = json_decode($det['Images']);


$html ='';
$html = $html.'
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="992932959857-fkhi7blmcqg577mkq2odg9kcrqjig6ci.apps.googleusercontent.com">';

$html = $html.'<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3" style="display: none;">
						
				
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="'.$stor->GetUrl($images[0]).'" alt="">
								<h3></h3>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								  
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="">
								<h2>'.$name.'</h2>
								<span>
									<span>Rs '.$price.' </span>
									<label>Quantity:</label>
									<input type="text" value="1" id="q"><br>
									';
									
if(isset($_SESSION["authenticated"]))
{
	$html = $html.'
									<center><button type="button" onclick="addtoCartwithQ('.$_GET["pid"].')" class="btn btn-fefault cart" >
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button></center>';
}
else
{
	$html = $html.'<center>
									<button type="button" onclick="SignInFirst()" class="btn btn-fefault cart" >
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button></center>';
	
}

							$html = $html.'
									<center><a href="checkout.php?product='.$_GET["pid"].'" class="btn btn-fefault cart" >
										<i class="fa fa-shopping-cart"></i>
										Buy Now
									</a></center>
									
								</span>
								<p><b>Availability:</b> In Stock</p>
								<p><b>Brand:</b> '.$brand.'</p>
								<p><b>Check Availability:</b> <input onchange="pincodechange()" id="pincode" type="text" placeholder="Zip / Postal Code *" required>
									<h6><div id="deldate" style="color: green;"></div></h6>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li><a href="#details" data-toggle="tab">Details</a></li>
								<li><a href="#companyprofile" data-toggle="tab">Company Profile</a></li>
								
								<li class="active"><a href="#reviews" data-toggle="tab">Reviews ('.count($RW).')</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="details">
								
								'.$details.'
								
							</div>
							
							<div class="tab-pane fade" id="companyprofile">
								
								'.$companyProfile.'
								
							</div>
							
							
							
							<div class="tab-pane fade active in" id="reviews">
								<div class="col-sm-12">
								
								';
						if(!is_null($RW))
						foreach($RW as $review){
							
							$html = $html.'
									<ul>
										<li><a href=""><i class="fa fa-user"></i>'.$review->Name.'</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i>'.$review->Time.'</a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i>'.$review->Date.'</a></li>
									</ul>
									<p>'.$review->Data.'</p>
									
							';
						}

				$html = $html.'
							
									<p><b>Write Your Review</b></p>
									
									<form method="POST">
										<span>
											<input name="Name" type="text" placeholder="Your Name">
											<input name="Email" type="email" placeholder="Email Address">
										</span>
										<textarea name="Content"></textarea>
										<input name="submit" value="Submit "type="submit" class="btn btn-default pull-right">
								
										
									</form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">';
								
							$count = 0;
for($slides = 0 ; $slides < round(count($recc)/3); $slides++)
{	
	if($slides == 0)
	{
		$html = $html.'<div class="item active">';
	}
	else
	{
		$html = $html.'<div class="item">';
	}
	
	for($i = 0; $i<3 ;$i++)
		{$images = json_decode($recc[$count]['Images']);
			$html= $html.'
			<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="'.$stor->GetUrl($images[0]).'" alt="">
													<h2>Rs '.$recc[$count]['final_price'].'</h2>
													<p>'.$recc[$count]['product_Name'].'</p>
													<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
												</div>
											</div>
										</div>
									</div>
			';
			$count++;
		}
		
	$html  = $html.'</div>';
}

	
								
						$html = $html.'</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>
	
	<script>
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

function onSignIn(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
  window.location.href = "pdetails.php?pid='.$_GET["pid"].'&google="+id_token;
}

function addtoCartwithQ(id){
	
	q = document.getElementById("q").value;
	alert(q);
	
const Http = new XMLHttpRequest();
const url= "http://localhost/mask/api/addtoCart.php?email=phonedata6666@gmail.com&q=" + q + "&pid=" + id;
Http.open("GET", url);
Http.send();
Http.onreadystatechange = (e) => {
ModelOpen("Cart",Http.responseText,
"<button class=\"btn btn-default get pull-right\" type=\"button\" style=\"padding: 20px;margin: 20px;\"><a href = \"checkout.php\">Proceed to Checkout</a> </button>");
	}
	
	
}


	</script>
	';


$content = new Content($html);





$layout = new Layout($val->DefaultHead(),$content);

echo $layout->Build();


?>