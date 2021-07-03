<?php 
class SideBar{
	
	public $list;
	
	function __construct($list) {
    $this->list = $list;
  	}
	
	
	
	function Rows($list)
	{	$result = "";
	
	
	for($i = 0;$i < count($list) ; $i++)
	{	$result = $result.'<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#'.$i.'">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											'.$list[$i][0].'
										</a>
									</h4>
								</div>
								<div id="'.$i.'" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>';
	
		foreach($list[$i][1] as $row)
		{
			
			$result = $result.'<li><a href="'.$row[1].'">'.$row[0].'</a></li>';
			
		}
		
		$result = $result.'</ul>
									</div>
								</div>
							</div>';
		
		
	}
		
		
	return $result;
	}
	
	
	
	function Build()
	{
	//return ;
	
	return '<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
						
						'.$this->Rows($this->list).'</div><!--/category-products-->
						
						<div class="shipping text-center"><!--shipping-->
							<img src="images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
						
							</div>
				</div>
						';
	
	}
	
	
	
	
	
	
}

?>

