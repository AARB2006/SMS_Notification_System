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
    $fn = $_SESSION['fn'];


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    if(!empty($_POST['fName'])){

        $fname = $_POST['fName'];
        $update = "UPDATE students SET firstName = '$fname' WHERE fullName = '$fn'";
        mysqli_query($conn, $update);
  

    }

    if(!empty($_POST['lName'])){
       $lname = $_POST['lName'];
        $update1 = "UPDATE students SET lastName = '$lname' WHERE fullName = '$fn'";
        mysqli_query($conn, $update1);
    }

    if(!empty($_POST['contactOne'])){//contact number check
        $con = openssl_encrypt($_POST['contactOne'], 'aes-256-cbc', $key,0,$iv) ;

        $check = "SELECT contactNum FROM students WHERE contactNum ='$con'";
        $ress = mysqli_query($conn,$check);

        if(mysqli_num_rows($ress)>0){
            $error_message = "Error: Contact Number Already Exists";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: editInfoStudents.php");
            exit();
        }

         $update2 = "UPDATE students SET contactNum = '$con' WHERE fullName = '$fn'";
         mysqli_query($conn, $update2);
     }

     if(!empty($_POST['batch'])){
        $bat = $_POST['batch'];
         $update3 = "UPDATE students SET yearLevel = '$bat' WHERE fullName = '$fn'";
         mysqli_query($conn, $update3);
     }

     if(!empty($_POST['studentID'])){
        $i = $_POST['studentID'];

        $check = "SELECT student_id FROM students WHERE student_id ='$i'";
        $ress = mysqli_query($conn,$check);

        if(mysqli_num_rows($ress)>0){
            $error_message = "Error: Student ID Already Exists";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: editInfoStudents.php");
            exit();
        }
         $update4 = "UPDATE students SET student_id = '$i' WHERE fullName = '$fn'";
         mysqli_query($conn, $update4);
     }

    if(!empty($_POST['fName']) || !empty($_POST['lName'])) {
        // Fetch current full name from the database
        $sql = "SELECT fullName FROM students WHERE fullName = '$fn'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_full_name = $row['fullName'];
        }

        // Determine the new full name
        $new_full_name = '';
        if(!empty($_POST['fName']) && !empty($_POST['lName'])) {
            $new_full_name = $_POST['lName'] . ', ' . $_POST['fName'];
        } elseif(!empty($_POST['lName'])) {
            $new_full_name = $_POST['lName'] . ', ' . explode(', ', $current_full_name)[1];
        } elseif(!empty($_POST['fName'])) {
            $new_full_name = explode(', ', $current_full_name)[0] . ', ' . $_POST['fName'];
        }
        else{
            $new_full_name = $current_full_name;
        }

        // Update full name in the database
        if(!empty($new_full_name)) {
            $currentUser['full_name'] = $new_full_name;

            if(!empty($_POST['studentID'])){ //if student id was edited
                $newid = $_POST['studentID'];

                $sql = "UPDATE students SET fullName= '$new_full_name' WHERE student_id='$newid' "; // Update full name in the database
                $conn->query($sql);

            }
            else{
                $sqlb4 = "SELECT student_id FROM students WHERE fullName = '$fn'"; //user id not edited
                $result = mysqli_query($conn, $sqlb4);

                if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_assoc($result);
                    $idd = $row['student_id'];
                }
                $sql = "UPDATE students SET fullName='$new_full_name' WHERE student_id= '$idd' "; // Update full name in the database
                $conn->query($sql);
            }
            
        }
    }

    header("Location: studentsList_admin.php");
    exit(); 
       
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
        <label for="contactOne"><b>Contact Number:</b></label>
        <input type="text" name="contactOne" placeholder = "Enter Contact Number:">
        <br><br>
        <label for="batch"><b>Batch</b></label>
        <input type="text" name="batch" placeholder = "Enter Batch:">
        <br><br>

        <label for="studentID"><b>Student ID</b></label>
        <input type="text" name="studentID" placeholder = "Enter Student ID:">
        <br><br>
        <button type="submit" name="edit">Edit</button>
        
        <a href="studentsList_admin.php">Back</a>

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

