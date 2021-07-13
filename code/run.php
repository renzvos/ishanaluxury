<?php
class Order
{
	function PlaceOrder($orderid,
		$email,
		$product,
		$final_price,
		$status,
		$location,
		$Displayname,
		$Name,
		$BillEmail,
		$FirstName,
		$MiddleName,
		$LastName,
		$Address1,
		$Address2,
		$Address3,
		$Country,
		$PostalCode,
		$State,
		$Phone,
		$Fax,
		$deliverystaff,
		$promocode)
	{
	$ser = new backed();
	$coulmn = '`paymentid`,
				`email`,
				`orderitems`,
				`deliverycharge`,
				`final_price`,
				`status`,
				`location`,
				`DisplayName`,
				`Name`,
				`BillEmail`,
				`FirstName`,
				`MiddleName`,
				`LastName`,
				`Address1`,
				`Address2`,
				`Address3`,
				`Country`,
				`PostalCode`,
				`State`,
				`Phone`,
				`Fax`,
				`percentage`,
				`deliverystaff`,
				`Promocode`';
	$values =   $orderid.",'"
				.$email."','"
				.$product."',"
				."0,"
				.$final_price.",'"
				.$status."','"
				.$location."','"
				.$Displayname."','"
				.$Name."','"
				.$BillEmail."','"
				.$FirstName."','"
				.$MiddleName."','"
				.$LastName."','"
				.$Address1."','"
				.$Address2."','"
				.$Address3."','"
				.$Country."','"
				.$PostalCode."','"
				.$State."','"
				.$Phone."','"
				.$Fax."',"
				."13,"
				.$deliverystaff.",'"
				.$promocode."'";
	$id = $ser->Insert("orderdetails",$coulmn,$values);
	return $this->GetOrder($id);
	}
	
	function UpdateStatus($status,$perc,$id)
	{
		$Db = new DBController();
		$query = "UPDATE `orderdetails` SET `status` = ?,`percentage` = ? WHERE `id` = ?";
   		$result = $Db->update($query,"sii", array($status,$perc,$id));
		
	}
	
	function GetUserOrders($email)
	{	$Db = new DBController();
        $result = $Db->runQuery("SELECT * FROM orderdetails WHERE `email` = ? ORDER BY `Date` DESC", "s", array($email));

        $farray = array();
        foreach ($result as $row) {
        $fresult['id'] = $row['id'];
		$fresult['product'] = $row['orderitems'];
		$fresult['final_price'] = $row['final_price'];
		$fresult['status'] = $row['status'];
		$fresult['percentage'] = $row['percentage'];
		$fresult['Date'] = $row['Date'];
		array_push($farray, $fresult);
        }
       

        return $farray;
        }
	
	function GetOrder($id)
	{
		$Db = new DBController();
        $result = $Db->runQuery("SELECT * FROM orderdetails WHERE `id` = ?", "i", array($id));
        
		
		$fresult['id'] = $result[0]['id'];
		$fresult['email'] = $result[0]['email'];
		$fresult['orderitems'] = json_decode($result[0]['orderitems']);
		$fresult['final_price'] = $result[0]['final_price'];
		$fresult['status'] = $result[0]['status'];
		$fresult['location'] = json_decode($result[0]['location']);
		$fresult['deliverystaff'] = $result[0]['deliverystaff'];
		$fresult['percentage'] = $result[0]['percentage'];
		
		
	
		
		
		
		
		return $fresult;
	}
	
	function AssignOrderStaff($orderid,$staff)
	{
			$Db = new DBController();
		$query = "UPDATE `orderdetails` SET `'deliverystaff` = ? WHERE `id` = ?";
   		$result = $Db->update($query,"si", array($staff,$id));
				
	}
	
	function GetNewOrder()
	{
		$Db = new DBController();
        $result = $Db->runQuery("SELECT * FROM orderdetails WHERE `status` = ? OR `status` = ? OR `status` = ? OR `status` = ? ORDER BY `Date` DESC", "ssss", array("Ordered","Refund Initiated","Dispatched","Delivery"));
		return $result;
	}
	
	
	

}


?>