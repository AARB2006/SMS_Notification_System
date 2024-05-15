<!-- Main Page -->
<?php
//creating main admin account when system runs for the first time

include 'db conn.php';
$conn = conn();
require_once("functions.php");
session_start();

createADMIN($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
</head>
<body>
    
<div class="header">
    <div class="header-right">
      <button type="submit" name="settings" onclick="location.href='login.php'">Login</button>
    </div>
</div>

<div class = "title-index">
  <h2>SMS-BASED</h2>
  <h3>NOTIFICATION SYSTEM</h3>
  <h1>FOR THE PSHS-EVC</h1>
  <h4>GUARD HOUSE</h4>
</div>

</div>

</body>
</html>

<style>

  * {box-sizing: border-box;}



  body, html { 

    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background-image: url('pisayfront-1024x570.jpg');
    background-size: cover;
    

  }

  .header {
    overflow: hidden;
    background-color: #1458e0;
    padding: 8px 10px;
  }


  .header button{
    background-color: inherit;
    float: left;
    color: black;
    text-align: center;
    padding: 12px;
    text-decoration: none;
    font-size: 20px; 
    line-height: 25px;
    border-radius: 4px;
    color: white;
    border: none;
  }

  .header button:hover {
    background-color: #ddd;
    color: black;
  }


  .header button.active{
    background-color: dodgerblue;
    color: white;
  }

  .header-right {
    float: right;
  }

  @media screen and (max-width: 500px) {
    .header button {
      float: none;
      display: block;
      text-align: left;
    }
    
    .header-right {
      float: none;
    }
  }

  .title-index{
   
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 10px;
  text-align: center;
  background-color: rgba(0,0,0, 0.6);
  border: 10px double white;
    
  }

.title-index h1{
  font-size:40px;
  color: white;
}

.title-index h2{
  font-size:30px;
  color: white;
  letter-spacing: 10px;
}

.title-index h3{
  font-size:35px;
  color: white;
  letter-spacing: 10px;
}

.title-index h4{
  font-size:40px;
  color: white;
  
}

</style>



