<?php
include 'dbconnection.php'; // Include your database connection script
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = $_GET['search'];
$query = "SELECT * FROM stock WHERE product_name LIKE ?";
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
                    echo "<td>" . $row["stock_id"] . "</td>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["supplier"] . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>" . $row["type"] . "</td>";
                    echo "<td>" . $row["expiry_date"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    echo "<td>" . $row["quantity_per_item"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    // Insert the following two lines to handle date and time
                    echo "<td>" . $row["date"] . "</td>";
                    echo "<td>" . $row["time"] . "</td>";
                    echo "<td>" . $row["total"] . "</td>";
                    // Add edit and delete icons with appropriate links or actions
                    echo "<td>";
                    // PHP Code for Content 3 (Inventory Manager)
                    echo "<button class='action-btn edit-btn' onclick='togglePopupForm(" . json_encode($row) . ")' style='display: inline-block; vertical-align: middle; margin-right: 5px;'><i class='fas fa-edit' style='color: blue;'></i></button>";
                    echo "<button class='action-btn delete-btn' onclick='deleteStock(" . $row["stock_id"] . ")'><i class='fas fa-trash-alt' style='color: red;'></i></button>";
                    echo "</td>";
                    echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13'>No records found</td></tr>";
}

$stmt->close();
$con->close();
?>