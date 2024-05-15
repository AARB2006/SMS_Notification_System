<?php
include 'db conn.php';
$conn = conn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV File to Register Student/s</title>
</head>
<body>
    <div class ="container">
    <h1>Upload CSV File to Register Student/s</h1>
    <form id="csvForm" action="addCSVCheck.php" method="post" enctype="multipart/form-data">
        <input type="file" id="csvFile" name="csvFile" accept=".csv"><br><br>
        <button type="submit">Upload</button>
        <a href="studentsList_admin.php" class="back-button">Back</a>
    </form>
</div>
    <script>
        document.getElementById('csvForm').addEventListener('submit', function(event) {
            var fileInput = document.getElementById('csvFile');
            var filePath = fileInput.value;
            var allowedExtensions = /(\.csv)$/i;
            
            if (!allowedExtensions.exec(filePath)) {
                alert('Please select a file with .csv extension.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>

<style>
    body, html{
        height: 100%;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: Arial, Helvetica, sans-serif;
  color: white;
    }
    .container{
        width: 100%;
  padding: 50px;
  background-color: #406cdb;
  border-radius: 5px;
    }


        #csvForm {
            display: flex; /* Make the container a flexbox */
  justify-content: center;
  padding-top: 20px;
        }

        #csvFile {
            font-size: 20px;
        }


        button{
            padding: 12px;
            font-size: 18px;
            background-color:#406cdb;
    border: none;
    text-decoration: underline;
    color: white;
        }

        .back-button {
            font-size: 18px;
            padding: 12px;
            background-color:#406cdb;
    border: none;
    color: white;
        }
        button:hover {
  background-color: #485996;
  color: white;
}
.back-button:hover {
  background-color: #485996;
  color: white;
}

        input[type=file] {
 
 width: 60%;
 background-color:  #406cdb;
 font-size: 20px;
 color: white;
 
}
</style>