<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $supplier_id = $_POST['supplier_id'];
    $supplier_name = $_POST['supplier_name'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $phonenumber = $_POST['phone_number']; // Added semicolon here

    // Create connection
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

    $sql_supplier = "UPDATE supplier SET 
                  supplier_name='$supplier_name',
                  status='$status',
                  phone_number='$phonenumber',
                  address='$address'
                  WHERE supplier_id='$supplier_id'";

    // Execute SQL statement for updating stock
    if ($conn->query($sql_supplier) === TRUE) {
        echo "<script>alert('Supplier updated successfully')</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "')</script>";
    }

    $conn->close();
    echo "<script>setTimeout(function(){ window.location.href = 'inventory_manager.php'; }, 500);</script>";
    exit();
}
?>
