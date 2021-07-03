<?php
class Head{
	public $phoneno;
	public $email;
	public $facebooklink;
	public $twitterlink;
	public $Instagramlink;
	public $linkdinlink;

	public $titlecontents;
	
	
	function __construct($phoneno,$email,$facebooklink,$twitterlink,$instagram,$linkdinlink,$titlecontents) {
	$this->phoneno = $phoneno;
	$this->email = $email;
	$this->facebooklink = $facebooklink;
	$this->twitterlink = $twitterlink;
	$this->Instagramlink =$instagram;
	$this->linkdinlink = $linkdinlink;
    $this->titlecontents = $titlecontents;
	}
	
	function Build()
	{
		$result =  '
		
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								'.$this->Phone().$this->Email().'
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								'.$this->Facebook().$this->Twitter().$this->Instagram().$this->Linkedin().'
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/home/logo.png" style="width:100%" alt="" /></a>
						</div>
						
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								'.$this->Rows($this->titlecontents).'
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							
						</div>
						
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Search" id="search"/>  <a onclick="Search();">  <i class="fa fa-search" style="background: #ababff;padding: 9px;"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	
	

		';
		
	
	$result = $result.'
			<script>	//TODO : preload JS </script>
				';
			
				
		
		
		return $result;
	}
	
	function Phone()
	{
		if($this->phoneno == '')
		{return '';}
		else
		{return '<li><a href="#"><i class="fa fa-phone"></i>'.$this->phoneno.'</a></li>';}
		
	}
	
	function Email()
	{
		if($this->email == "")
		{return "";}
		else
		{return '<li><a href="mailto:'.$this->email.'"><i class="fa fa-envelope"></i> '.$this->email.'</a></li>';}
		
	}
	
	function Facebook()
	{
		if($this->facebooklink == "")
		{return "";}
		else
		{return '<li><a href="'.$this->facebooklink.'"><i class="fa fa-facebook"></i></a></li>';}
		
	}
	
	function Twitter()
	{
		if($this->twitterlink == "")
		{return "";}
		else
		{return '<li><a href="'.$this->twitterlink.'"><i class="fa fa-twitter"></i></a></li>';}
		
	}
	
	function Linkedin()
	{
		if($this->linkdinlink == "")
		{return "";}
		else
		{return '<li><a href="'.$this->linkdinlink.'"><i class="fa fa-linkedin"></i></a></li>';}
		
	}
	
	function Instagram()
	{
		if($this->Instagramlink == "")
		{return "";}
		else
		{return '<li><a href="'.$this->Instagramlink.'"><i class="fa fa-instagram"></i></a></li>';}
		
	}
	
	function Rows($rows)
	{	$result = "";
	
	
	foreach($rows as $row)
	{	
		$result = $result.'<li><a ';
		
		if($row[3] == true){$result = $result.'class="active"';}
		
		$result = $result.$row[0].'>'.$row[1].$row[2].'</a></li>';
		
		}
		
		
	return $result;
	}
	
	
	
}

?>