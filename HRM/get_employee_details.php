<?php
// Include database connection or any necessary files
include "sche_conn.php";

// Check if employee_id is provided in the GET request
if (isset($_GET['Employee_ID'])) {
  // Retrieve the employee ID from the GET request
  $employeeId = $_GET['Employee_ID'];

  // Prepare and execute the query to retrieve the employee details
  $sql = "SELECT * FROM employee_info WHERE Employee_ID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $employeeId);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if any rows are returned
  if ($result->num_rows > 0) {
    // Fetch the row and retrieve the employee details
    $row = $result->fetch_assoc();

    // Output the employee details as JSON
    echo json_encode($row);
  } else {
    // If no rows are returned, output an error message or an empty object
    echo json_encode(array("error" => "Employee not found"));
  }
} else {
  // If employee_id is not provided in the GET request, output an error message or an empty object
  echo json_encode(array("error" => "Employee ID not provided"));
}

// Close database connection if needed
$conn->close();
?>