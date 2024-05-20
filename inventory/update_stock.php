<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_id = $_POST['product_id'];
    $stock_id = $_POST['stock_id'];
    $supplier_id = $_POST['supplier_id'];
    $supplier = $_POST['supplier'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category_stock'];
    $type = $_POST['type_stock'];
    $price = $_POST['price'];
    $qtyperitem = $_POST['qtyperitem']; 
    $date = $_POST['date'];
    $time = $_POST['time'];
    $total = $price * $qtyperitem; 
    $quantity = $_POST['quantity'];
    $expiry = $_POST['expiry'];





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

    // Prepare SQL statement to update the product
    $sql_product = "UPDATE product SET 
            supplier='$supplier',
            product_name='$product_name',
            category='$category', 
            type='$type'  
            WHERE product_id='$product_id'";

    // Prepare SQL statement to update the supplier table based on product_name
    $sql_update_supplier = "UPDATE supplier SET 
                            supplier_name = '$supplier', 
                            product_name = '$product_name'
                            WHERE supplier_id = '$supplier_id '";

    // Execute SQL statements for product and supplier updates
    if ($conn->query($sql_product) === TRUE && $conn->query($sql_update_supplier) === TRUE) {
        // Product and supplier data updated successfully
    } else {
        echo "<script>alert('Error: " . $conn->error . "')</script>";
    }


    $sql_stock = "UPDATE stock SET 
                  supplier='$supplier',
                  product_name='$product_name',
                  category='$category', 
                  type='$type',
                  price = '$price',
                  quantity = '$quantity',
                  quantity_per_item = '$qtyperitem',
                  total = '$total',
                  expiry_date = '$expiry',
                  date ='$date',
                  time = '$time',
                  total = '$total'
                  WHERE product_id='$product_id'";

    // Execute SQL statement for updating stock
    if ($conn->query($sql_stock) === TRUE) {
        // Stock data updated successfully
    } else {
        echo "<script>alert('Error: " . $conn->error . "')</script>";
    }

    $conn->close();
    echo "<script>alert('Stock updated successfully')</script>";
    echo "<script>setTimeout(function(){ window.location.href = 'inventory_manager.php'; }, 500);</script>";
    exit();
}
?>
