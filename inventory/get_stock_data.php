<?php
// Assuming you have a function to connect to your database
include 'connect.php';

// Check if stock ID is provided
if(isset($_GET['id'])) {
    // Get stock ID from the query string
    $stock_id = $_GET['id'];

    // Establish database connection
    $conn = connect();

    // Prepare SQL statement to retrieve stock data
    $stmt = $conn->prepare("SELECT * FROM stock WHERE stock_id = ?");
    $stmt->bind_param("i", $stock_id);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Fetch data as associative array
    $row = $result->fetch_assoc();

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Check if data was found
    if($row) {
        // Convert data to JSON format
        echo json_encode($row);
    } else {
        // Data not found
        echo json_encode(array('error' => 'Stock data not found'));
    }
} else {
    // Stock ID not provided
    echo json_encode(array('error' => 'Stock ID not provided'));
}
?>
