<?php
//---abstracted ! ------
class connection{
    public $host ="yourHostIp";
    public $user = "UserName"; 
    public $password = "password";
    public $db="yourDatabase";
    public $dbc;
    
    function __construct() {
        $con = mysqli_connect($this->host, $this->user, $this->password, $this->db);
        
        if(mysqli_errno($con)){
            echo"sum error";
            
        }
        else{
           $this->dbc = $con; // assign $con to $dbc
           echo"connected ";
        }
    }
}

$test = new connection();
?>