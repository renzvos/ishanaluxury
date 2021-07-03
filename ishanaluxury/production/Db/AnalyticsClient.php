<?php
class AnalyticsClient{

	public $bid = 1;
	public $url;
	public $geolocationapi;


	function __construct($pagename)
	{
		$prod = new Production();
		$this->url = $prod->analyticsapi;
		$this->geolocationapi = $prod->geolocationapi;


		if(!isset($_SESSION['sesid']))
		{
			try
			{
			$sesid = $this->NewVisit() + 0;
			$_SESSION['sesid'] = $sesid;
			$this->PageClick($pagename,$_SESSION['sesid']);
			$this->ClientSideCode();
			}
			catch(Exception $e)
			{echo "Error";}
		}
		
	}
	
	function NewVisit()
	{
		
	$device =  $this->GetDeviceFromHeaders();
	$stream;
	if(isset($_GET["s"]))
	{
		switch($_GET["s"])
		{
			case 'i':
			$stream = 'Instagram';
			break;
			case 'f':
			$stream = 'Facebook';
			break;
			case 'g':
			$stream = 'Instagram';
			break;
			case 'a':
			$stream = 'Affiliates';
			break;
			default:
			$stream = $_GET["s"];
		}
	}
	else
	{
		$stream = "Website";
	}

	$api = new CallAPI();
	
	$poster['bid'] = $this->bid;
	$poster['ip'] = "";
	$poster['device'] = $device;
	$poster['stream'] = $stream;
	
	
	return $api->CallPostAPI($this->url."new.php",$poster);;

	}
	
	function Login($id,$email)
	{
	$api = new CallAPI();
	$poster['id'] = $id;
	$poster['email'] = $email;
	$api->CallPostAPI($this->url."login.php",$poster);

	}
	
	
	function PageClick($page,$id)
	{
	
	$api = new CallAPI();
	$poster['page'] = $page;
	$poster['id'] = $id;
	$api->CallPostAPI($this->url."pageclick.php",$poster);
	
	}
	
	
	
	function GetDeviceFromHeaders()
	{
		$headers=array();
		foreach (getallheaders() as $name => $value) {
		$headers[$name] = $value;
		}
		
		return $headers['User-Agent'];
	}
	
	
	function Putlocation($json,$id)
	{
	
	$api = new CallAPI();
	$poster['json'] = $json;
	$poster['id'] = $id;
	$api->CallPostAPI($this->url."putlocation.php",$poster);

	}


	function ClientSideCode()
	{
		echo '

<script>

var myVar = setInterval(call, 7000);					

function call() {
	
	var path = window.location.pathname;
var page = path.split("/").pop();
const Http = new XMLHttpRequest();
const url= "'.$this->url.'hold.php?id='.$_SESSION["sesid"].'&page=" + "-" + page;
Http.open("GET", url);
Http.send();
Http.onreadystatechange = (e) => {

console.log(Http.responseText);

}
}

</script>

		';


if(!isset($_SESSION['locationtrack'])){
		
 echo '<script>
ltrack();


function ltrack()
{

	const Http = new XMLHttpRequest();
	const url= "'.$this->geolocationapi.'";
	Http.open("GET", url);
	Http.send();
	Http.onreadystatechange = (e) => {

	console.log(Http.responseText);
	POSTLct(Http.responseText);


	}
}


function POSTLct(json)
{
	const Http = new XMLHttpRequest();
const url= "'.$this->url.'putlocation.php?id='.$_SESSION["sesid"].'&json=" + json;
Http.open("GET", url);
Http.send();
Http.onreadystatechange = (e) => {

console.log(Http.responseText);

}
}

</script>
		';
		$_SESSION["locationtrack"]  = true;

		
}
	}
	



	
	
	
	
	
	
}


?>