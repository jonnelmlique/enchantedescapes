<?php
require 'db_connection.php'; // Include database connection

function getEmployeeDetails($employeeId) {
  $conn = connectDatabase();

  $sql = "SELECT * FROM employees WHERE employee_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$employeeId]);
  $employeeData = $stmt->fetch(PDO::FETCH_ASSOC);

  return $employeeData;
}
