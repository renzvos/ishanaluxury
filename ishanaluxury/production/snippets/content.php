<?php
class Content
{	
	 public $html;
	
	function __construct($html) {
  
   $this->html = $html;
  	}
	
	
	
	function Main(){
		return $this->html;
		}
	
	
	function Footer(){}
	
	
	function Build(){
		
		return $this->Begining().$this->Main().$this->End();
		
		}
		
	function Begining(){return '';}
	
	function End(){return '';}
	
	
	
	
	
	
	
	
	
}


?>