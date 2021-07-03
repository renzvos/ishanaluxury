<?php 
class Products
{
	
function GetProductbyID($id)
{		
		$Db = new DBController();
        $result = $Db->runQuery("SELECT * FROM productdetails WHERE `id` = ?", "i", array($id));
        return $result[0];
}

function PutProduct($id,$product_Name,$price,$final_price,$Instock,$Images,$category,$description)
{
	if($id == 0)
	{
			$result = $this->InsertProduct($product_Name,$price,$final_price,$Instock,$Images,$category,$description);
			return $result;
	}
	else
	{
			$result = $this->UpdateProduct($id,$product_Name,$price,$final_price,$Instock,$Images,$category,$description);
			return $result;
	}
	
}

function InsertProduct($product_Name,$price,$final_price,$Instock,$Images,$category,$description)
{
$ser = new backed();
$coulmn = '`product_Name`, `price`, `final_price`, `Instock`, `Images`, `category`, `description` ,`sold`';
$values = "'".$product_Name."','".$price."','".$final_price."','".$Instock."','".$Images."','".$category."','".$description."','0'";
$ser->Insert("productdetails",$coulmn,$values);
return "Product Added";
}


function UpdateProduct($id,$product_Name,$price,$final_price,$Instock,$Images,$category,$description)
{
	$Db = new DBController();
	
	$query = "UPDATE `productdetails` SET `product_Name` = ?, 
	`price` =  ?, 
	`final_price` = ?, 
	`Instock`  = ? , 
	`Images` =  ?, 
	`category` = ?, 
	`description` = ?  
	WHERE `id` = ?";
   
    $result = $Db->update($query,"sddssisi", array($product_Name,$price,$final_price,$Instock,$Images,$category,$description,$id));
    return "Updated";
	
}

function GetPrice($id)
{
	$Db = new DBController();
        $result = $Db->runQuery("SELECT `final_price`FROM productdetails WHERE `id` = ?", "i", array($id));
        return $result[0]['final_price'];
		
}

function GetProductBySold()
{
	$Db = new DBController();
        $result = $Db->RawSQL("SELECT * FROM productdetails WHERE `Instock` = 1 ORDER BY `sold` DESC");
        return $result;}
		
function GetProductBySoldLimit($limit)
{
	$Db = new DBController();
        $result = $Db->RawSQL("SELECT * FROM productdetails ORDER BY `sold` DESC LIMIT ".$limit);
        return $result;}
		

function GetProductByAttribute($key,$value)
{
	$Db = new DBController();
		$result = $Db->RawSQL("SELECT * FROM productdetails WHERE `".$key."`='".$value."'");
        return $result;
}

function Keyword($key)
{
		$Db = new DBController();
		$result = $Db->RawSQL("SELECT * FROM productdetails WHERE `product_Name` LIKE '%".$key."%'");
        return $result;
}

function UpdateReview($review,$id)
{
	$Db = new DBController();
	
	$query = "UPDATE `productdetails` SET `reviews` = ? WHERE `id` = ?";
   
    $result = $Db->update($query,"si", array($review,$id));
    return "Updated";
	
}



}



?>