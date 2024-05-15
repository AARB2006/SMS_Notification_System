<?php

function get_usernamesADMIN($conn) {
    // Replace with your table name
    $sql = "SELECT username FROM users ORDER BY username ASC";
  
    $result = $conn->query($sql);
  
    if ($result->num_rows > 0) {
      $usernames = [];
      while ($row = $result->fetch_assoc()) {
        $usernames[] = $row["username"];
      }
      return $usernames;
    } else {
      return [];
    }
}

function getStudents($conn){

  $sql = "SELECT lastName, firstName, fullName FROM students ORDER BY lastName ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $fullName = [];
    while ($row = $result->fetch_assoc()) {
      $fullName[] = $row["fullName"];
    }
    return $fullName;
  } else {
    return [];
  }

}


function displaySTUDENTS($fullName) {
  $currentLetter = "";

  echo "<table>";
  echo "<thead>"; // Add table header row
  
  echo "</thead>";
  echo "<tbody>"; // Add table body for content

  foreach ($fullName as $fullname) {
    $firstLetter = strtoupper(substr($fullname, 0, 1));

    // Print letter header row if it changes
    if ($currentLetter != $firstLetter) {
      if ($currentLetter != "") {
        echo "</tbody></table>"; // Close previous letter section
      }
      echo "<h2>" . $firstLetter . "</h2>";
      echo "<table>";
      echo "<thead>";
      
      echo "</thead>";
      echo "<tbody>";
      $currentLetter = $firstLetter;

    }

    // Display username with checkbox in a table row
    echo "<tr>";
    echo "<td><input type='checkbox' name='selected_students[]' class='checkbox' value='$fullname'><a href='studentCheck.php?fullname=" . urlencode($fullname) . "'>$fullname</a></td>";
    echo "</tr>";
  }
  echo "</tbody></table>"; // Close the last letter section
}

function displaySTUDENTS2($fullName) {
  $currentLetter = "";

  echo "<table>";
  echo "<thead>"; // Add table header row
  
  echo "</thead>";
  echo "<tbody>"; // Add table body for content

  foreach ($fullName as $fullname) {
    $firstLetter = strtoupper(substr($fullname, 0, 1));

    // Print letter header row if it changes
    if ($currentLetter != $firstLetter) {
      if ($currentLetter != "") {
        echo "</tbody></table>"; // Close previous letter section
      }
      echo "<h2>" . $firstLetter . "</h2>";
      echo "<table>";
      echo "<thead>";
      
      echo "</thead>";
      echo "<tbody>";
      $currentLetter = $firstLetter;

    }

    // Display username with checkbox in a table row
    echo "<tr>";
    echo "<td><input type='checkbox' name='selected_students[]' class='checkbox' value='$fullname'>$fullname</td>";
    echo "</tr>";
  }
  echo "</tbody></table>"; // Close the last letter section
}


function display_usernamesADMIN($usernames) {
    $currentLetter = "";
  
    echo "<table>";
    echo "<thead>"; // Add table header row
    
    echo "</thead>";
    echo "<tbody>"; // Add table body for content
  
    foreach ($usernames as $username) {
      $firstLetter = strtoupper(substr($username, 0, 1));
  
      // Print letter header row if it changes
      if ($currentLetter != $firstLetter) {
        if ($currentLetter != "") {
          echo "</tbody></table>"; // Close previous letter section
        }
        echo "<h2>" . $firstLetter . "</h2>";
        echo "<table>";
        echo "<thead>";
        
        echo "</thead>";
        echo "<tbody>";
        $currentLetter = $firstLetter;
      }
  
      // Display username with checkbox in a table row
      echo "<tr>";
      echo "<td><input type='checkbox' name='selectedusers[]' class='checkbox' value='$username'><a href='userCheck.php?username=" . urlencode($username) . "'>$username</a></td>";
      echo "</tr>";
    }
    echo "</tbody></table>"; // Close the last letter section
  }




function display_usernamesADMIN2($usernames, $loggedInUsername) {
  $currentLetter = "";

  echo "<table>";
  echo "<thead>"; // Add table header row
  
  echo "</thead>";
  echo "<tbody>"; // Add table body for content

  foreach ($usernames as $username) {
    $firstLetter = strtoupper(substr($username, 0, 1));

    // Print letter header row if it changes
    if ($currentLetter != $firstLetter) {
      if ($currentLetter != "") {
        echo "</tbody></table>"; // Close previous letter section
      }
      echo "<h2>" . $firstLetter . "</h2>";
      echo "<table>";
      echo "<thead>";
      
      echo "</thead>";
      echo "<tbody>";
      $currentLetter = $firstLetter;
    }

    // Display username with checkbox in a table row
    echo "<tr>";
    echo "<td>";
    if ($username == $loggedInUsername) {
      echo "$username";
    } else {
      echo "<input type='checkbox' name='selectedusers[]' class='checkbox' value='$username'><a href='userCheck.php?username=" . urlencode($username) . "'>$username</a>";
    }
    echo "</td>";
    echo "</tr>";
  }
  echo "</tbody></table>"; // Close the last letter section
}



function createADMIN($conn){

  define('AES_256_CBC', 'aes-256-cbc');

  $key = "my32digitkey12345678901234567890";
  $iv = "my16digitIvKey12";

  $check = "SELECT * FROM users";
  $result = mysqli_query($conn, $check);

  if (mysqli_num_rows($result) > 0){ //there are already existing rows in database. DO NOT create an admin account
    mysqli_close($conn);
  
  }

  else{ //Create.

    $firstName = "First Name";
    $lastName = "Last Name";
    $username = "Admin";
    $password = "passwordsAdmin";
    $email = "admin@email.com";
    $id = "04-2024-18";
    $role = "admin";

    $encryptedEmail = openssl_encrypt($email, 'aes-256-cbc', $key, 0, $iv);
    $encryptedPassword = openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv);
    $encryptedFirstName = openssl_encrypt($firstName, 'aes-256-cbc', $key, 0, $iv);
    $encryptedLastName = openssl_encrypt($lastName, 'aes-256-cbc', $key, 0, $iv);

    $query = "INSERT into users(user_id, firstName, lastName, username, email, password, role) VALUES ('$id','$encryptedFirstName', '$encryptedLastName','$username','$encryptedEmail','$encryptedPassword', '$role')";
    mysqli_query($conn,$query);
    mysqli_close($conn);

  }

}



function login($conn){

  define('AES_256_CBC', 'aes-256-cbc');

  $key = "my32digitkey12345678901234567890";
  $iv = "my16digitIvKey12";

  if(empty($_POST['username']) || empty($_POST['password'])){

    $error_message = "Error: Incomplete Inputs.";
    session_start();
    $_SESSION['error_message'] = $error_message;
    header("Location: login.php");
    exit();

  }

  elseif(!empty($_POST['username']) && !empty($_POST['password'])){
  
    $username =  mysqli_real_escape_string($conn, $_POST['username']);
    $password =  mysqli_real_escape_string($conn, $_POST['password']);
    $passwordCheck = openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv);

    $check = "SELECT * FROM users WHERE username = '$username' AND password = '$passwordCheck' ";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0){ //user exists

      $row = mysqli_fetch_assoc($result);

      $role = $row['role'];
      $id =$row['user_id'];

      if($role == 'admin'){

        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['accountName'] = $username;     
        header("Location: admin Main Page.php");
        exit();

      }

      elseif($role == 'user'){

        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['accountName'] = $username;     
        header("Location: user Main Page.php");
        exit();

      }
    }else{


      $error_message = "Error: No Account Match.";
      session_start();
      $_SESSION['error_message'] = $error_message;
      header("Location: login.php");
      exit();

    }

  }

}


function emailCheck($conn){

  define('AES_256_CBC', 'aes-256-cbc');

  $key = "my32digitkey12345678901234567890";
  $iv = "my16digitIvKey12";
  $email = $_POST['email'];

  if(empty($email)){

      $error_message = "Error: Empty.";
      session_start();
      $_SESSION['error_message'] = $error_message;
      header("Location: emailCheck.php");
      exit();
  }

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    
    $error_message = "Error: Invalid Email.";
      session_start();
      $_SESSION['error_message'] = $error_message;
      header("Location: emailCheck.php");
      exit();
  }

  else{
    $emailcheck = openssl_encrypt($email,'aes-256-cbc',$key,0,$iv);
    $sql = "SELECT email FROM users WHERE email = '$emailCheck' ";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){

      $error_message = "Error: Email Already Exists.";
      session_start();
      $_SESSION['error_message'] = $error_message;
      header("Location: emailCheck.php");
      exit();

    }

    else{

      session_start();
      $_SESSION['emailcheck'] = $emailcheck;
      header("Location: changePassword.php");
      exit();

    }

  }
}

function displayMsg($conn){
  $sql = "SELECT * FROM messages";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<table>";
        echo "<tr><th>ID</th><th>Author</th><th>Message Body</th><th>Recipient</th><th>Date and Time Sent</th></tr>";
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["msg_id"] . "</td>";
      echo "<td>" . $row["author"] . "</td>";
      echo "<td>" . $row["msgbody"] . "</td>";
      echo "<td>" . $row["recipient"] . "</td>";
      echo "<td>" . $row["date_and_time_sent"] . "</td>";
      echo "</tr>";
  }
  echo "</table>";
} else {
  echo "<h3>0 results</h3>";
}

// Close database connection
$conn->close();
}


// Function to get students based on search query
function getFilteredStudents($conn, $searchQuery){
  $sql = "SELECT lastName, firstName, fullName FROM students WHERE fullName LIKE '%$searchQuery%' ORDER BY lastName ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $fullName = [];
    while ($row = $result->fetch_assoc()) {
      $fullName[] = $row["fullName"];
    }
    return $fullName;
  } else {
    return [];
  }
}

?>