<?php

include 'db conn.php';
$conn = conn();

define('AES_256_CBC', 'aes-256-cbc');
$key = "my32digitkey12345678901234567890";
$iv = "my16digitIvKey12";

function isPhilPhoneNum($phoneNumber) {
    $pattern = '/^(09|\+639)\d{9}$/';
    return preg_match($pattern, $phoneNumber);
}

function displayError($errorMessage) {
    echo "<script>alert('$errorMessage'); window.location.replace('addStudentbyExcel.php');</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csvFile"])) {
    $file = $_FILES["csvFile"]["tmp_name"];

    if (($handle = fopen($file, "r")) !== FALSE) {
        $headerSkipped = false; // Flag to skip header row
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Skip header row
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            // Extract data from each row
            $firstName = mysqli_real_escape_string($conn, $data[0]);
            $lastName = mysqli_real_escape_string($conn, $data[1]);
            $contactNumber = mysqli_real_escape_string($conn, $data[2]);
            $schoolYear = mysqli_real_escape_string($conn, $data[3]);
            $schoolIDNumber = mysqli_real_escape_string($conn, $data[4]);
            $fullName = $lastName . ", " . $firstName;

            $contactValid = isPhilPhoneNum($contactNumber);
            $contact1Check = openssl_encrypt($contactNumber, 'aes-256-cbc', $key, 0, $iv);
 
            $idSearch = "SELECT * FROM students WHERE student_id = '$schoolIDNumber' ";
            $id_result = mysqli_query($conn, $idSearch);

            if (mysqli_num_rows($id_result) > 0) { // Check if student id already exists
                displayError("Error: Student ID Already Exists - $schoolIDNumber");
            }

            if (isPhilPhoneNum($contactNumber)) {
                $contactsExists = "SELECT contactNum FROM students WHERE contactNum = '$contact1Check' ";
                $results = mysqli_query($conn, $contactsExists);

                if (mysqli_num_rows($results) > 0) {
                    displayError("Error: Phone Number Already in System - $contactNumber");
                }

                $sql = "INSERT INTO students(student_id,firstName,lastName,fullName,contactNum,yearLevel)
                VALUES ('$schoolIDNumber','$firstName','$lastName','$fullName','$contact1Check','$schoolYear') ";
    
                mysqli_query($conn, $sql);
            } else {
                displayError("Error: Invalid phone number - $contactNumber");
            }
        }
        fclose($handle);

        mysqli_close($conn);

        header("Location:studentsList_admin.php");
        exit();
    } else {
        displayError("Error: Failed to open CSV file.");
    }
}
?>
