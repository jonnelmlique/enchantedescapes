<?php
include '../src/config/config.php';

$searchText = isset($_POST['search']) ? $_POST['search'] : '';

$sql = "SELECT * FROM hrusers";
if (!empty($searchText)) {
    $sql .= " WHERE name LIKE '%$searchText%' OR userrole LIKE '%$searchText%' OR status LIKE '%$searchText%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['hruserid'] . "</td>";
        echo "<td class='fw-bold'>" . $row['name'] . "</td>";
        echo "<td>" . $row['userrole'] . "</td>";
        echo "<td class='text-" . ($row['status'] == 'Active' ? 'success' : 'danger') . " text-uppercase'>" . $row['status'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}
$conn->close();
?>