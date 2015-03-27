<?php
//---abstracted ! ------
class connection{
    public $host ="cs.uky.edu";
    public $user = "javi223"; 
    public $password = "password";
    public $db="cs405";
    public $dbc;
    
    function __construct() {
        $con = mysqli_connect($this->host, $this->user, $this->password, $this->db);
        
        if(mysqli_errno($con)){
            echo"some error";
            
        }
        else{
           $this->dbc = $con; // assign $con to $dbc
           echo"connected ";
        }
    }
}

$test = new connection();
?>