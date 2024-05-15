<?php

include 'db conn.php';
$conn = conn();

define('AES_256_CBC', 'aes-256-cbc');
$key = "my32digitkey12345678901234567890";
$iv = "my16digitIvKey12";

function isPhilPhoneNum($phoneNumber){

    $pattern = '/^(09|\+639)\d{9}$/';
    if(preg_match($pattern, $phoneNumber)){
        return true;
    }
    else{
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $firstname = $_POST['fName'];
    $lastname = $_POST['lName'];
    $contact1 = $_POST['contactOne'];
    $batch = $_POST['batch'];
    $id = $_POST['studentID'];
    $fullName = $lastname.", ".$firstname;

    if(!empty($firstname) && !empty($lastname) && !empty($contact1) && !empty($batch) && !empty($id)){

        $idSearch = "SELECT * FROM students WHERE student_id = '$id' ";
        $id_result = mysqli_query($conn, $idSearch);


        if (mysqli_num_rows($id_result) > 0) { //check if student id is already in database

            $error_message = "Error: Student ID Already Exists";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: addStudent.php");
            exit();

        }



        $contact1Valid = isPhilPhoneNum($contact1);
        $contact1Check = openssl_encrypt($contact1, 'aes-256-cbc', $key, 0, $iv);

        $contactsExists = "SELECT contactNum FROM students WHERE contactNum = '$contact1Check' ";
        $resultss = mysqli_query($conn, $contactsExists);

        if(mysqli_num_rows($resultss)>0){

            $error_message = "Error: Contact Number Already Exists";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: addStudent.php");
            exit();
        }


        if($contact1Valid){

            $contactSearch = "SELECT * FROM students WHERE contactNum = '$contact1' ";
            $searchsResult = mysqli_query($conn, $contactSearch);

            if(mysqli_num_rows($searchsResult) > 0){

                $error_message = "Error: Contact Already Exists";
                session_start();
                $_SESSION['error_message'] = $error_message;
                header("Location: addStudent.php");
                exit();

            }

            $finalc1 = openssl_encrypt($contact1, 'aes-256-cbc', $key, 0, $iv);

            $sql = "INSERT INTO students(student_id,firstName,lastName,fullName,contactNum,yearLevel)
            VALUES ('$id','$firstname','$lastname','$fullName','$finalc1','$batch') ";

            mysqli_query($conn, $sql);

            mysqli_close($conn);

            header("Location:studentsList_admin.php");

            exit();

        }

        else{

            $error_message = "Error: Contact Number Invalid Format.";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: addStudent.php");
            exit();
            
        }



    }

    else{

            $error_message = "Error: Incomplete Information.";
            session_start();
            $_SESSION['error_message'] = $error_message;
            header("Location: addStudent.php");
            exit();

    }


}


?>