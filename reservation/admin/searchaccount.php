<?php
include '../src/config/config.php';

$searchText = isset($_POST['search']) ? strtolower($_POST['search']) : '';

$sql = "SELECT * FROM employee_info";
if (!empty($searchText)) {
    $searchText = '%' . $conn->real_escape_string($searchText) . '%';
    $sql .= " WHERE LOWER(Name) LIKE LOWER('$searchText') OR LOWER(position) LIKE LOWER('$searchText') OR LOWER(status) LIKE LOWER('$searchText')";
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        $imageData = $row['img'];
        if ($imageData !== null) {
            $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
            echo "<td><img src='$imageSrc' alt='User Image' width='50' height='50'></td>";
        } else {
            echo "<td>No Image</td>";
        }
        echo "<td class='fw-bold'>" . $row['Name'] . "</td>";
        echo "<td>" . $row['Gender'] . "</td>";
        echo "<td>" . $row['position'] . "</td>";
        echo "<td>" . $row['Department'] . "</td>";
        echo "<td class='text-" . ($row['Status'] == 'Active' ? 'success' : 'danger') . " text-uppercase'>" . $row['Status'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No users found</td></tr>";
}
$conn->close();

?>