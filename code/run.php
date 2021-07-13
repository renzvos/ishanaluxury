<?php 


class CartControl{
	public $products;

	function __construct()
	{$this->products = new Products();}
	
	
	function CreateCart($email){
		$ser = new backed();
	$coulmn = '`userid`,`email`, `cart_items`,`delivery`,`finalamount` ';
	$values = "'0','".$email."','[]',0.0,'0.0'";
	$ser->Insert("cart",$coulmn,$values);
	return 1;}
		
	function GetCart($email)
	{
		$Db = new DBController();
        $result = $Db->runQuery("SELECT * FROM cart WHERE `email` = ?", "s", array($email));
		if(is_null($result)){return null;}
		$fresult['cart_items'] = json_decode($result[0]['cart_items']);
		$fresult['finalamount'] = $result[0]['finalamount'];
		$fresult['delivery'] = $result[0]['delivery'];
		$json = json_encode($fresult);
		
		
		
		
		return $fresult;
	}
	
	
	function AddtoCart($email,$productid,$quantity)
	{
		$cart = $this->GetCart($email);
		$items = $cart['cart_items'];
		
		
		$product['id'] = $productid;
		$product['quantity'] = $quantity;
		
		
		$items[] = $product;
		$itemstring = json_encode($items);
		

		
		
		$Db = new DBController();
		$query = "UPDATE `cart` SET `cart_items` = ? WHERE `email` = ?";
   		$result = $Db->update($query,"ss", array($itemstring,$email));
		
	//	$users = new Users();
	//	$details = $users->UserDetails($userid);
	//	$location  = json_decode($details['location']);
	//	$distance =  $location->distance;
		$this->EstimateTotal($email,0);
		

		 return $this->GetCart($email) ;
		
		
		
		
	}
	
	function RemoveFromCart($email,$delid)
	{	$cart = $this->GetCart($email);
		$items = $cart['cart_items'];
		$counter = 0;
	foreach($items as $key => $value) {
		$counter = $counter + 1;
        if($counter != $delid) {
                $result[] = $value;
        }
		
		
		
		
	}
	
	$itemstring = json_encode($result);
	
	
	$Db = new DBController();
	$query = "UPDATE `cart` SET `cart_items` = ? WHERE `email` = ?";
   	$result = $Db->update($query,"ss", array($itemstring,$email));
	
	
//   	$users = new Users();
//	$details = $users->UserDetails($userid);
//	$location  = json_decode($details['location']);
//	$distance =  $location->distance;
	$this->EstimateTotal($email,0);
	 return $this->GetCart($email) ;
		
		
	}
	
	function ChangeQuantity($email,$delid,$add)
	{
		$cart = $this->GetCart($email);
		$items = $cart['cart_items'];
		$counter = 0;
		
		foreach($items as $key => $value) {
		$counter = $counter + 1;
        if($counter == $delid) {
             
			 $quantity = $value->quantity; 
			 $newquantity = $quantity + $add;
			 $value->quantity =  $newquantity;
			 $result[] = $value;
        
		}else{
		  $result[] = $value;}
		}
		
		$itemstring = json_encode($result);
	
	
	$Db = new DBController();
	$query = "UPDATE `cart` SET `cart_items` = ? WHERE `email` = ?";
   	$result = $Db->update($query,"ss", array($itemstring,$email));
	

	//$users = new Users();
	//$details = $users->UserDetails($userid);
	//$location  = json_decode($details['location']);
	//$distance =  $location->distance;
	$this->EstimateTotal($email,0);
	return $this->GetCart($email) ;
		
	}
	
	function EstimateTotal($email,$distance)
	{
		
		$cart = $this->GetCart($email);
		$items = $cart['cart_items'];
		$final_amount = 0.0;
		foreach($items as $key => $value) {
			
			$single_price = $this->products->GetPrice($value->id);
			$price = $single_price * $value->quantity;
			$final_amount = $final_amount + $price;
		
		}
		
		//$pref = new FrontPage();
		$fixedcharge = 0 ;//$pref->FixedRate();
		$kmcharge = 0 ;//$pref->KmRate();


		$delivery = $fixedcharge + $distance * $kmcharge;

		$final_amount = $final_amount + $delivery;
		
		$this->UpdatePrice($email,$final_amount,$delivery);
		
		
		return $final_amount;
		
	}
	
	
	function UpdatePrice($email,$finalprice,$delivery)
	{
			$Db = new DBController();
		$query = "UPDATE `cart` SET `finalamount` = ?,`delivery` = ? WHERE `email` = ?";
   		$result = $Db->update($query,"iis", array($finalprice,$delivery,$email));

		 
	}
	
	
	
	
	
	
	
	
	



}


?>