<?php
include '../src/config/config.php';

$searchText = isset($_POST['search']) ? strtolower($_POST['search']) : '';

$sql = "SELECT * FROM employee_info";
if (!empty($searchText)) {
    $searchText = '%' . $searchText . '%';
    $sql .= " WHERE LOWER(Name) LIKE ? OR LOWER(position) LIKE ? OR LOWER(status) LIKE ?";
}

$stmt = $conn->prepare($sql);

if (!empty($searchText)) {
    $stmt->bind_param('sss', $searchText, $searchText, $searchText);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='fw-bold'>" . htmlspecialchars($row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Gender']) . "</td>";
        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Department']) . "</td>";
        echo "<td class='text-" . ($row['Status'] == 'Active' ? 'success' : 'danger') . " text-uppercase'>" . htmlspecialchars($row['Status']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No users found</td></tr>";
}

$stmt->close();
$conn->close();
?>
