<?php

    include 'db conn.php';
    require_once("functions.php");
    $conn = conn();
    session_start();
    
    $is_logged_in = $_SESSION['logged_in'];

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 'true'){

      $displayName = $_SESSION['accountName'];

    }

    else{

      header("Location: index.php");
      exit();
    }

          
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message History(Users)</title>
</head>
<body> 
<div class="header" id="myHeader">
  <a href="user Main Page.php">Main Page</a>
  <a href="msghistoryusers.php">Message History</a>
    
  <div class="header-right">
    
   <div class="dropdown">
    <?php if (isset($displayName)): ?> <button class="dropbtn"><?php echo $displayName; ?><?php endif; ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </div></div></div></div>

<div class ="msgHistory">

<?php displayMsg($conn);?>
</div>

</body>
</html>



<style>

  * {box-sizing: border-box;}

  .content {

  padding: 16px;

  }


  .sticky {

  position: fixed;

  top: 0;

  width: 100%

  }

  h3{
  line-height: 200px;
  height: 200px;
  
  text-align: center;

  }
  /* Add some top padding to the page content to prevent sudden quick movement */

  .sticky + .content {

  padding-top: 102px;

  }
 .left{
  width: 200px;
  
  position: static;
 }

 .right{
  width: 400px;
  

 }

 .left, .right{
    display: inline-block;
    border: 3px white solid;
    padding: 20px;
    text-align: center;
    
    


  }

.msgBody{
  height: 100%;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: Arial, Helvetica, sans-serif;
  
}
  .user-container{
  margin-top: 20px;
  margin-left: 100px;
  margin-right: 100px;
  
  }

  table {
  border-collapse: collapse;
  width: 100%;
  }
  th, td {
  padding: 8px;
  border: 1px solid #ddd;
  }

  textarea{

    resize: none;
    
  }


  
  h2 {
    margin-top: 1rem;
    background-color: #ddd;
    border-radius: 8px;
    padding: 8px;
  }



  body { 
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
  }

  .header {
    overflow: hidden;
    background-color: #1458e0;
    padding: 8px 10px;
    z-index: 2000;
    
  }

  .header a {
    float: left;
    color: black;
    text-align: center;
    padding: 12px;
    text-decoration: none;
    font-size: 18px; 
    line-height: 25px;
    border-radius: 4px;
    color: white;
  }

  .header a.logo {
    font-size: 25px;
    font-weight: bold;
  }

  .header a:hover {
    background-color: #ddd;
    color: black;
  }

  .header a.active {
    background-color: dodgerblue;
    color: white;
  }

  .header-right {
    float: right;
  }

  .dropdown {
    float: right;
    overflow: hidden;
  }

  .dropdown .dropbtn {
    font-size: 18px;  
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
  }

  .dropdown:hover .dropbtn, .dropbtn:focus {
    background-color: #ddd;
    color: black;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    right: 0;
  }

  .dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
  }

  .dropdown-content a:hover {
    background-color: #ddd;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  @media screen and (max-width: 500px) {
    .header a {
      float: none;
      display: block;
      text-align: left;
    }
    
    .header-right {
      float: none;
    }
  }

</style>