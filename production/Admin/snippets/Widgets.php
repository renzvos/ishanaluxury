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
	
	

	
	
	
	
	
	function EditProduct($name,$oldprice,$newprice,$desc,$cato,$stock,$imagelinks)
	{$id = $_GET['id'];
	$cat = new Categories();
	$imagearray = json_decode($imagelinks);
	$str = new Storage();
	$url = $str->GetUrl($imagearray[0]);
	
		$result = '  <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Product</h4>
                  <p class="card-category">Complete your product details</p>
                </div>
                <div class="card-body">
                  <form method="post" enctype="multipart/form-data">
				  	<div class="row">
						<div class="col-md-12">
                      		 
							  <label class="btn btn-primary">
							  FRONT IMAGE
							  <input style="display: none;" type="file" name="frontimage" accept="image/*" id="fileToUpload">
							  </label>
							  
							   <label class="btn btn-primary">
							  SIDE IMAGE
							  <input style="display: none;" type="file" name="leftimage" accept="image/*">
							  </label>
							  
							   <label class="btn btn-primary">
							  SIDE IMAGE
							  <input style="display: none;" type="file" name="rightimage" accept="image/*">
							  </label>
							  
							   <label class="btn btn-primary">
							  REAR IMAGE
							  <input style="display: none;" type="file" name="rearimage" accept="image/*">
							  </label>
							  
                        </div>
					</div>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Product Name</label>
                          <input type="text" name="pname" class="form-control" value="'.$name.'" >
                        </div>
                      </div>
                      
                      
                    </div>
                  
                  
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Old Price</label>
                          <input type="text" name="oldprice" class="form-control" value="'.$oldprice.'">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">New Price</label>
                          <input type="text" name="newprice" class="form-control" value="'.$newprice.'">
                        </div>
                      </div>
                     
                    </div>
					 <select name = "cater" class="form-control">';
					 foreach($cat->GetAlllist($cato) as $option)
{
	$result= $result.$option;
}
					$result = $result. '</select>
					
					<input type="checkbox" id="avl" name="aval" value="Out" style="padding-top:10px;" ';
					
					if($stock == false){$result = $result."checked";}
					
					$result = $result.'>
					<label for="avl"> Out of Stock </label><br>
					
					  <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Desciption</label>
                          <div class="form-group">
                            <label class="bmd-label-floating"> </label>
                            <textarea class="form-control" name="desc" rows="5">'.$desc.'</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right" name="editproduct">Update Product</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
			
			<div class="col-md-4">
              <div class="card card-profile">
                <div>
                  <a href="javascript:;">
                    <img  style="width:75%;" class="img" src="../../'.$url['url'].'" />
                  </a>
                </div>
                <div class="card-body" style="text-align:left;">
                  <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                  <h4 class="card-title"><b>Alec Thompson</b></h4><br>
				  <h7>Rs 40</h4><br>
				  <h4>Rs 60</h4><br>
                  <p class="card-description">
        			
                  </p>
                  <a href="javascript:;" class="btn btn-danger btn-round">Add to Cart</a>
                </div>
              </div>
            </div>
			
			';
	if (isset($_POST['editproduct']))
	{
		$storage = new Storage();
		if(!empty($_FILES["frontimage"]['name'])){$id1 = $storage->NewSlot(true,"products","frontimage");}else{$id1 = $imagearray[0];}
		if(!empty($_FILES["leftimage"]['name'])){$id2 = $storage->NewSlot(true,"products","leftimage");}else{$id2 = $imagearray[1];}
		if(!empty($_FILES["rightimage"]['name'])){$id3 = $storage->NewSlot(true,"products","rightimage");}else{$id3 = $imagearray[2];}
		if(!empty($_FILES["rearimage"]['name'])){$id4 = $storage->NewSlot(true,"products","rearimage");}else{$id4 = $imagearray[3];}
		
		
		
		$imaged = "[".$id1.",".$id2.",".$id3.",".$id4."]";
		$name = $_POST["pname"];
		$price = $_POST["oldprice"];
		$final_price = $_POST["newprice"];
		if(isset($_POST['aval']) && $_POST['aval'] == 'Out'){$avl = 0;}else{$avl = 1;}
		
		$category = $_POST["cater"];
		$description = $_POST["desc"];
		
		$product = new Products();
		$product->PutProduct($id,$name,$price,$final_price,$avl,$imaged,$category,$description);
		header('Location: productlist.php');
		
		}
	
	
	
	return $result;
	}
	
	function ViewStaff($list)
	{	$del = new DeliveryStaff();
		$result = '';
			$str = new Storage();
		
	
	foreach($list as $staff){
		$result = $result.' 
			
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="javascript:;">
                    <img class="img" src="../../';
					$url = $str->GetUrl($staff[6]);
					$result = $result.$url['url'];
					
					$result = $result.'" />
                  </a>
                </div>
                <div class="card-body">
                  <h4 class="card-title">'.$staff[1].'</h4>
                  '.$staff[2].'
				   <div class = "row">
				   		<div class="col-md-6">
						<form method="post">
                        	<div class="form-group">
                          		<label class="bmd-label-floating">'.$staff[5].'</label>
                          		<input type="text" name="newtemp'.$staff[0].'" class="form-control">
							</div></div>
						
						<div class="col-md-6">
						  <button type="submit" name="updtemp'.$staff[0].'" class="btn btn-primary pull-right">Update Temp</button></form>
                        </div>
					</div>
                   
				   </div>
				    <h6 class="card-title">Current Order : '.$staff[4].'<br></h6>
                </div>
              </div>
			  ';
			
			if(isset($_POST['updtemp'.$staff[0]]))
			{$del->UpdateTemp($staff[0],$_POST['newtemp'.$staff[0]]);
			header('Location: stafflist.php');}
			  
	}
	
	
	
	
			  $result = $result.'';
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
                    <img  style="width:75%;" class="img" src="../../'.$url['url'].'" />
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
	
	


	function LeftButton($button,$link)
	{ $result = '
				<div class="col-md-12">
				 <a href="'.$link.'" class="btn btn-danger btn-round pull-right">'.$button.'</a>
				 </div>

				'
				
			;
		return $result;
								
	}
	
	
	function NewStaff($dp)
	{$del = new DeliveryStaff();
		$result = '';
			$stt = new Storage();
			$url = $stt->GetUrl($dp);
		
	
	
		$result = '  
			
			<div class="col-md-4" style="margin:auto;">
              <div class="card card-profile">
                <div>
                  <a href="javascript:;">
                    <img  style="width:75%;" class="img" src="../../'.$url['url'].'" />
                  </a>
                </div>
                <div class="card-body" style="text-align:left;">
                 
				 
						<form method="post" enctype="multipart/form-data">
							 <label class="btn btn-primary">
							  Upload Profile picture
							  <input style="display: none;" type="file" name="image" accept="image/*">
							  </label>
						
                        	<div class="form-group">
                          		<label class="bmd-label-floating">Delivery Staff Name</label>
                          		<input type="text" name="sname" class="form-control">
							</div>
							<button type="submit" class="btn btn-primary pull-right" name="addstaff">Add Staff</button>
							
				</form>
                  
				 
				 
                  <p class="card-description">
        			
                  </p>
                
                </div>
              </div>
            </div>
			
			';
		
	if (isset($_POST['addstaff']))
	{
		$storage = new Storage();
		if(!empty($_FILES["image"]['name'])){$id1 = $storage->NewSlot(true,"staffdp","image");}else{$id1 = 0;}
		$name = $_POST["sname"];
		$stf = new DeliveryStaff();
		$stf->AddStaff($name,$id1);
		
	}
	return $result;
	}
	
}
?>