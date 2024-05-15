<?php

    include 'db conn.php';

    $conn = conn();
    define('AES_256_CBC', 'aes-256-cbc');

$key = "my32digitkey12345678901234567890";
$iv = "my16digitIvKey12";
    
    

    session_start();
    // Check if there's an error message in the session
    if (isset($_SESSION['error_message'])) {
        $errmsg= $_SESSION['error_message'];
        unset($_SESSION['error_message']); // Clear the error message after displaying
        
    }
    $un = $_SESSION['accountName'];


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    if(!empty($_POST['fName'])){

        $fname = $_POST['fName'];
        $fnamefin = openssl_encrypt($fname,'aes-256-cbc',$key,0,$iv);
        $update = "UPDATE users SET firstName = '$fnamefin' WHERE username = '$un'";
        mysqli_query($conn, $update);
  

    }

    if(!empty($_POST['lName'])){
        $lname = $_POST['lName'];
        $lnamefin = openssl_encrypt($lname,'aes-256-cbc',$key,0,$iv);
        $update1 = "UPDATE users SET lastName = '$lnamefin' WHERE username = '$un'";
         mysqli_query($conn, $update1);
     }

     if(!empty($_POST['email'])){
        $em = openssl_encrypt($_POST['email'],'aes-256-cbc',$key,0,$iv);
        $check = "SELECT email FROM users WHERE email ='$em'";
        $ress = mysqli_query($conn,$check);

        if(mysqli_num_rows($ress)>0){
            $error_message = "Error: Email Already Exists";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: editProfileInfo.php");
            exit();
        }

         $update3 = "UPDATE users SET email = '$em' WHERE username = '$un'";
         mysqli_query($conn, $update3);
     }

     if(!empty($_POST['password'])){
        $p = $_POST['password'];
        if (strlen($p)<8){
            $error_message = "Error: Password should have at least 8 characters";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: editProfileInfo.php");
            exit();
        }
        $pfin = openssl_encrypt($p,'aes-256-cbc',$key,0,$iv);
         $update4 = "UPDATE users SET password = '$pfin' WHERE username = '$un'";
         mysqli_query($conn, $update4);
     }


     if(!empty($_POST['uName'])){

        $us = $_POST['uName'];
        $usernamecheck = "SELECT username FROM users WHERE username = '$us' ";
        $ress = mysqli_query($conn, $usernamecheck);

        if(mysqli_num_rows($ress)>0){
            $error_message = "Error: Username Exists";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: editProfileInfo.php");
            exit();

        }
            $sqlb4 = "SELECT user_id FROM users WHERE username = '$un'"; //user id not edited
            $result = mysqli_query($conn, $sqlb4);
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                $idd = $row['user_id'];
            }
            $sql55 = "UPDATE users SET username= '$us' WHERE user_id= '$idd' "; // Update full name in the database
            mysqli_query($conn, $sql55);
            $_SESSION['accountName'] = $us;

        }
     

     echo '<script>';
     echo 'alert("Profile Edited!Click OK to go back.");';
     echo 'window.addEventListener("click", function(event) {';
     echo '    if (event.target === window) return;';
     echo '    window.history.back();';
     echo '});';
     echo '</script>';

       
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
</head>
<body>




<form action=" " method="post" class = "form">

      <div class="login"> 

        <div class="title"><h1>Edit Information</h1></div>

        <div class = "errmsg">

            <?php if (isset($errmsg)) : ?>
            <p><?php echo $errmsg; ?></p>
            <?php endif; ?>

        </div>
       

        <label for="fName"><b>First Name</b></label>
        <input type="text" name="fName" placeholder = "Enter First Name:"> 
        <br><br>
        <label for="lName"><b>Last Name</b></label>
        <input type="text" name="lName" placeholder = "Enter Last Name:"> 
        <br><br>
        <label for="uName"><b>Username</b></label>
        <input type="text" name="uName" placeholder = "Enter Username:"> 
        <br><br>       
        <label for="email"><b>Email</b></label>
        <input type="text" name="email" placeholder = "Enter Email Address:"> 
        <br><br>  
        <label for="password"><b>Password</b></label>
        <input type="password" name="password" placeholder = "Enter Password:"> 
        <br><br>
        <button type="submit" name="edit">Edit</button>
        <button type="button" name="edit" onclick="window.history.back()">Back</button>
        
        </div> 

    
</form>
</body>
</html>

<style>
.login{
  width: 100%;
  padding: 20px;
  background-color: #406cdb;
  border-radius: 5px;
        }

body, html {
  height: 100%;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: Arial, Helvetica, sans-serif;
  color: white;
}




label {
        display: inline-block;
        width: 150px;
        text-align: right;
        font-size: 20px;
        color:white;
      }

input[type=text] {
 
  border: 2px solid ;
  width: 60%;
  background-color: #406cdb;
  font-size: 20px;
  color:white;
}

input[type=password] {
 
  border: 2px solid ;
  width: 60%;
  background-color:  #406cdb;
  font-size: 20px;
  color: white;
  
}

button{
    background-color:#406cdb;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    font-size: 20px;
    text-decoration: underline;
}

button:hover {
  background-color: #485996;
  color: white;
}

input::placeholder{
  color:white;
  opacity: 50%;
}

.errmsg{
  font-size: 20px;
}

a{
    background-color:#406cdb;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    font-size: 20px;
    text-decoration: underline;
}

a:hover {
  background-color: #485996;
  color: white;
}
</style>
