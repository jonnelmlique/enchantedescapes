<?php
include 'dbconnection.php'; // Include your database connection script
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = $_GET['search'];
$query = "SELECT * FROM product WHERE product_name LIKE ?";
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
        echo "<tr data-category='" . $row["category"] . "'>";
            
        // Echo the rest of the table row's content
        echo "<td>" . $row["product_id"] . "</td>";
        echo "<td>" . $row["supplier"] . "</td>";
        echo "<td>" . $row["product_name"] . "</td>";
        echo "<td>" . $row["category"] . "</td>";
        echo "<td>" . $row["type"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No records found</td></tr>";
}

$stmt->close();
$con->close();
?>