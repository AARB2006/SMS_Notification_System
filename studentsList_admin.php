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
    <title>Students List (Admin)</title>
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

<div class="content">

        
    <div class = "buttons">

        <button onclick="window.location.href = '' " class="delete" id="deleteBtn" 
        name = "deleteBtn" form="nameForm" disabled type="submit">Delete Student</button>
        
        <button onclick="window.location.href = 'addStudent.php' " class="add" id="addBtn" 
        name = "addBtn">Add Student</button>

        <button onclick="window.location.href = 'addStudentbyCSV.php' " class="add" id="addBtn" 
        name = "addBtn">Add Students(by CSV)</button>

    </div>
    
    <div class = "actions">
        <input type="checkbox" id="selectAll"> Select All<br>
    </div>

    <div class = "notifmsg">

    <?php if (isset($notifmsg)) : ?>
            <p><?php echo $notifmsg; ?></p>
            <?php endif; ?>

    </div>
      
    <div class = "user-container" id="uc">

    <form action="studentProcessAdmin.php" method="post" id="nameForm">
    <?php

    
    $fullName = getStudents($conn);
    displaySTUDENTS($fullName);
    $conn->close();

    ?>

    </form>

    </div>

    
</body>
</html>

</div>  

<script>
document.addEventListener("DOMContentLoaded", function(){

  var header = document.getElementById("myHeader");
  var sticky = header.offsetTop;
  const checkboxes = document.querySelectorAll('.checkbox');
  const selectAllCheckbox = document.getElementById('selectAll');
  const deleteButton = document.getElementById('deleteBtn');
  
  const form = document.getElementById('nameForm');

  window.onscroll = function() {myFunction()}; // for the header staying up :)
  function myFunction() {
    if (window.pageYOffset > sticky) {
      header.classList.add("sticky");
    } else {
      header.classList.remove("sticky");
    }
  }

  selectAllCheckbox.addEventListener('click', function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        toggleButton();
  });

  checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function () {
            if (!this.checked) {
                selectAllCheckbox.checked = false;
            }
            toggleButton();
        });
  });

  function toggleButton() {
        let atLeastOneChecked = false;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                atLeastOneChecked = true;
            }
        });
      deleteButton.disabled = !atLeastOneChecked;
     
  }

  deleteButton.addEventListener('click', (event) => {
    
    
    // Confirmation message
    const message = "Are you sure you want to delete these students?";

    // Display confirmation popup using a modal
    if (confirm(message)) {
      // If user confirms, submit the form programmatically
      form.submit();
    } else {
      event.preventDefault();
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

  
  h2 {
    margin-top: 1rem;
    background-color: #ddd;
    border-radius: 8px;
    padding: 8px;
  }



  .search-container {
      position: relative;
      height: 100%;
      display: flex;
      justify-content: center; /* Center horizontally */
      align-items: flex-start; /* Align items at the top */
      padding-top: 20px;
      
      
  }

  .search-bar {
      display: flex;
      align-items: center;
  }

  .search-bar input[type="text"] {
      padding: 8px;
      width: 800px; /* You can adjust the width as needed */
      border: 1px solid #ccc;
      font-size: 20px;
      
  }

  .search-bar button {
      padding: 8px 15px;
      background-color: #007bff;
      color: white;
      border: none;
      border: 1px solid #ccc;
      cursor: pointer;
      font-size: 20px;
  }

  .search-results {
      position: absolute;
      top: 100%; /* Position directly under the search bar */
      
      width: 100%; /* Set width to 100% */
      max-width: 800px; /* Limit maximum width to match the search bar */
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 4px;
      z-index: 1000;
      display: none;
      overflow-y: auto; /* Add scrollbar if needed */
      max-height: 200px; /* Limit dropdown height */
      font-size: 20px;
  }

  #search-results ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
  }

  #search-results li {
      padding: 8px 12px;
      cursor: pointer;
  }

  #search-results li:hover {
      background-color: #ddd;
  }

  .buttons {
      padding-top: 20px;
      display: flex;
      justify-content: center; /* Center horizontally */
  }

  .actions {
      padding-top: 20px;
      display: flex;
      justify-content: center; /* Center horizontally */
  }

  .buttons button {
      margin: 0 5px; /* Add margin between buttons */
      font-size: 20px;
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