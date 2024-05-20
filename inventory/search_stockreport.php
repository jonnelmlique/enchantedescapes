<?php
include 'dbconnection.php'; // Include your database connection script
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = $_GET['search'];
$query = "SELECT * FROM stockcombineddetails WHERE product_name LIKE ?";
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
        echo "<td>" . $row["product_id"] . "</td>";
        echo "<td>" . $row["supplier_id"] . "</td>";
        echo "<td>" . $row["product_name"] . "</td>";
        echo "<td>" . $row["category"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>" . $row["quantity_per_item"] . "</td>";
        if ($row["critical_stock"] == "Yes") {
            echo "<td style='color: red;'>" . $row["critical_stock"] . "</td>";
        } else {
            echo "<td style='color: green;'>" . $row["critical_stock"] . "</td>";
        }
        echo "<td>" . $row["date"] . "</td>";
        // Insert the following two lines to handle date and time
        echo "<td>" . $row["time"] . "</td>";
        echo "<td>" . $row["total"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13'>No records found</td></tr>";
}

$stmt->close();
$con->close();
?>