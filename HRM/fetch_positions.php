<?php
include "db_conn.php";

if (isset($_GET['department'])) {
    $department = $_GET['department'];

    // Fetch positions based on selected department
    $sql = "SELECT position FROM department WHERE department_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $department);
    $stmt->execute();
    $result = $stmt->get_result();

    $positions = [];
    while ($row = $result->fetch_assoc()) {
        $positions[] = $row['position'];
    }

    // Return positions as JSON
    echo json_encode($positions);
} else {
    echo json_encode([]);
}
?>
