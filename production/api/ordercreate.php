<?php
require "../Db/DeliveryOrderManagement.php";
require "../Db/ProductsControl.php";
require "../Db/backed.php";


$pc = new Products();
$OM = new Order();
$inputs;

$orderid = $_POST['order_id'];
$secretkey = $_POST['key'];
$data = $_POST['data'];



$newkey = md5($orderid."arshadabcd");
if($newkey == $secretkey){

$declass = json_decode($data);
$profile = $declass->profile;
$items = $declass->cart;
$email = $profile->email;
$Displayname = $profile->displayname;
$Billname = $profile->billname;
$Billemail = $profile->billemail;
$Firstname = $profile->firstname;
$Middlename = $profile->middlename;
$Lastname = $profile->lastname;
$Address1 = $profile->address1;
$Address2 = $profile->address2;
$Address3 = "";
$Country = $profile->country;
$Postalcode = $profile->postalcode;
$State = $profile->state;
$Phone = $profile->phone;
$Fax = $profile->fax;
$Promocode = $profile->promocode;
$token = $profile->token;



$ids = array();

foreach($items as $key => $value)
{	
	for ($i = 0;$i < $value->quantity ; $i++){
		
		$id = $OM->PlaceOrder(
					$orderid,
					$email,
					$value->id,
					$pc->GetPrice($value->id),
					"Ordered",
					"iplocation",
					$Displayname,
					$Billname,
					$Billemail,
					$Firstname,
					$Middlename,
					$Lastname,
					$Address1,
					$Address2,
					$Address3,
					$Country,
					$Postalcode,
					$State,
					$Phone,
					$Fax,
					0,
					$Promocode);
		array_push($ids,$id);
	
	}
}
$flag = true;

if($flag == true)
{
	echo count($ids)." order(s) has been placed";
}







}
else
{
	echo "Not Verfied";
}











	
?>