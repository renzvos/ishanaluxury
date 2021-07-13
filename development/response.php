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




$anal = new AnalyticsClient("PaymentFinish");




$wid = new Widgets();
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




$Sidebar = new SideBar($SidebarC);
$slider = new Slider();


if ($_POST["status"] == "success") {
		
		
		$html = '
<div style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;width: 60%;overflow: auto;margin:auto;margin-bottom:30px">
<div class="container" style="padding: 2px 16px;background: #5cb85c;color: white;width: 100%;">
    <h4><b>We got your Order!</b></h4> 
    <p>Your cash has been transferred safely</p> 
  </div>';
  
	if (isset($_POST) && count($_POST)>0 )
	{ 
		 $html = $html.' 
  <center><img src="images\shop\ship.jpg" alt="Avatar" style="width:40%;margin-top:30px;"><br><br><br>
  '.$_POST['msg'].' <br>
 Your Order Number is : <b>'.$_POST['order_id'].'</b> <br> Your Order Date is : <b>'.$_POST['txndate'].'</b> <br>
  </center>';
	}
  
  $html = $html.' 
<a class="btn btn-default get pull-right" style="padding: 20px;margin: 20px;" value="Proceed to Checkout" href="orders.php?google='.$_POST['token'].'">View All Orders</a>
</div>
';
		
	}
	else if ($_POST["status"] == "fail") {
	

	
		$html = ' 
	<div style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;width: 60%;overflow: auto;margin:auto;margin-bottom:30px">
<div class="container" style="padding: 2px 16px;background: #ff0000;color: white;width: 100%;">
    <h4><b>'.$_POST['respmsg'].'</b></h4> 
    <p>Your cash will be back shortly</p> 
  </div>
   <center><img src="images\shop\failure.jpg" alt="Avatar" style="width:50%;margin-top:30px;"><br><br><br>
    '.$_POST['msg'].' <br>
   Your Order Number is : <b>'.$_POST['order_id'].'</b> <br> Your Order Date is : <b>'.$_POST['txndate'].'</b> <br>
 </center>
 <a class="btn btn-default get pull-right" style="padding: 20px;margin: 20px;" value="Proceed to Checkout" href="orders.php?google='.$_POST['token'].'">View All Orders</a>
  
</div>
   ';
   
		/*
			foreach($_POST as $paramName => $paramValue) {
				echo "<br/>" . $paramName . " = " . $paramValue;
			}
			*/
	}


	

else if ($_POST["status"] == "hack"){
	$html = ' 
	<div style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;width: 60%;overflow: auto;margin:auto;margin-bottom:30px">
<div class="container" style="padding: 2px 16px;background: #ff0000;color: white;width: 100%;">
    <h4><b>Bro, You tryna Hack?</b></h4> 
    <p></p> 
  </div>
    <a class="btn btn-default get pull-right" style="padding: 20px;margin: 20px;" value="Proceed to Checkout" href="orders.php?google=">View All Orders</a>
</div>
   ';
   
}



$content = new Content($html);





$layout = new Layout($Head,$content);
echo $layout->Build();


?>