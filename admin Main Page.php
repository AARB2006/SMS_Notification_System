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

    $textmsg = "THIS IS A TEST-GENERATED MESSAGE FROM THE PSHS-EVC GUARDHOUSE SMS NOTIFICATION SYSTEM. DO NOT REPLY.";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Main Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body> 
<div class="header" id="myHeader">
  <a href="admin Main Page.php">Main Page</a>
  <a href="studentsList_admin.php">Students List</a>
  <a href="msghistory.php">Message History</a>
  <a href="uList.php">Users List</a>
    
  <div class="header-right">
    
   <div class="dropdown">
    <?php if (isset($displayName)): ?> <button class="dropbtn"><?php echo $displayName; ?><?php endif; ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </div></div></div></div>

    <form action="admin_Main_Page.php" method="get" class ="searchbar">
        <input type="text" id="search_query" class = "srch" placeholder="Search for a student...">

    </form>

<div class="msgBody">
  
<form action="new sending.php" method="post">
  <div class="left">
  <label for="selectedCounter">Student/s Selected:</label>
  <div id="selectedCounter">0/10</div>
  
      <?php

    
      $fullName = getStudents($conn);
      displaySTUDENTS2($fullName);
      $conn->close();

  ?>

  </div>

  <div class="right">
  <button type="submit" name="send" value="Submit" class="send">SEND MESSAGE</button><br><br>
  <textarea name="msgarea" id="" placeholder="Enter Message Here..." rows="50" cols="20"><?php echo isset($_POST['msgarea']) ? htmlspecialchars($_POST['msgarea']) : ''; echo $textmsg;?></textarea><br>
  <div class="space"></div>
  </div>

</form>
</div>

<script>

$(document).ready(function() {
  var maxSelectedStudents = 10;
  var selectedStudents = 0;
  $('#search_query').on('input', function() {
    var searchText = $(this).val().toUpperCase();

    // Reset visibility of all letter headers and students
    $('.left h2, .left table tbody tr').hide();

    // If search text is empty, show all students and letter headers
    if (searchText === '') {
      $('.left h2, .left table tbody tr').show();
      return;
    }

    // Iterate over each student
    $('.left table tbody tr').each(function() {
      var studentName = $(this).text().toUpperCase();

      // Check if student name matches search input
      if (studentName.indexOf(searchText) > -1) {
        $(this).show(); // Show matching student
        $(this).prevAll('h2:first').show(); // Show its letter header
      }
    });
  }).trigger('input'); // Trigger the input event to apply the initial filter

  $('.checkbox').change(function() {
    if (this.checked) {
      selectedStudents++;
    } else {
      selectedStudents--;
    }
    $('#selectedCounter').text(selectedStudents + '/' + maxSelectedStudents);

    if (selectedStudents >= maxSelectedStudents) {
      $('.checkbox:not(:checked)').prop('disabled', true);
    } else {
      $('.checkbox:not(:checked)').prop('disabled', false);
    }
  });
});



</script>





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


  /* Add some top padding to the page content to prevent sudden quick movement */

  .sticky + .content {

  padding-top: 102px;

  }

 .send{
  align-items: center;
  font-size: 20px;
  transform: translateX(80px);
}


  .space{
    padding: 100px;
  }

  .srch{
    font-size: 20px;
    width: 300px;
  }

  .srchbtn{
    font-size: 20px;
  }

  .msgBody {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            
        }

        .left {
            width: calc(50% - 10px); /* Adjust the width as needed */
            float: left;
            padding-top:30px;
            padding-left: 250px;
            text-align: center;
        }
        
        .right {
            width: calc(50% - 10px); /* Adjust the width as needed */
            float: right;
            padding: 30px 0;
            
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
  padding: 2px;
  border: 1px solid #ddd;
  font-size: 15px;
  }

  .searchbar{
    display: flex; /* Make the container a flexbox */
  justify-content: center;
  padding-top: 20px;
  }

  textarea{

    resize: none;
    font-size:30px;
    
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