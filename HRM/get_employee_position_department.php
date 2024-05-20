<?php
// Include database connection or any necessary files
include "sche_conn.php";

// Check if employee_id is provided in the GET request
if (isset($_GET['Employee_ID'])) {
  // Retrieve the employee ID from the GET request
  $employeeId = $_GET['Employee_ID'];

  // Prepare and execute the query to retrieve the employee name
  $sql = "SELECT position, Department FROM employee_info WHERE Employee_ID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $employeeId);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if any rows are returned
  if ($result->num_rows > 0) {
    // Fetch the row and retrieve the employee name
    $row = $result->fetch_assoc();
    $employeePosDept = $row['position'] . " in " . $row['Department'];
    // Output the employee name
    echo $employeePosDept;
  } else {
    // If no rows are returned, output an error message or an empty string
    echo "Employee not found";
  }
} else {
  // If employee_id is not provided in the GET request, output an error message or an empty string
  echo "Employee ID not provided";
}

// Close database connection if needed
$conn->close();