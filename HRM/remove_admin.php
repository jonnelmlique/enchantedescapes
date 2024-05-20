<?php
// Include database connection
include "db_conn.php";

// Check if ID is set and numeric
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Escape the ID to prevent SQL injection
    $adminID = mysqli_real_escape_string($conn, $_GET['id']);
    
    // SQL to delete record
    $sql = "DELETE FROM admin_tbl WHERE adminID = $adminID";
    
    if(mysqli_query($conn, $sql)) {
        // If deletion is successful, redirect to the admin page with a success message
        header("Location: admin-list.php?msg=Admin record deleted successfully");
        exit();
    } else {
        // If deletion fails, redirect to the admin page with an error message
        header("Location: admin-list.php?msg=Error deleting admin record");
        exit();
    }
} else {
    // If ID is not set or not numeric, redirect to the admin page with an error message
    header("Location: admin.php?msg=Invalid admin ID");
    exit();
}
?>
