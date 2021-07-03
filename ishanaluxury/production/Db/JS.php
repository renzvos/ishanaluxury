<?php
class JS{

public $selfapiurl;

function __construct()
{
	$prod = new Production();
	$this->selfapiurl = $prod->selfapi;
}

function LoadingJS()
{

}

function EndingJS()
{
// Modal Design
$result = file_get_contents("webapp/Modal-JS.php");

//Custom Codes
$result = $result.'<script src="webapp/onload.js"></script>';

	if(isset($_SESSION["email"]))
	{	
		$result = $result.'<script>var email = "'.$_SESSION["email"].'";var selfapi = "'.$this->selfapiurl.'";</script>';
		$result = $result.'<script src="webapp/onload-sign-in.js"></script>';
	}


return $result;
}





}


?>