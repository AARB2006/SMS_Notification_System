<?php
include 'db conn.php';
$conn = conn();
session_start();
$author = $_SESSION['accountName'];

define('AES_256_CBC', 'aes-256-cbc');

$key = "my32digitkey12345678901234567890";
$iv = "my16digitIvKey12";

$serialPort = "COM8"; // Change this to your specific COM port

function sendSMS($ser, $toNumber, $message) {
    // Set SMS mode to text
    fwrite($ser, "AT+CMGF=1\r");
    sleep(1);

    // Convert $toNumber to string
    $toNumber = strval($toNumber); 
        
    fwrite($ser, "AT+CMGS=\"" . $toNumber . "\"\r");
    sleep(1);
    fwrite($ser, $message . chr(26)); // Use chr(26) for Ctrl+Z
    sleep(1);

    // If SMS sending is successful
    return true;
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 'true') {

    $displayName = $_SESSION['accountName'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["send"])) {
        if (isset($_POST['selected_students']) && is_array($_POST['selected_students'])) {
            if (isset($_POST['msgarea']) && !empty($_POST['msgarea'])) {
                $message = $_POST['msgarea'];

                foreach ($_POST['selected_students'] as $students) {
                    $sql = "SELECT * FROM students WHERE fullName = '$students' ";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $contactNum = openssl_decrypt($row['contactNum'], 'aes-256-cbc', $key, 0, $iv);
                            $fullname = $row['fullName'];

                            $ser = fopen($serialPort, "w");
                            sleep(2); // Allow time for the SIM800C to initialize
                            if ($ser) {
                                if (sendSMS($ser, $contactNum, $message)) {
                                    
                                    $sql2 = "INSERT INTO messages (author, msgbody, recipient) VALUES ('$author', '$message', '$fullname')";
                                    mysqli_query($conn, $sql2);
                                    fclose($ser);
                                } else {
                                    echo "<p>Error sending SMS to: $students</p>";
                                }
                            } else {
                                echo "Error: Unable to open serial port.";
                            }
                        }
                    }
                }
                
            }
        }
    }
} 
$message = "Messages have been sent!";

// Generate JavaScript code for the alert and redirection
$js_code = "<script>
    // Display the alert message
    alert('$message');

    // Redirect to the main page when OK is clicked
    window.history.back();
</script>";

// Output the JavaScript code to the browser
echo $js_code;
$conn->close();
exit();
?>

