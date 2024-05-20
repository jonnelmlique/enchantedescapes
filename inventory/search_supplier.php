<?php
include 'dbconnection.php'; // Include your database connection script
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = $_GET['search'];
$query = "SELECT * FROM productsupplierview WHERE product_name LIKE ?";
$stmt = $con->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $con->error);
}
$searchParam = "%$search%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["supplier_id"] . "</td>";
        echo "<td>" . $row["supplier_name"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["product_name"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";      
        echo "<td>";
        echo "<button class='action-btn edit-btn' onclick='toggle(" . json_encode($row) . ")' style='display: inline-block; vertical-align: middle; margin-right: 5px;'><i class='fas fa-edit' style='color: blue;'></i></button>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13'>No records found</td></tr>";
}

$stmt->close();
$con->close();
?>