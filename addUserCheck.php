<?php

include 'db conn.php';
$conn = conn();

define('AES_256_CBC', 'aes-256-cbc');
$key = "my32digitkey12345678901234567890";
$iv = "my16digitIvKey12";


function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

$firstname = $_POST['fName'];
$lastname = $_POST['lName'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$role = $_POST['role'];



if(!empty($firstname) && !empty($lastname) && !empty($username) && 
!empty($email) && !empty($password)){

    $emailEncrypted = openssl_encrypt($email, 'aes-256-cbc', $key, 0, $iv);
    $passwordEncrpyted = openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv);
    $firstnameEncrypted = openssl_encrypt($firstname, 'aes-256-cbc', $key, 0, $iv);
    $lastnameEncrypted = openssl_encrypt($lastname, 'aes-256-cbc', $key, 0, $iv);

    if(!is_valid_email($email)){ //email format invalid

        $error_message = "Error: Email Format Not Correct";
        session_start();
        $_SESSION['error_message'] = $error_message;
        header("Location: addUser.php");
        exit();

    }

    else{ //email format is valid

        $emailSearch = "SELECT * FROM users WHERE email = '$emailEncrypted' ";
        $usernameSearch = "SELECT * FROM users WHERE username = '$username' ";
    

        $email_result = mysqli_query($conn, $emailSearch);
        $username_result = mysqli_query($conn, $usernameSearch);
        

        if (mysqli_num_rows($username_result) > 0) {

            $error_message = "Error: Username Already Exists";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: addUser.php");
            exit();

        }

        if (mysqli_num_rows($email_result) > 0) {

            $error_message = "Error: Email Already Exists";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: addUser.php");
            exit();

        }
        
        //email, username, id are all unique

        if(strlen($password)>8){

            $sql = "INSERT INTO users(firstName,lastName,username,email,password,role)
            VALUES ('$firstnameEncrypted','$lastnameEncrypted','$username','$emailEncrypted','$passwordEncrpyted','$role') ";

            mysqli_query($conn, $sql);

            mysqli_close($conn);

            header("Location:uList.php");

            exit();

        }

        else{

            $error_message = "Error: Password should have at least 8 characters.";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: addUser.php");
            exit();

        }


    }

}

else{

    $error_message = "Error: Incomplete Information.";
    session_start();
    $_SESSION['error_message'] = $error_message;
    header("Location: addUser.php");
    exit();

}

?>