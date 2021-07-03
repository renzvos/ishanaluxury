<?php
class Location{
	public $api;
	
	function __construct()
	{$this->api = new CallAPI();}
	
	
	function FindIPLocation()
	{}
	
	
	
	
	function DatefromPincode($pincode)
	{	
		$address = $this->PostofficeIndia($pincode);
		$distance = $this->ReverseGecode($address);
		return $distance;
	}
	
	
	function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'kilometers') {
	$theta = $longitude1 - $longitude2; 
	$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
	$distance = acos($distance); 
	$distance = rad2deg($distance); 
	$distance = $distance * 60 * 1.1515; 
	switch($unit) { 
		case 'miles': 
		break; 
		case 'kilometers' : 
		$distance = $distance * 1.609344; 
	} 
	return (round($distance,2)); 
	}
	
	
	function PostofficeIndia($pincode)
	{
		$result = $this->api->CallSimpleAPI("https://api.postalpincode.in/pincode/".$pincode);
		$js = json_decode($result);
		$state = $js[0]->PostOffice[0]->State;
		$district = $js[0]->PostOffice[0]->District;
		$name = $js[0]->PostOffice[0]->Name;
		$address = 'India,'.$state.','.$district.','.$name.','.$pincode;
		//echo $address;
		return $address;
	}
	
	function ReverseGecode($address)
	{	
		$urladd = str_replace(" ",",",$address);
		$result = $this->api->CallSimpleAPI("http://www.mapquestapi.com/geocoding/v1/address?key=wZCpcLrnxxx7kKwaA6wbOhCiv4s0AndE&location=".$urladd);
		$js = json_decode($result);
		//print_r($js->results[0]->locations[0]);
		$lat = $js->results[0]->locations[0]->latLng->lat;
		$lng = $js->results[0]->locations[0]->latLng->lng;
		$distance = $this->getDistanceBetweenPointsNew($lat, $lng, 9.03171, 76.542 , 'kilometers');
		//echo $distance;
		return $this->DeliveryDate($distance);
		
	}
	
	function DeliveryDate($distance)
	{
		if($distance < 10)
		{ 
			return 'Will be delivered within '.date('d-m-Y', strtotime(' +1 day'));
			
		}
		else if($distance < 250)
		{
			return 'Will be delivered within '.date('d-m-Y', strtotime(' +3 day'));
		}
		else
		{
			return 'Will be delivered within '.date('d-m-Y', strtotime(' +6 day'));
		}
	}
	
	
}


?>