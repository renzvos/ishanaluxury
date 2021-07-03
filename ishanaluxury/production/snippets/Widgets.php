<?php
class Widgets{
	
	function CreateTable($title,$subtitle,$header,$rows,$links){
		$result =  '
	  <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">'.$title.'</h4>
                  <p class="card-category"> '.$subtitle.'</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">';
		
		foreach($header as $cell)
		{
			$result = $result.' <th>'.$cell.'</th>';
		}
		
		$result = $result.'  </thead><tbody>';
		$rowcounter = 0;
		foreach($rows as $row)
		{	$rowcounter = $rowcounter + 1; 
			$result = $result.'<tr>';
			foreach($row as $cell)
			{	
				$result = $result.' <td><a href="'.$links[$rowcounter - 1].'" style="color:#000;">'.$cell.'</a></td>';
			}
			$result = $result.'<tr>';

		}
		
		$result = $result.'</tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>';
	
                     
		return $result;
		
		}
	
	
	
	
	function CreateInvoice($c_name,$Mobile,$loc,$orderTime,$deliveryTime,$status,$itemrows,$finalbill,$delivery)
	{
		$result =  '
	  <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h2 class="card-title ">Invoice</h2>
                  <p class="card-category"> 02-Jan-2020</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">';
				  
				  
	   $result = $result.'<table style="width:85%">
	   		<tr><td>Customer Name</td><td>Arshad Nazir</td>		<td>Ordered Time</td><td>12-23-23,234</td></tr>
			<tr><td>Mobile Number</td><td>9526669445</td>		<td>Delivered Time</td><td>12-23-23,234</td></tr>
			<tr><td>Delivery Location</td><td>Thazhava</td>	<td>Order Status</td><td>Completed</td></tr>
			<tr><td></td>	<td>Mukku</td>		<td></td><td></td></tr>
			
			
			</table>';
			
		
		 $result = $result.' <table class="table">
                      <thead class=" text-primary">';
		
		
			$result = $result.' <th>Sr No</th><th>Name</th><th>Quantity</th><th>Rate</th><th>Total Rate</th>';
		
		
		$result = $result.'  </thead><tbody>';
		
		foreach($itemrows as $row)
		{	$result = $result.'<tr>';
			foreach($row as $cell)
			{
				$result = $result.' <td>'.$cell.'</td>';
			}
			$result = $result.'<tr>';

		}
		
		$result = $result.'</tbody>
                    </table>
					<div class="row" style="width: 96%;">
					<div class="col-md-12">
					<h4 class="pull-right">Delivery Charge:  Rs '.$delivery.'/-</h4>
					</div>
					<div class="col-md-12 ">
					<h1 class="pull-right">Total : Rs '.$finalbill.'/-</h1>
					</div>
					</div>
					';
		
				  
				  
		$result = $result.'
		
                  </div>
                </div>
              </div>
            </div>';
				  
				  
		
				 return $result;
				  
	}
	
	function Featured($products,$heading){
		$stor = new Storage();
		$result = '<div class="features_items"><!--features_items-->
						<h2 class="title text-center">'.$heading.'</h2>';
		$count = 0;
		foreach($products as $product)
		{	if($count==0){$result = $result.'<div class="row">';}
			$images = json_decode($product['Images']);
			$result = $result.'<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src="'.$stor->GetUrl($images[0]).'" alt="" />
											<h5><strike>Rs '.$product['price'].'</strike></h5><h2>Rs '.$product['final_price'].'</h2>
											<p><b>'.$product['product_Name'].'</b></p>
											<a href="checkout.php?product='.$product['id'].'" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Instant Buy</a>
											';
											if(!isset($_SESSION["authenticated"])){ $result = $result.'<a id="cart" onclick="SignInFirst()" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add</a>';}
										else {$result = $result.'<a id="cart" onclick="AddtoCart()" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add</a>';}
										
										$result = $result.'
										
										</div>
										<div class="product-overlay"><a href="pdetails.php?pid='.$product['id'].'">
											<div class="overlay-content">
												<img src="'.$stor->GetUrl($images[1]).'" style = "width:100%"alt="" />
												<h5><strike style="color: wheat;">Rs '.$product['price'].'</strike></h5><h2>Rs '.$product['final_price'].'</h2>
												<p><b>'.$product['product_Name'].'</b></p>
												
												<a href="checkout.php?product='.$product['id'].'" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Instant Buy</a>';
										
										if(!isset($_SESSION["authenticated"])){ $result = $result.'<a id="cart" onclick="SignInFirst()" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add</a>';}
										else {$result = $result.'<a id="cart" onclick="AddtoCart('.$product['id'].',1)" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add</a>';}
										
										$result = $result.'
										</div></a>
										</div>
								</div>
								
							</div>
						</div>
						
						
						
						';
			$count = $count + 1;
			if($count%3 == 0){$result = $result.'</div>';$count = 0;}
		}
	
		$result = $result.'</div>
						<script>
						
						
					
						
						</script>';
		
		
		
		return $result;
		
	}
	
	

	
	
	
	
	
	
	function ViewProduct($id,$name,$imagelinks,$oldprice,$newprice,$desc)
	{
	$imagearray = json_decode($imagelinks);
	$str = new Storage();
	$url = $str->GetUrl($imagearray[0]);
	
		$result = '  
		<div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Product</h4>
                  <p class="card-category">Product Details</p>
                </div>
                <div class="card-body">
                  <form>
				  	<div class="row">
					
					</div>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                        <h5>Product Name : '.$name.'</h5> 
                        </div>
                      </div>
                      
                      
                    </div>
                  
                  
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                           <h5>Price : '.$oldprice.'</h5> 
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <h5>New Price : '.$newprice.'</h5> 
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Desciption</label>
                          <div class="form-group">
                          
                         <h5>'.$desc.'</h5> 
                          </div>
                        </div>
                      </div>
                    </div>
                    <a href="EditProduct.php?id='.$id.'" class="btn btn-primary pull-right">Edit Product</a>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
			
			<div class="col-md-4">
              <div class="card card-profile">
                <div>
                  <a href="javascript:;">
                    <img  style="width:75%;" class="img" src="../../'.$url.'" />
                  </a>
                </div>
                <div class="card-body" style="text-align:left;">
                  <h6 class="card-category text-gray">Category</h6>
                  <h4 class="card-title"><b>'.$name.'</b></h4><br>
				  <h7><s>'.$oldprice.'</s></h4><br>
				  <h4>'.$newprice.'</h4><br>
                  <p class="card-description">
        			'.$desc.'
                  </p>
                  <a href="" class="btn btn-danger btn-round">Add to Cart</a>
                </div>
              </div>
            </div>
			
			';
	
	return $result;}
	
	
	
	function ViewCart($products,$email,$checkout)
	{$stor = new Storage();
		$result = '<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead><tbody>';
		for($i = 0;$i < count($products); $i++)
		{	$images = json_decode($products[$i]['Images']);
			$result = $result.'<tr>
							<td class="cart_product">
								<a href=""><img src="'.$stor->GetUrl($images[0]).'" alt="" style="width: 30%;max-width: 150px;"></a>
							</td>
							
							
							<td class="cart_price">
								<p>'.$products[$i]['final_price'].'</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">';
									if($checkout){
										$result = $result.'
									<p>'.$products[$i]['quantity'].'</p>
									';}
								else{
									$result = $result.'
									<a class="cart_quantity_up" onclick="ChangeQuantity(\''.$email.'\','.($i+1).',1)"> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="'.$products[$i]['quantity'].'" autocomplete="off" size="2">
									<a class="cart_quantity_down"  onclick="ChangeQuantity(\''.$email.'\','.($i+1).',-1)"> - </a>
								';}
								$result = $result.'
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">'.$products[$i]['final_price'] * $products[$i]['quantity'].'</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" onclick="RemoveCart(\''.$email.'\','.($i+1).')"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						
						
						';
		}
		
		$result = $result.'
		</div>
			</tbody>
				</table>
		
				
		';
		
		return $result;
	}
	
	function OrdersList($orders)
	{	$stor = new Storage();
		$result = '
		<div class="response-area">
						<h2>YOUR ORDERS</h2>
						<ul class="media-list">';
							$count = 0;
							foreach($orders as $order){
							$images = json_decode($order['Images']);
							$result = $result.'
							<li class="media">
								<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
								<a class="pull-left" href="#">
									<img class="media-object" src="'.$stor->GetUrl($images[0]).'" style="width: 150px;">
								</a>
								<div class="media-body">
									<ul class="sinlge-post-meta">
										<li><i class="fa fa-user"></i>'.$order['productname'].'</li>
										<li><i class="fa fa-clock-o"></i> Rs '.$order['price'].'</li>
										<li><i class="fa fa-calendar"></i>'.$order['date'].'</li>
									</ul>
									<p>'.$order['message'].'</p>
									 <div class="w3-light-grey w3-round-large">
										<div class="w3-container w3-green w3-center" style="width:'.$order['percentage'].'%">'.$order['percentage'].'%</div>
									</div><br>
								<form method="post">';	
								if($order['Refundable']){
								$result = $result.'
								<input name="refund'.$order['id'].'" type="submit" style ="height: 30px;background:red;margin-top: 5px;" class="btn btn-primary" value="CANCEL ORDER AND INITIATE REFUND">    </input>
								';
								}
								$result = $result.'
								</form>
								</div>
							</li>';
							$count++;
							}
							
		$result =  $result.'
						</ul>					
					</div>
		';
		
		return $result;
	}
	
	
	
	
	



	
}
?>