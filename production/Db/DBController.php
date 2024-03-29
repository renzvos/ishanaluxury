<?php
class DBController {
	private $host;
	private $user;
	private $password;
	private $database;
	private $conn;
	
    function __construct() {
    	
        $prod = new Production();
        $this->host = $prod->host;
        $this->user = $prod->user;
        $this->password = $prod->password;
        $this->database = $prod->database;
        $this->conn = $this->connectDB();
	}	
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
    function runBaseQuery($query) {
                $result = mysqli_query($this->conn,$query);
                while($row=mysqli_fetch_assoc($result)) {
                $resultset[] = $row;
                }		
                if(!empty($resultset))
                return $resultset;
    }
    
    
    
    function runQuery($query, $param_type, $param_value_array) {
        
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if(!empty($resultset)) {
            return $resultset;
        }
    }
    
    function bindQueryParams($sql, $param_type, $param_value_array) {
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }
    
    function insert($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();

    }
    
    function update($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();

        $backup = new BackupSource();
        $backup->Update($query, $param_type, $param_value_array);
    }
	
	function RawSQL($query)
	{
     //echo $query;	
	 $sql = $this->conn->prepare($query);
	 $sql->execute();
     $result = $sql->get_result();
        /*
		You can use if(!result) if you are using INsertion, Updation 
		*/
	
		
		if (!$result){
			
			return $this->conn->insert_id;
			}
		else{ 
      			if ($result->num_rows > 0) {
            		while($row = $result->fetch_assoc())
						{
                		$resultset[] = $row;
           		 		}
					}
					
					if(isset($resultset))
					return $resultset;
			}

	}

}
?>