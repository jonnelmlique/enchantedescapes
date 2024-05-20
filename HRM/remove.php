<?php
include 'db_conn.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id']) && isset($_GET['header']) && isset($_GET['table'])) {
  // Get the 'id' parameter from the URL
  $id = $_GET['id'];
  $header = $_GET['header'];
  $table = $_GET['table'];

  // Prepare the SQL statement

  $stmt = "";
  if ($table === "schedule") {
    $stmt = mysqli_prepare($conn, "DELETE FROM " . $table . " WHERE schedule_id = ?");
  } else {
    $stmt = mysqli_prepare($conn, "DELETE FROM " . $table . " WHERE id = ?");
  }

  // Bind the parameter
  mysqli_stmt_bind_param($stmt, "i", $id);

  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Close the statement
  mysqli_stmt_close($stmt);

  // Redirect the user to the employeeinfo.php page
  header('location:' . $header . '');
} else {
  // If 'id' parameter is not set in the URL, display an error message
  echo "Cannot delete this row. The 'id', 'header', or 'table' is not set.";
}