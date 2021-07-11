<?php

class Production {
	public $prod = false;
	public $host;
	public $user;
	public $password;
	public $database;
	public $selfapi;
	public $analyticsapi;
	public $geolocationapi;
	public $paymentsapi;
	public $backupapi;


function __construct()
{
	
	if($this->prod == true)
	{
		$this->host = "localhost";
		$this->user = "admin";
		$this->password = "arshad956";
		$this->database = "ishanaluxury";
		$this->selfapi = "https://www.ishanaluxury.com/api/";
		$this->analyticsapi = "http://vacuolar-load.000webhostapp.com/api/";
		$this->geolocationapi = "https://geolocation-db.com/json/";
		$this->paymentsapi = "https://payments.renzvos.com";
		$this->backupapi = "http://10.128.0.10/api/";

	}
	else
	{
		$this->host = "localhost";
		$this->user = "root";
		$this->password = "";
		$this->database = "mask";
		$this->selfapi = "http://localhost/mask/api/";
		$this->analyticsapi = "http://localhost/analytics/api/";
		$this->geolocationapi = "https://geolocation-db.com/json/";
		$this->paymentsapi = "http://localhost/payments/index.php";
		$this->backupapi = "http://localhost/backup/api/";

	}

}

}


?>