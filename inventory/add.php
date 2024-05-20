<?php

  $servername = "localhost";
    $username = "sbit3i";
    $password = "!SIA102Escapes";
    $dbname = "enchantedescapes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])){
    $supplier = $_POST['supplier'];
    $productname = $_POST['productname'];
    $quantity = $_POST['quantity'];
    $qtyperitem = $_POST['qtyperitem'];
    $price = $_POST['price'];
    $total = $_POST['total'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $datepurchased = date('Y-m-d', strtotime($_POST['date-purchased']));
    $expiry = date('Y-m-d', strtotime($_POST['expiry']));
    $timepurchased = $_POST['time-purchased'];

    $query = mysqli_query($conn, "Insert into product (supplier, product_name, category, type, expiry_date, quantity, quantity_per_item, price, date, time,  total) 
                                            Values ('$supplier', '$productname', '$category', '$type', '$expiry', '$quantity', '$qtyperitem', '$price','$datepurchased','$timepurchased', '$total')");
    if($query){
        echo "<script>alert('data inserted successfully')</script>";
    }else{
        echo "<script>alert('data inserted unsuccessful')</script>";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="margin: 5px auto;">
        <form method="POST">
            
        <label for="product-name" class="label-product">Product Name</label>
                    <input type="text" name="productname" class="content2-productname">

                    <label for="category" class="lbl-category">Category</label>
                    <select name="category" id="" class="select-category">
                        <option value="beverages">Beverages</option>
                        <option value="alcohol">Alcohol</option>
                    </select>
                    
                    <label for="type" class="lbltype">Type</label>
                    <select name="type" id="" class="select-type">
                        <option value="Canned Drinks">Canned Drinks</option>
                        <option value="Bottled Alcohol">Bottled Alcohol</option>
                    </select>
    
                    <label for="expiry" class="lblexpiry">Expiry Date</label>
                    <input type="date" name="expiry" class="select-expiry">
                    
                    <label for="quantity" class="lblqty">Quantity</label>
                    <input type="text" name="quantity" class="input-qty">
    
                    <label for="qtyperitem" class="lblqtyperitem">Quantity per Item</label>
                    <input type="text" name="qtyperitem" class="input-qtyperitem">
                    
                    <label for="price" class="lblprice">Price</label>
                    <input type="text" name="price" class="input-price">
    
                    <label for="date-purchased" class="lbldatepurchased">Date Purchased</label>
                    <input type="date" name="date-purchased" class="input-datepurchased">
    
                    <label for="time-purchased" class="lbltimepurchased">Time Purchased</label>
                    <input type="time" name="time-purchased" class="input-timepurchased">
    
                    <label for="total" class="lbltotal">Total</label>
                    <input type="text" name="total" class="input-total">
    
                    <label for="supplier" class="lblsupplier">Supplier</label>
                    <input type="text" name="supplier" class="input-supplier">
                    
                    <button type="submit" name="submit" class="add-btn">Add Product</button>
        </form>
    </div>
</body>
</html>