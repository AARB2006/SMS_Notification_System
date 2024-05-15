<?php
include 'db conn.php';
$conn = conn();

// Step 2: Purge the Table
$sql_delete = "SELECT * FROM messages";
$result = $conn->query($sql_delete);

// Step 3: Export Table Data to CSV


$timestamp = date("Ymd_His");
$csv_file = "message_history_backup_$timestamp.csv";
$fp = fopen($csv_file, 'w');
// Write CSV header
$header = array('msg_id', 'author', 'msgbody', 'recipient', 'date_time_sent');
fputcsv($fp, $header);

// Write CSV data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($fp, $row);
    }
    
} else {
    echo '<script>';
    echo 'alert("No Data to be Archived.");';
    echo 'window.location.href = "msgHistory.php";';
    echo '</script>';
     $conn->close();
     exit();
}

// Close CSV file pointer
fclose($fp);

$sql_delete = "DELETE FROM messages";
if ($conn->query($sql_delete) === TRUE) {
    echo '<script>';
echo 'alert("Data successfully archived..");';
echo 'window.location.href = "msgHistory.php";';
echo '</script>';
     $conn->close();
     exit();
} 
// Step 4: Close database connection


// Step 5: Store the Document and Document Archiving
// Store the CSV file in your desired archive location with appropriate metadata.
?>