<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enchanted Escapes Hotel</title>
    <link rel="website icon" type="png" href="images/logo.png">
    <link rel="stylesheet" href="im.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
</head>
<body>
<?php
session_start();

if (!isset($_SESSION['firstname'])) {
    header("Location: login.html");
    exit();
}

if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("Location: login.html");
    exit();
}

  $servername = "localhost";
    $username = "sbit3i";
    $password = "!SIA102Escapes";
    $dbname = "enchantedescapes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$countproduct = "SELECT COUNT(*) AS totalproduct FROM product";
$resultcountproduct = $conn->query($countproduct);

$countstock = "SELECT COUNT(*) AS totalstock FROM stock";
$resultcountstock = $conn->query($countstock);

?>

    <div class="navbar">
        <img src="images/logo2.png" class="logo2" alt="">
        <a href="#" class="nav-link dashboard active" data-index="1"><img src="images/dashboard.png" class="icondashboard"> Dashboard</a>
        <a href="#" class="nav-link manage-product" data-index="2"><img src="images/manageproduct.png" class="iconmanageproduct"> Manage Product</a>
        <a href="#" class="nav-link manage-stocks" data-index="3"><img src="images/managestocks.png" class="iconmanagestocks"> Manage Stocks</a>
        <a href="#" class="nav-link stock-reports" data-index="4"><img src="images/reports.png" class="iconstockreports"> Stock Reports</a>
        <a href="#" class="nav-link suppliers" data-index="5"><img src="images/suppliers.png" class="iconsuppliers">Suppliers</a>
        <a href="#" class="nav-link sales-reports" data-index="6"><img src="images/reports.png" class="iconsalesreports">Sales Reports</a>
    </div>

    <div class="upper-div">
    <span class="hamburger">&#9776;</span>
    <p id="datetime" class="datetime"></p>
    <p class="name-admin"> <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></p>
    <form id="logoutForm" action="login.html" method="post" class="form2">
    <button type="button" class="logout-button" onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i></button>
</form> 
    </div>

    <div id="content1" class="content" style="display: block;">
        <div class="for-img">
            <div class="stocks-box"> <img src="images/managestocks.png"> <p><?php if($resultcountstock->num_rows > 0){
                    $row = $resultcountstock->fetch_assoc();
                    echo "<p>" . $row["totalstock"] . "</p>";
            }else{
                echo "<p>" . "0" . "</p>";
            } ?> <span class="stock">Stocks</span></div>
            <div class="products-box"><img src="images/manageproduct.png"> <p><?php if($resultcountproduct->num_rows > 0){
                $row = $resultcountproduct->fetch_assoc();
                echo "<p>" . $row["totalproduct"] . "</p>";
        }else{
            echo "<p>" . "0" . "</p>";
        } ?> <span class="products" >Products</span></div>
            <div class="critical-box"><img src="images/critical.png"> <p> 11 </p> <span class="critical">Critical Stocks</span></div>
            <div class="suppliers-box"><img src="images/suppliers.png"> <p> 11 </p><span class="suppliers">Suppliers</span></div>
            <div class="totalsales-box"><img src="images/reports.png"> <p> 11 </p><span class="sales">Total Sales</span> </div>
            <div class="totalpurchase-box"><img src="images/checklist.png"> <p> 11 </p><span class="purchase">Total Purchase</span> </div>
            </div>
    
            <div class="latest-sales">
                <p> Latest Sales </p> 
                <div class="border-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Date</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table content will go here -->
                        </tbody>
                    </table>
                </div>
            </div>
    
            <div class="history-purchased">
                <p> History Purchased </p> 
                <div class="border-table2">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Date</th>
                                <th>Total </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table content will go here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
    
    </div>

    <div id="content2" class="content">
        <h1>List of Products</h1>
        <div class="popup-form-container" id="popupFormContainer">
            <div class="popup-form">
                <span class="close-btn" onclick="closePopupForm()">&times;</span>
                <h2>Add Product</h2>
    
                <form id="addProductForm" method="post" action="add_product.php">

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
        </div>        
        <button class="add-product"> + Add Product </button>
        <table class="content2-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Supplier Name</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Expiry Date</th>
                    <th>Qty</th>
                    <th>Qty per Item</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
$result = $conn->query("SELECT * FROM product");
if ($result) {
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["product_id"] . "</td>";
            echo "<td>" . $row["supplier"] . "</td>";
            echo "<td>" . $row["product_name"] . "</td>";
            echo "<td>" . $row["category"] . "</td>";
            echo "<td>" . $row["type"] . "</td>";
            echo "<td>" . $row["expiry_date"] . "</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["quantity_per_item"] . "</td>";
            echo "<td>" . $row["price"] . "</td>";
            // Insert the following two lines to handle date and time
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["time"] . "</td>";
            echo "<td>" . $row["total"] . "</td>";
            // Add edit and delete icons with appropriate links or actions
            echo "<td>";
            echo "<button class='action-btn edit-btn' onclick='showEditForm()'><i class='fas fa-edit' style='color: blue;'></i></button>";
            echo "<button class='action-btn'><i class='fas fa-trash-alt' style='color: red;'></i></button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='13'>No records found</td></tr>";
    }
} else {
    echo "Error: " . $conn->error; // Output any errors that occurred during query execution
}
?>
            </tbody>
        </table>

        <div class="popupform_edit" id="popupform_edit" style="display:none;">
        <form action="/submit" method="post">
            <button class="exit-btn" onclick="hideEditForm()">&times;</button>
            <label for="supplier_id">Supplier Name:</label>
            <input type="text" id="supplier_id" name="supplier_id"><br><br>
    
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name"><br><br>
    
            <label for="category">Category:</label>
            <input type="text" id="category" name="category"><br><br>
    
            <label for="type">Type:</label>
            <input type="text" id="type" name="type"><br><br>
    
            <label for="expiry_date">Expiry Date:</label>
            <input type="date" id="expiry_date" name="expiry_date"><br><br>
    
            <label for="qty">Qty:</label>
            <input type="number" id="qty" name="qty"><br><br>
    
            <label for="qty_per_item">Qty per Item:</label>
            <input type="number" id="qty_per_item" name="qty_per_item"><br><br>
    
            <label for="price">Price:</label>
            <input type="number" id="price" name="price"><br><br>
    
            <label for="date">Date:</label>
            <input type="date" id="date" name="date"><br><br>
    
            <label for="time">Time:</label>
            <input type="time" id="time" name="time"><br><br>
    
            <label for="total">Total:</label>
            <input type="number" id="total" name="total"><br><br>
    
            <input type="submit1" value="Edit">
        </form>
    </div>
    


        <form action="" method="GET">
             <div class="search-container">
                <input type="text" class="content2-search" name="search" value="" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </form>
        <div class="dropdown-container">
            <select id="type" name="type" class="dropdown-toggle">
                <option value="" selected disabled hidden>Filter by Category</option>
                <option value="Category 1">Category 1</option>
                <option value="Category 2">Category 2</option>
                <option value="Category 3">Category 3</option>
                <!-- Add more categories as needed -->
            </select>
        </div>
    </div>
    

    <div id="content3" class="content">
        <h1>List of Stocks</h1>
            <div class="search-container">
                <input type="text" class="content3-search" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
            </div>
                <div class="dropdown-container">
                <select id="typeFilter" name="typeFilter" class="dropdown-toggle">
                    <option value="" selected disabled hidden>Filter by Category</option>
                    <option value="Category 1">Category 1</option>
                    <option value="Category 2">Category 2</option>
                    <option value="Category 3">Category 3</option>
                </select>

                </div>
                <div class="popup-form-container" id="popupFormContainer2" style="display: block;">
                    <div class="popup-form">
                        <span class="close-btn" onclick="closePopupForm()">&times;</span>
                        <h2>Add Stock</h2>
            
            <form id="addProductForm1" method="post" action="add_stock.php">
            <label for="product-name" class="label-product">Stock Description</label>
            <input type="text" name="stock-description" class="content2-productname">

            <label for="category" class="lbl-category">Category</label>
            <select name="category" id="category" class="select-category">
            <option value="" selected disabled hidden>Choose Category</option> 
            <option value="Beverages">Beverages</option>
            <option value="Alcohol">Alcohol</option>
            </select>

            
            <label for="type" class="lbltype">Type</label>
            <select name="type" id="" class="select-type">
                <option value="canned-drinks">Canned Drinks</option>
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

            
            <button type="submit" name="stocksubmit" class="add-btn">Add to Stock</button>
        </form>
                    </div>
                </div>   
                <button class="add-product1">+ Add Stock </button> <!-- Pass 3 as content index -->    
                <table class="content3-table">
                    <thead>
                        <tr>
                            <th>Stock ID</th>
                            <th>Product Name</th>
                            <th>Supplier</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Expiry Date</th>
                            <th>Quantity</th>
                            <th>Quantity per Item</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Total</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
            $result1 = $conn->query("SELECT * FROM stock");
        if ($result1) {
            if ($result1->num_rows > 0) {
                // Output data of each row
                while ($row = $result1->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["stock_id"] . "</td>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["supplier"] . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>" . $row["type"] . "</td>";
                    echo "<td>" . $row["expiry_date"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    echo "<td>" . $row["quantity_per_item"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    // Insert the following two lines to handle date and time
                    echo "<td>" . $row["date"] . "</td>";
                    echo "<td>" . $row["time"] . "</td>";
                    echo "<td>" . $row["total"] . "</td>";
                    // Add edit and delete icons with appropriate links or actions
                    echo "<td>";
                    echo "<a href='edit.php?id=" . $row["stock_id"] . "'><i class='fas fa-edit' style='color: blue;'></i></a>";
                    echo "<a href='delete.php?id=" . $row["stock_id"] . "'><i class='fas fa-trash-alt' style='color: red; margin-left: 10px;'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13'>No records found</td></tr>";
            }
        } else {
            echo "Error: " . $conn->error; // Output any errors that occurred during query execution
        }
        ?>
                    </tbody>
                </table> 
    </div>
    <div id="content4" class="content">
        <h1> Stock Reports </h1>
            <div class="search-container">
                <input type="text" class="content3-search" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
            </div>
                    <div class="dropdown-container">
                        <select id="type" name="type" class="dropdown-toggle">
                            <option value="" selected disabled hidden>Filter by Category</option>
                            <option value="Category 1">Category 1</option>
                            <option value="Category 2">Category 2</option>
                            <option value="Category 3">Category 3</option>
                            <!-- Add more categories as needed -->
                        </select>
                    </div>
                    <button class="btn-download"> Download </button>
                    <table class="content3-table">
                        <thead>
                            <tr>
                                <th>Stock ID</th>
                                <th>Product ID</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Qty per Item</th>
                                <th>Price</th>
                                <th>Delivered Products</th>
                                <th>Remaining Stocks</th>
                                <th>Critical Stocks</th>
                                <th>Supplier ID</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Stock ID</td>
                                <td>Product ID</td>
                                <td>Category</td>
                                <td>Item Name</td>
                                <td>Qty</td>
                                <td>Qty per Item</td>
                                <td>Price</td>
                                <td>Delivered Products</td>
                                <td>Remaining Stocks</td>
                                <td>Critical Stocks</td>
                                <td>Supplier ID</td>
                                <td>Date</td>
                                <td>Time</td>
                                <td>Total</td>

                            </tr>
                        </tbody>
                    </table>
    </div>
    <div id="content5" class="content">
        <h1> List of Suppliers </h1>
            <div class="search-container">
                <input type="text" class="content3-search" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
            </div> 
            <div class="dropdown-container">
                <select id="type" name="type" class="dropdown-toggle">
                    <option value="" selected disabled hidden>Filter by Supplier Name</option>
                    <option value="Category 1">Category 1</option>
                    <option value="Category 2">Category 2</option>
                    <option value="Category 3">Category 3</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>
            <table class="content5-table">
                <thead>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Address</th>
                        <th>Phone no.</th>
                        <th>Product ID</th>
                        <th>Product Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Supplier ID</td>
                        <td>Supplier Name</td>
                        <td>Address</td>
                        <td>Phone no.</td>
                        <td>Product ID</td>
                        <td>Product Description</td>
                        <td>Date</td>
                        <td>Time</td>
                        <td>Total</td>
                        <td>Status</td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div id="content6" class="content">
        <h1> Sales Report </h1>
            <div class="search-container">
                <input type="text" class="content3-search" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
            </div> 
            <div class="dropdown-container">
                <select id="type" name="type" class="dropdown-toggle">
                    <option value="" selected disabled hidden>Filter by Supplier ID</option>
                    <option value="Category 1">Category 1</option>
                    <option value="Category 2">Category 2</option>
                    <option value="Category 3">Category 3</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>
            <table class="content3-table">
                <thead>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Address</th>
                        <th>Phone no.</th>
                        <th>Product ID</th>
                        <th>Product Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Supplier ID</td>
                        <td>Supplier Name</td>
                        <td>Address</td>
                        <td>Phone no.</td>
                        <td>Product ID</td>
                        <td>Product Description</td>
                        <td>Date</td>
                        <td>Time</td>
                        <td>Total</td>
                        <td>Status</td>
                    </tr>
                </tbody>
            </table>
    </div>
    <script src="im.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.content2-search').on('input', function(){
            var searchQuery = $(this).val();
            $.ajax({
                url: 'search_products.php', // Replace 'search_products.php' with the actual URL to your server-side script for searching products
                method: 'GET',
                data: {search: searchQuery},
                success: function(response){
                    $('.content2-table tbody').html(response);
                }
            });
        });
    });

    $(document).ready(function(){
        $('.content3-search').on('input', function(){
            var searchQuery = $(this).val();
            $.ajax({
                url: 'search_stock.php', // Replace 'search_products.php' with the actual URL to your server-side script for searching products
                method: 'GET',
                data: {search: searchQuery},
                success: function(response){
                    $('.content3-table tbody').html(response);
                }
            });
        });
    });


</script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>

