<?php
include 'db conn.php';
$conn = conn();



session_start();

    // Check if there's an error message in the session

if (isset($_SESSION['error_message'])) {
      $errmsg= $_SESSION['error_message'];
      unset($_SESSION['error_message']); // Clear the error message after displaying
      session_destroy(); // End the session
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a User</title>
</head>
<body>




<form action="addUserCheck.php" method="post" class = "form">

      <div class="login"> 

        <div class="title"><h1>Add User</h1></div>

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
        <label for="username"><b>Username</b></label>
        <input type="text" name="username" placeholder = "Enter Username:"> 
        <br><br>
        <label for="email"><b>Email</b></label>
        <input type="text" name="email" placeholder = "Enter Email Address:"> 
        <br><br>
        <label for="password"><b>Password</b></label>
        <input type="password" name="password" placeholder = "Enter Password:">
        <br><br>
        <label for="role"><b>Role</b></label>
        <select name="role">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
        <br><br>

        <button type="submit" name="register">Register</button>
        
        <a href="uList.php">Back</a>

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

select{

  border: 2px solid ;
  background-color:  #406cdb;
  font-size: 20px;
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

