<?php

session_start();
$username = $_SESSION['accountName'];

include 'db conn.php';
$conn = conn();
define('AES_256_CBC', 'aes-256-cbc');


  $key = "my32digitkey12345678901234567890";
  $iv = "my16digitIvKey12";

$sql = "SELECT * FROM users WHERE username = '$username'";
$res = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($res)){

    $firstname = openssl_decrypt($row['firstName'], 'aes-256-cbc', $key, 0, $iv);
    $lastname = openssl_decrypt($row['lastName'], 'aes-256-cbc', $key, 0, $iv);
    $usernamew = $row['username'];
    $email = openssl_decrypt($row['email'], 'aes-256-cbc', $key, 0, $iv);
    $password = $row['password'];
    $decrypted = openssl_decrypt($password,'aes-256-cbc',$key,0,$iv);
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    
<div class = "left">
<h1><?php echo $usernamew;?></h1>

<div class ="buttonsDiv">

  <button onclick="window.location.href='editProfileInfo.php'">Edit Info</button>
  <button onclick="history.back()">Back</button>

</div>

</div>

<div class="right">
  <h1 class="infoheader">INFORMATION:</h1>

  <div class="INFO">
  <h2>Last Name: <?php echo $lastname?></h2>
  <h2>First Name: <?php echo $firstname?></h2>
  <h2 >Email Address: <?php echo $email?></h2>
  <h2 id="no">Password: <?php echo $password?></h2>
  <button id="decrypt" onclick="decrypt()">Show</button>
  <button id="encrypt" onclick="encrypt()">Encrypt</button>
 
  </div>
  
</div>

<script>

function decrypt()
{

  document.getElementById("no").innerText = "Password: <?php echo $decrypted?>";
}

function encrypt()
{

  document.getElementById("no").innerText = "Password: <?php echo $password?>";

}





</script>
</body>
</html>

<style>
  .left, .right{
    display: inline-block;
    border: 3px white solid;
    padding: 20px;
    text-align: center;
    color: white;


  }

  body, html{

    height: 100%;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: Arial, Helvetica, sans-serif;

  }

  .left{

    height: 400px;
    width: 200px;
    background-color:  #406cdb;

  }

  .right{

    width: 800px;
    font-size: 10px;
    height: 400px;
    background-color:  #406cdb;
    
  }

  .right h1{
    font-size: 30px;
    padding-top:10px;
  }

  .infoheader{
    
    padding-top:20px;
  }

  .right button{

    background-color:#406cdb;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    font-size: 20px;
    text-decoration: underline;

  }

  .INFO{
    text-align: left;
    font-size: 16px;
  }

  .left h1{
    padding-top: 50px;
    font-size: 25px;
  }

  .buttonsDiv{

    padding-top: 100px;
  }
  .left button{
    background-color:#406cdb;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    font-size: 20px;
    text-decoration: underline;
    
    font-size: 20px;
  }

  button:hover{
    background-color: #485996;
  color: white;
  }
</style>