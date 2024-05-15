<?php

    include 'db conn.php';
    $conn = conn();

    define('AES_256_CBC', 'aes-256-cbc');

  $key = "my32digitkey12345678901234567890";
  $iv = "my16digitIvKey12";

    session_start();

    $email = $_SESSION['emailcheck'];

    // Check if there's an error message in the session
    if (isset($_SESSION['error_message'])) {
        $errmsg= $_SESSION['error_message'];
        unset($_SESSION['error_message']); // Clear the error message after displaying
        session_destroy(); // End the session
    }

   if(isset($_POST['submit'])){

     $password = $_POST['password'];
     $confirm = $_POST['confirm'];

     if(empty($password)||empty($confirm)){

        $error_message = "Error: Empty.";
      session_start();
      $_SESSION['error_message'] = $error_message;
      header("Location: changePassword.php");
      exit();

     }

     if(strlen($password)<8 && strlen($confirm)<8){

        $error_message = "Error: Should have 8 characters or more .";
        session_start();
        $_SESSION['error_message'] = $error_message;
        header("Location: changePassword.php");
        exit();
        
     }

     if($password !== $confirm){

      $error_message = "Error: Not Equal.";
      session_start();
      $_SESSION['error_message'] = $error_message;
      header("Location: changePassword.php");
      exit();
     }

     $encrypt = openssl_encrypt($password,'aes-256-cbc',$key,0,$iv);
     $sql = "UPDATE users SET password = '$encrypt' WHERE email = '$email'";
     mysqli_query($conn,$sql);
     header("Location: login.php");
     exit();

     

   }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>




<form action="" method="post" class = "form">

      <div class="login"> 

        <div class="title"><h1>Change Password</h1></div>

        <div class = "errmsg">

            <?php if (isset($errmsg)) : ?>
            <p><?php echo $errmsg; ?></p>
            <?php endif; ?>

        </div>
       

        <label for="password"><b>Enter New Password:</b></label>
        <input type="password" name="password" placeholder = "New Password:"> 
        <br><br>
        <label for="confirm"><b>Confirm Password</b></label>
        <input type="password" name="confirm" placeholder = "Confirm Password:"> 
        <br><br>
        <button type="submit" name="submit">Submit</button>
        <button type="button" name="back" onclick="window.location.href='emailCheck.php'">Back</button>

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
</style>
