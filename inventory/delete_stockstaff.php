<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve stock id
    $stock_id = $_POST['stock_id'];

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

    // Begin transaction
    $conn->begin_transaction();

    // Prepare SQL statement to fetch product_id and supplier_id associated with the stock entry
    $sql_fetch_ids = "SELECT product_id, supplier_id FROM stock WHERE stock_id='$stock_id'";
    $result = $conn->query($sql_fetch_ids);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_id = $row['product_id'];
        $supplier_id = $row['supplier_id'];

        // Prepare SQL statement to delete from stock table
        $sql_stock = "DELETE FROM stock WHERE stock_id='$stock_id'";

        // Execute deletion query for stock table
        if ($conn->query($sql_stock) === TRUE) {
            // Prepare SQL statement to delete from product table
            $sql_product = "DELETE FROM product WHERE product_id='$product_id'";
            // Execute deletion query for product table
            if (!$conn->query($sql_product)) {
                $conn->rollback();
                echo "<script>alert('Error deleting data from product table: " . $conn->error . "')</script>";
            }

            // Prepare SQL statement to delete from supplier table
            $sql_supplier = "DELETE FROM supplier WHERE supplier_id='$supplier_id'";
            // Execute deletion query for supplier table
            if (!$conn->query($sql_supplier)) {
                $conn->rollback();
                echo "<script>alert('Error deleting data from supplier table: " . $conn->error . "')</script>";
            }

            // Commit transaction if all queries succeed
            $conn->commit();
            echo "<script>alert('Data deleted successfully')</script>";
        } else {
            echo "<script>alert('Error deleting data from stock table: " . $conn->error . "')</script>";
        }
    } else {
        echo "<script>alert('Stock entry not found')</script>";
    }

    $conn->close();
    echo "<script>setTimeout(function(){ window.location.href = 'staff.php'; }, 500);</script>";
    exit();
}
?>
