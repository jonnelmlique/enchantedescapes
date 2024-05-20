<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product id
    $product_id = $_POST['product_id'];

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

    // Prepare SQL statement to delete the product
    $sql = "DELETE FROM product WHERE product_id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product deleted successfully')</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "')</script>";
    }

    $conn->close();
    echo "<script>setTimeout(function(){ window.location.href = 'inventory_manager.php'; }, 500);</script>";
    exit();
}
?>
