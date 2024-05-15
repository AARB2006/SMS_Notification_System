<?php

include 'db conn.php';
$conn = conn();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_POST['deleteBtn'])){

        if (isset($_POST['selectedusers']) && is_array($_POST['selectedusers'])){
            foreach($_POST['selectedusers'] as $users){

                $sql = "SELECT * FROM users WHERE username = '$users' ";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
                        $delSQL = "DELETE FROM users WHERE username = '$users'";
                        mysqli_query($conn, $delSQL);
                    }
                }
            }

            header("Location:uList.php");
            exit();

        }

    }
    

}
    

?>