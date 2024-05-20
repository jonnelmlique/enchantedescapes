<?php
// Include database connection
include "db_conn.php";

// Check if department is provided
if(isset($_GET['department'])) {
    $department = $_GET['department'];

    // Query to fetch positions based on selected department
    $sql = "SELECT DISTINCT position FROM employee_info WHERE department = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $department);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch positions and store them in an array
    $positions = [];
    while ($row = $result->fetch_assoc()) {
        $positions[] = $row['position'];
    }

    // Return positions as JSON response
    echo json_encode($positions);
} else {
    // Department not provided
    echo "Department not specified.";
}
?>
