<?php

include 'db conn.php';
$conn = conn();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_POST['deleteBtn'])){

        if (isset($_POST['selected_students']) && is_array($_POST['selected_students'])){
            foreach($_POST['selected_students'] as $students){

                $sql = "SELECT * FROM students WHERE fullName = '$students' ";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
                        $delSQL = "DELETE FROM students WHERE fullName = '$students'";
                        mysqli_query($conn, $delSQL);
                    }
                }

                

            }
            header("Location:studentsList_admin.php");
            exit();
        }
    }

    if(isset($_POST['sendBtn'])){

        $selectedItems = isset($_POST['selected_students']) ? $_POST['selected_students'] : [];

        session_start();
        $_SESSION['selecselected_students'] = $selectedItems;
    }
}
?>