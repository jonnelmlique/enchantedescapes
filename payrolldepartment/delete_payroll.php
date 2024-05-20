<?php
// Check if the payroll ID is provided in the request
if(isset($_GET['id'])) {
    // Include database connection
    include('db_connection.php');

    // Prepare SQL statement to delete the payroll record
    $payroll_id = $_GET['id'];
    $sql = "DELETE FROM payrolltbl WHERE payrollid = $payroll_id";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Display a success alert message
        echo "<script>alert('Payroll record deleted successfully');</script>";
    } else {
        // Display an error alert message if deletion fails
        echo "<script>alert('Error deleting payroll record: " . $conn->error . "');</script>";
    }

    // Close database connection
    $conn->close();
} else {
    // Redirect to the payroll list page if payroll ID is not provided
    echo "<script>alert('Payroll ID not provided');</script>";
}

// Redirect back to payroll.php
echo "<script>window.location.href = 'payroll.php';</script>";
?>
