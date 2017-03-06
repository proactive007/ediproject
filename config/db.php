<?php
class dbConnection  
	{
	    
	    var $host = "localhost";
	    var $user = "root";
	    var $pass = "";
	    var $db  =  "virventu_order_management";

	    protected $myconn;

	    function connect() 
		    {
		        $con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
		        if (!$con) 
			        {
			            die('Could not connect to database!');
			        } 
		        else 
			        {
			            $this->myconn = $con;
			            echo 'Connection established!';
			        }
			    return $this->myconn;
			 }

	    function close() 
		    {
		        mysqli_close($this->myconn);
		        echo 'Connection closedw!';
		    }

	}

	echo $path = dirname(__FILE__);
	//define("LMS_PATH", $path);
?>