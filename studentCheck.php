<?php
include 'db conn.php';
$conn = conn();
define('AES_256_CBC', 'aes-256-cbc');
session_start();

  $key = "my32digitkey12345678901234567890";
  $iv = "my16digitIvKey12";

$fullname = isset($_GET['fullname']) ? $_GET['fullname'] : null;

$sql = "SELECT * FROM students WHERE fullName = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $fullname);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// Check if a user with the provided username exists
if (mysqli_num_rows($result) > 0) {
  $studentData = mysqli_fetch_assoc($result);

  $firstname = $studentData['firstName'];
  $lastname = $studentData['lastName'];
  $fullName = $studentData['fullName'];
  $contact1 = $studentData['contactNum'];
  $id = $studentData['student_id'];
  $yrlvl = $studentData['yearLevel'];
  $decrypted = openssl_decrypt($studentData['contactNum'], 'aes-256-cbc', $key, 0, $iv);
  

}

$_SESSION['fn'] = $fullName;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Student Info</title>
</head>
<body>
    
<div class = "left">
<h1><?php echo $fullName;?></h1>

<div class ="buttonsDiv">

  <button onclick="window.location.href='editInfoStudents.php'">Edit Info</button>
  <button onclick="window.location.href='studentsList_admin.php'">Back</button>

</div>

</div>

<div class="right">
  <h1 class="infoheader">INFORMATION:</h1>

  <div class="INFO">
  <h2>Last Name: <?php echo $lastname?></h2>
  <h2>First Name: <?php echo $firstname?></h2>
  <h2 id="no">Contact Number: <?php echo $contact1?></h2>
  <button id="decrypt" onclick="decrypt()">Show</button>
  <button id="encrypt" onclick="encrypt()">Encrypt</button>
  <h2>ID Number: <?php echo $id?></h2>
  <h2>Batch: <?php echo $yrlvl?></h2>
  </div>
  
</div>

<script>

function decrypt()
{

  document.getElementById("no").innerText = "Contact Number: <?php echo $decrypted?>";
}

function encrypt()
{

  document.getElementById("no").innerText = "Contact Number: <?php echo $contact1?>";

}

function redirect(variable) {

    // Redirect to the desired URL along with the PHP variable
    window.location.href = 'editInfoStudents.php' + encodeURIComponent(variable);
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
    font-size: 18px;
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