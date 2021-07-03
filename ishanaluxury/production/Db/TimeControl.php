<?php
class TimeControl
{
function ChangePassworedExpiryTimeStamp()
{
 $t=time();
 $date = new DateTime(date("Y-m-d H:i:s",$t));
 $date->modify('+2 hour'); 
 $expiry =  $date->format('Y-m-d H:i:s');  
 
 return $expiry;
}




}



?>