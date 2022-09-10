<?php
  class Database {
    public $con;
    public function __construct(){
        try {
            $this -> con = mysqli_connect("localhost", "id19547232_internship", "Pandu@111111", "id19547232_intern");
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
  }
  

  <?php
  class Database {
      public $con;
    public function __construct(){
    
     if (!empty($User)) {
        if (!empty($Pass)) {
            $User = "id19547232_internship";
            $Pass = "Pandu@111111";
            $db = "id19547232_intern";
            $host = "localhost";
            
        //create connection
    $con = mysqli_connect($host, $User, $Pass, $db); 
    if($conn){
      echo "Connection Successful.<br>";
    }else
    {
      die("Error in connection".mysqli_connect_error());
        
    }

    
        }}}}