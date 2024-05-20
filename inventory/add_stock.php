<?php
  $servername = "localhost";
    $username = "sbit3i";
    $password = "!SIA102Escapes";
    $dbname = "enchantedescapes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if(isset($_POST['stocksubmit'])){
    // Retrieve form data
    $supplier = $_POST['supplier'];
    $productname = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $qtyperitem = $_POST['qtyperitem'];
    $price = $_POST['price'];
    $total = $_POST['total'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $datepurchased = $_POST['date-purchased']; // No need to convert, it's already in the correct format
    $expiry = $_POST['expiry']; // No need to convert, it's already in the correct format
    $timepurchased = $_POST['time-purchased'];

    // Construct SQL query
    $sql = "INSERT INTO stock (supplier, product_name, category, type, expiry_date, quantity, quantity_per_item, price, date, time, total) 
            VALUES ('$supplier', '$productname', '$category', '$type', '$expiry', '$quantity', '$qtyperitem', '$price', '$datepurchased', '$timepurchased', '$total')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data inserted successfully')</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "')</script>";
    }
    
    // Close connection
    $conn->close();

    // Redirect back to inventory_manager.php after 2 seconds
    echo "<script>setTimeout(function(){ window.location.href = 'inventory_manager.php'; }, 500);</script>";
    exit();
}
?>
