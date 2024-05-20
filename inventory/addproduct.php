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
if(isset($_POST['submit'])){
    // Retrieve form data
    $supplier = $_POST['supplier'];
    $productname = $_POST['productname'];
    $type = $_POST['type'];
    $category = $_POST['category'];

    // Construct SQL query for product table
    $sql_product = "INSERT INTO product (supplier, product_name, category, type) 
    VALUES ('$supplier', '$productname', '$category', '$type')";
    
    // Execute query for product table
    if ($conn->query($sql_product) === TRUE) {
        // Get the auto-generated ID of the inserted product
        $product_id = $conn->insert_id;

        // Construct SQL query for stock table using the product ID
        $sql_stock = "INSERT INTO stock (product_id, supplier, product_name, category, type, expiry_date, quantity, quantity_per_item, price, date, time, total) 
        VALUES ('$product_id', '$supplier', '$productname', '$category', '$type', '$expiry', '$quantity', '$qtyperitem', '$price', '$datepurchased', '$timepurchased', '$total')";
        
        // Execute query for stock table
        if ($conn->query($sql_stock) === TRUE) {
            echo "<script>alert('Data inserted successfully')</script>";
        } else {
            echo "<script>alert('Error: " . $sql_stock . "<br>" . $conn->error . "')</script>";
        }
    } else {
        echo "<script>alert('Error: " . $sql_product . "<br>" . $conn->error . "')</script>";
    }

    // Close connection
    $conn->close();

    // Redirect back to inventory_manager.php after 2 seconds
    echo "<script>setTimeout(function(){ window.location.href = 'manager.php'; }, 500);</script>";
    exit();
}
?>
