<?php 
class Storage{
	
	
	function SaveAPI($newfilename,$type,$loc)
	{
		if($_SERVER['REQUEST_METHOD']=='POST'){
			if(isset($_FILES['file']['name'])){
			//getting file info from the request 
			$fileinfo = pathinfo($_FILES['file']['name']);
			//getting the file extension 
			$extension = $fileinfo['extension'];
			//file path to upload in the server 
			$file_path = "../storage/" .$type.'/'. $newfilename . '.'. $extension; 
			
			//trying to save the file in the directory 
			try{
				//saving the file 
				move_uploaded_file($_FILES['file']['tmp_name'],$file_path);
				
				$response['error']=false;
				$response['message']="File Uploaded";
				
			//if some error occurred 
			}catch(Exception $e){
				$response['error']=true;
				$response['message']=$e->getMessage();
			}		
			//displaying the response 
			echo json_encode($response);
			
		}else{
			$response['error']=true;
			$response['message']='Please choose a file';
			echo json_encode($response);
		}
		
		}
	}
	
	
	function Savebackend($slotname,$type,$id){
	
	if(empty($_FILES[$slotname]['name']))
	{	
			echo '<script>alert("Select Images to upload");</script>';
			return "";
	}
	else
	{	 $fileinfo = pathinfo($_FILES[$slotname]['name']);
			$extension = $fileinfo['extension'];
			$url = "../../storage/".$type."/".$id.".".$extension;
			move_uploaded_file($_FILES[$slotname]['tmp_name'],$url);
			return "storage/".$type."/".$id.".".$extension;;
	}
	}
	
	
	
	function GetUrl($id)
	{
		$Db = new DBController();
        $result = $Db->runQuery("SELECT `url` FROM `storage` WHERE `id` = ?", "i", array($id));
        return "storage/".$result[0]['url'];
	}
	
	function NewSlot($backend,$type,$slot)
	{	
		
	$ser = new backed();
	$coulmn = '`url`,`type`';
	$values = "'temp','".$type."'";
	$ser->Insert("storage",$coulmn,$values);
	
	$Db = new DBController();
    $result = $Db->runQuery("SELECT * FROM `storage` WHERE `url` = ?", "s", array("temp"));
  	$id= $result[0]['id']; 
	
	if($backend){
				$url = $this->Savebackend($slot,$type,$id);
				
	}else	
	
	{ $this->SaveAPI();}
 
 
	$query = "UPDATE `storage` SET `url` = ? WHERE `id` = ?";
    $result = $Db->update($query,"si", array($url,$id));
    
	return $id;
	 
	
	
	}
	
	function ExternalDP($url)
	{
	$ser = new backed();
	$coulmn = '`url`,`type`,`size`';
	$values = "'".$url."','ExternalGoogle','0'";
	$ser->Insert("storage",$coulmn,$values);
	
	
	$Db = new DBController();
    $result = $Db->runQuery("SELECT * FROM `storage` WHERE `url` = ?", "s", array($url));
  	$id= $result[0]['id']; 
	
	return $id;
	
	}
	
	
	}


?>