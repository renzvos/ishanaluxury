<?php 
class SideBar{
	
	public $title;
	public $color;
	public $finalhtml;
	public $rowd;
	
	function __construct($title,$color,$imagelink,$rows) {
    $this->title = $title;
	$this->color = $color;
	$this->imagelink = $imagelink;
	$this->rowd = $rows;
  	}
	
	
	
	function Rows($rows)
	{	$result = "";
	
	
	foreach($rows as $row)
	{	
		
		$result = $result.'<li class="nav-item ';
		
		 if($row[0] == 1){$result = $result."active";}
		
		$result = $result.'"><a class="nav-link" href="';
		
		$result = $result.$row[1];
		
		$result = $result.'"> <i class="material-icons">';
		
		$result = $result.$row[2];
		
		$result = $result.'</i><p>';
		
		$result = $result.$row[3];
		
		$result = $result.' </p> </a> </li>';
		
		}
		
		
	return $result;
	}
	
	
	
	function Build()
	{
	return $this->Begining().$this->Rows($this->rowd).$this->End();
	
	}
	
	
	function Begining(){return '
	<div class="sidebar" data-color="'.$this->color.'" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
<div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
          '.$this->title.'
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
		
		';}
	
	function End(){return '</ul>
      </div>
    </div>';}
	
	
}

?>

