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
    $quantity = $_POST['quantity'];
    $qtyperitem = $_POST['qtyperitem'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $expiry = $_POST['expiry'];
    
    // Calculate the total
    $total = $price * $qtyperitem;

    // Check if the product name already exists
    $check_product_sql = "SELECT * FROM product WHERE product_name = '$productname'";
    $check_product_result = $conn->query($check_product_sql);
    if ($check_product_result->num_rows > 0) {
        // Product name already exists, reject insertion
        echo "<script>alert('Error: Product name already exists.')</script>";
    } else {
        // Product name does not exist, proceed with insertion
        // Construct SQL query for product table
        $sql_product = "INSERT INTO product (product_name, supplier, category, type) 
        VALUES ('$productname', '$supplier', '$category', '$type')";
        
        // Execute query for product table
        if ($conn->query($sql_product) === TRUE) {
            // Get the auto-generated ID of the inserted product
            $product_id = $conn->insert_id;

            // Construct SQL query for supplier table
            $sql_supplier = "INSERT INTO supplier (supplier_name, product_name)
            VALUES('$supplier', '$productname')";
            
            // Execute query for supplier table
            if ($conn->query($sql_supplier) === TRUE) {
                $supplier_id = $conn->insert_id;

                // Construct SQL query for stock table
                $sql_stock = "INSERT INTO stock (product_id, supplier_id, supplier, product_name, category, type, expiry_date, quantity, quantity_per_item, price, date, time, total) 
                VALUES ('$product_id', '$supplier_id', '$supplier', '$productname', '$category', '$type', '$expiry', '$quantity', '$qtyperitem', '$price', '$date', '$time', '$total')";
                
                // Execute query for stock table
                if ($conn->query($sql_stock) === TRUE){
                    echo "<script>alert('Data inserted successfully')</script>";
                } else {
                    echo "<script>alert('Error: " . $sql_stock . "<br>" . $conn->error . "')</script>";
                }
            } else {
                echo "<script>alert('Error: " . $sql_supplier. "<br>" . $conn->error . "')</script>";
            }
        } else {
            echo "<script>alert('Error: " . $sql_product . "<br>" . $conn->error . "')</script>";
        }
    }

    // Close connection
    $conn->close();

    // Redirect back to inventory_manager.php after 2 seconds
    echo "<script>setTimeout(function(){ window.location.href = 'inventory_manager.php'; }, 500);</script>";
    exit();
}
?>
