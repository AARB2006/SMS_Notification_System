<?php
    function conn(){
        
        $host = "localhost";
        $username = "root";
        $password = "";
        $db = "str db";
    
        $conn = mysqli_connect($host,$username,$password,$db);
    
        if ($conn->error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        return $conn;
    
    }
    
?>