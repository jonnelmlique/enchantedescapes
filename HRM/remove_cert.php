<?php
include "db_conn.php";

// Check if ID and table name are provided in the URL parameters
if (isset($_GET['id']) && isset($_GET['table'])) {
    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $table = mysqli_real_escape_string($conn, $_GET['table']);

    // Construct the SQL query to delete the record
    $sql = "DELETE FROM $table WHERE Employee_ID = $id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Deletion successful
        $msg = "Record deleted successfully";
        header("Location: certificate.php?msg=$msg"); // Redirect back to the index page with a success message
        exit();
    } else {
        // Error occurred during deletion
        $msg = "Error deleting record: " . mysqli_error($conn);
        header("Location: certificate.php?msg=$msg"); // Redirect back to the index page with an error message
        exit();
    }
} else {
    // ID or table name not provided in the URL parameters
    $msg = "ID or table name not provided";
    header("Location: certificate.php?msg=$msg"); // Redirect back to the index page with an error message
    exit();
}
?>
