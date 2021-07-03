<?php
class Values{
	
	function DefaultHead()
	{
		$HeadC = array();
		array_push($HeadC,array('href="index.php"','<i class="fa fa-home"></i>',"Home",true));
		if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="orders.php"','<i class="fa fa-list"></i>',"Orders",false));}
		else{array_push($HeadC,array('  onclick="SignInFirst()"','<i class="fa fa-list-alt"></i>',"Orders",false));}
		if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="checkout.php"','<i class="fa fa-credit-card"></i>',"Checkout",false));}
		if(isset($_SESSION["authenticated"])){array_push($HeadC,array('onclick="ViewCart()"','<i class="fa fa-shopping-cart"></i>','Cart</a>',false));}
		if(!isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"','<div class="g-signin2" data-onsuccess="onSignIn" style="width:130px"></div>',"",false));}
		if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"',$_SESSION["gm"],"",false));}
		$Head = new Head('00919567998665',"customercare@ishanaluxury.com","https://www.facebook.com/ishanaluxury","twitter.com","https://www.instagram.com/ishanaluxury","lkd.com",$HeadC);
		
		return $Head;
	}




	
	
	function DefaultSidebar()
	{
		
		$row1 = array('What Color is your outfit?',array(
		array("Red","shop.php?color=Red"),
		array("Blue","shop.php?color=Blue"),
		array("Green","shop.php?color=Green"),
		array("Grey","shop.php?color=Grey"),
		));
		$row2 = array('Sex',array(array("Male","shop.php?sex=M"),array("Female","shop.php?sex=F")));
		$row3 = array('Brand',array(array("LinenClub","shop.php?brand=LC"),array("Raymond","shop.php?brand=Raymond")));

		$SidebarC = array($row1,$row2,$row3);


		return $SidebarC;
	}
	
	
	function GoogleSignInit()
	{
		return '<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="992932959857-fkhi7blmcqg577mkq2odg9kcrqjig6ci.apps.googleusercontent.com">';
		
	}
	
	
	
}


