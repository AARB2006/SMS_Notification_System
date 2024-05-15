<?php

    include 'db conn.php';
    require_once("functions.php");
    $conn = conn();

    
    

    session_start();
    // Check if there's an error message in the session
    if (isset($_SESSION['error_message'])) {
        $errmsg= $_SESSION['error_message'];
        unset($_SESSION['error_message']); // Clear the error message after displaying
        session_destroy(); // End the session
    }

   if(isset($_POST['submit'])){

    emailCheck($conn);

   }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Email</title>
</head>
<body>




<form action="" method="post" class = "form">

      <div class="login"> 

        <div class="title"><h1>Validate Email</h1></div>

        <div class = "errmsg">

            <?php if (isset($errmsg)) : ?>
            <p><?php echo $errmsg; ?></p>
            <?php endif; ?>

        </div>
       

        <label for="username"><b>Enter Email</b></label>
        <input type="text" name="email" placeholder = "Validate Email:"> 
        <br><br>
        <button type="submit" name="submit">Submit</button>
        <button type="button" name="back" onclick="window.location.href='login.php'">Back</button>

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
