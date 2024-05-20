<?php
session_start();
include "db_conn.php"; // Make sure to include your database connection file

$id = null;

if (isset($_POST['submit'])) {
    $id = $_POST['Department_id']; // Assuming Department_id is the name of the input field
    
    $Department_name = $_POST['Department_name'];
   
    // SQL UPDATE statement should specify the table name after UPDATE
    $sql = "UPDATE `Department` SET `Department_name`='$Department_name' WHERE Department_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: department.php?msg=Data updated successfully");
        exit(); // Always exit after redirecting to prevent further execution
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>
<?php
session_start();
include "db_conn.php"; // Make sure to include your database connection file

$id = null;

if (isset($_POST['submit'])) {
    $id = $_POST['Department_id']; // Assuming Department_id is the name of the input field
    
    $Department_name = $_POST['Department_name'];
   
    // SQL UPDATE statement should specify the table name after UPDATE
    $sql = "UPDATE `Department` SET `Department_name`='$Department_name' WHERE Department_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: department.php?msg=Data updated successfully");
        exit(); // Always exit after redirecting to prevent further execution
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>
