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
    <link rel="stylesheet" href="path/to/your/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['first_name']) || !isset($_SESSION['last_name'])) {
    header('Location: login.html');
    exit;
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

$countsupplier = "SELECT COUNT(*) AS totalsupplier FROM productsupplierview";
$resultcountsupplier = $conn->query($countsupplier);

$querycritical = "SELECT COUNT(*) AS count_less_than_20 FROM stock WHERE quantity_per_item < 20";
$resultcritical = mysqli_query($conn, $querycritical);



?>

    <div class="navbar">
        <img src="images/logo2.png" class="logo2" alt="">
        
        <a href="#" class="nav-link manage-product" data-index="2"><img src="images/manageproduct.png" class="iconmanageproduct"> Manage Product</a>
        <a href="#" class="nav-link manage-stocks" data-index="3"><img src="images/managestocks.png" class="iconmanagestocks"> Manage Stocks</a>
        <a href="#" class="nav-link stock-reports" data-index="4"><img src="images/reports.png" class="iconstockreports"> Stock Reports</a>
        <a href="#" class="nav-link suppliers" data-index="5"><img src="images/suppliers.png" class="iconsuppliers">Suppliers</a>
        
    </div>

    <div class="upper-div">
    <span class="hamburger">&#9776;</span>
    <p id="datetime" class="datetime"></p>
    <p class="name-admin"> <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></p>
    <form id="logoutForm" action="login.html" method="post" class="form2">
    <button type="button" class="logout-button" onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i></button>
</form> 
    </div>

   

    <div id="content2" class="content">
        <h1>List of Products</h1>
        <div class="popup-form-container" id="popupFormContainer">
            <div class="popup-form">
                <span class="close-btn" onclick="closePopupForm()">&times;</span>
                <h2>Add Product</h2>
    
                <form id="addProductForm" method="post" action="add_productstaff.php">

    <label for="product-name" class="label-product">Product Name</label>
    <input type="text" name="productname" class="content2-productname" required>

    <label for="category" class="lbl-category">Category</label>
    <select name="category" class="select-category" required>
        <option value="">Select Category</option>
        <option value="Beverages">Beverages</option>
        <option value="Alcohol">Alcohol</option>
    </select>

    <label for="type" class="lbltype">Type</label>
    <select name="type" class="select-type" required>
        <option value="">Select Type</option>
        <option value="Canned Drinks">Canned Drinks</option>
        <option value="Bottled Alcohol">Bottled Alcohol</option>
    </select>

        <label for="expiry" class="lblexpiry">Expiry Date</label>
                        <input type="date" name="expiry" id="expiry" class="select-expiry" required>
                        
                        <label for="quantity" class="lblqty">Quantity</label>
                        <input type="text" name="quantity" class="input-qty" required>

                        <label for="qtyperitem" class="lblqtyperitem">Quantity per Item</label>
                        <input type="text" name="qtyperitem" class="input-qtyperitem" required>
                        
                        <label for="price" class="lblprice">Price</label>
                        <input type="text" name="price" class="input-price" required>

                        <label for="date-purchased" class="lbldatepurchased">Date Purchased</label>
                        <input type="date" name="date" class="input-datepurchased" required>

                        <label for="time-purchased" class="lbltimepurchased">Time Purchased</label>
                        <input type="time" name="time" class="input-timepurchased" required>

                        <label for="supplier" class="lblsupplier">Supplier</label>
                        <input type="text" name="supplier" class="input-supplier" id="supplier" required>

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
                    
                </tr>
            </thead>
            <tbody>
            <?php
$result = $conn->query("SELECT * FROM product");
if ($result) {
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Start the table row with the data-category attribute
            echo "<tr data-category='" . $row["category"] . "'>";
            
            // Echo the rest of the table row's content
            echo "<td>" . $row["product_id"] . "</td>";
            echo "<td>" . $row["supplier"] . "</td>";
            echo "<td>" . $row["product_name"] . "</td>";
            echo "<td>" . $row["category"] . "</td>";
            echo "<td>" . $row["type"] . "</td>";
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
            <div class="content2-wrap">
            <form method="post" action="update_product.php">
                <span class="close-btn2" onclick="closePopupForm1()">&times;</span>
                <h2>Edit Product Information</h2>

                <label for="product_name" class="edit-label-product">Product Name:</label>
                <input type="text" id="product_name" name="product_name" class="edit-productname"><br><br>

                <label for="category" class="edit-lbl-category">Category</label>
                <select name="category" id="category" class="edit-select-category">
                    <option value="Beverages">Beverages</option>
                    <option value="Alcohol">Alcohol</option>
                </select>

                <label for="type" class="edit-lbltype">Type</label>
                <select name="type" id="type" class="edit-select-type">
                    <option value="Canned Drinks">Canned Drinks</option>
                    <option value="Bottled Alcohol">Bottled Alcohol</option>
                </select>

                <label for="supplier" class="edit-lblsupplier">Supplier</label>
                <input type="text" name="product-supplier" id="product-supplier" class="edit-supplier">


                <input type="hidden" name="productid" id="productid" class="productid"> <!-- Hidden field for product ID -->

                <button type="submit" class="edit-button">Edit</button>
            </form>
                </div>
                    </div>
    


        <form action="" method="GET">
             <div class="search-container">
                <input type="text" class="content2-search" name="search" value="" placeholder="Search Product Name">
                <i class="fas fa-search search-icon"></i>
            </div>
        </form>
        
       
    </div>
    

    <div id="content3" class="content">
        <h1>List of Stocks</h1>
        <form action="" method="GET">
            <div class="search-container">
                <input type="text" class="content3-search" name="stocksearch" value="" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </form>


        
                <!-- Modal overlay -->
                <div id="modal-overlay" class="modal-overlay">
    <!-- Popup form for updating stock -->
                <div id="popup-form" class="popup-form">
                    <form id="update-form" action="update_stockstaff.php" method="post" class="popup-form-content">
                        <h2>Edit Stock Information</h2>
                        <!-- Close button -->
                        <span class="close" onclick="togglePopupForm()">&times;</span>
                        <!-- Your form fields for updating stock -->
                            <input type="hidden" name="stock_id" id="editstock_id">
                            <input type="hidden" name="product_id" id="editproduct_id">
                            <input type="hidden" name="supplier_id" id="editsupplier_id">
                            

                            <label for="product-name" class="label-product">Product Name</label>
                            <input type="text" name="product_name" class="content2-productname" id="editproduct_name" required>

                            <label for="expiry" class="lblexpiry">Expiry Date</label>
                            <input type="date" name="expiry" class="select-expiry" id="editexpiry" required>
                            
                            <label for="quantity" class="lblqty">Quantity</label>
                            <input type="text" name="quantity" class="input-qty" id="editquantity" required>

                            <label for="qtyperitem" class="lblqtyperitem">Quantity per Item</label>
                            <input type="text" name="qtyperitem" class="input-qtyperitem" id="editqtyperitem" required>
                            
                            <label for="price" class="lblprice">Price</label>
                            <input type="text" name="price" class="input-price" id="editprice" required>

                            <label for="date-purchased" class="lbldatepurchased">Date Purchased</label>
                            <input type="date" name="date" class="input-datepurchased" id="datepurchased" required>

                            <label for="time-purchased" class="lbltimepurchased">Time Purchased</label>
                            <input type="time" name="time" class="input-timepurchased" id="timepurchased" required>


                            <label for="supplier" class="lblsupplier">Supplier</label>
                            <input type="text" name="supplier" class="input-supplier" id="editsupplier" required>

                            <label for="category_stock" class="lbl-category">Category</label>
                            <select name="category_stock" id="category_stock" class="select-category" required>
                                <option value="Beverages">Beverages</option>
                                <option value="Alcohol">Alcohol</option>
                            </select>

                            <label for="type_stock" class="lbltype">Type</label>
                            <select name="type_stock" id="type_stock" class="select-type" required>
                                <option value="Canned Drinks">Canned Drinks</option>
                                <option value="Bottled Alcohol">Bottled Alcohol</option>
                            </select>

                    

                            


                        <button type="submit" class="popup-form-submit-button add-btn">Update Stock</button>
        </form>
    </div>
</div>

            




                <div class="popup-form-container" id="popupFormContainer2" style="display: block;">
                    <div class="popup-form">
                        <span class="close-btn" onclick="closePopupForm()">&times;</span>
                        <h2>Add Stock</h2>
                        <form id="addProductForm1" method="post" action="add_stock.php">
                        <label for="product-name" class="label-product">Product Name</label>
                        <input type="text" name="product_name" class="content2-productname">

                        <label for="category" class="lbl-category">Category</label>
                        <select name="category" id="category" class="select-category">
                        <option value="" selected disabled hidden>Choose Category</option> 
                        <option value="Beverages">Beverages</option>
                        <option value="Alcohol">Alcohol</option>
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

                        
                        <button type="submit" name="stocksubmit" class="add-btn">Add to Stock</button>
                    </form>
                                </div>
                            </div>

                   
                <table class="content3-table">
                    <thead>
                        <tr>
                            <th>Stock ID</th>
                            <th>Product Name</th>
                            <th>Supplier</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Expiry Date</th>
                            <th>Quantity (Box)</th>
                            <th>Total Quantity</th>
                            <th>Price per item</th>
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
                    // PHP Code for Content 3 (Inventory Manager)
                    echo "<button class='action-btn edit-btn' onclick='togglePopupForm(" . json_encode($row) . ")' style='display: inline-block; vertical-align: middle; margin-right: 5px;'><i class='fas fa-edit' style='color: blue;'></i></button>";
                    echo "<button class='action-btn delete-btn' onclick='deleteStock(" . $row["stock_id"] . ")'><i class='fas fa-trash-alt' style='color: red;'></i></button>";
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
        <h1>Stock Reports</h1>
        <!-- Download button for CSV report -->
    

        <div class="search-container">
            <input type="text" class="content4-search" placeholder="Search...">
            <i class="fas fa-search search-icon"></i>
        </div>

        <!-- Your table with stock data -->
        <button class="btn-download" onclick="downloadCSV()">Download CSV</button>
        <table id="stockTable" class="content4-table">
            <thead>
                <tr>
                    <th>Stock ID</th>
                    <th>Product ID</th>
                    <th>Supplier ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Delivered Products</th>
                    <th>Remaining Stocks</th>
                    <th>Critical Stock?</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Your PHP code to generate table rows
                $stockresult = $conn->query("SELECT * FROM stockcombineddetails");
                if ($stockresult) {
                    if ($stockresult->num_rows > 0) {
                        // Output data of each row
                        while ($row = $stockresult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["stock_id"] . "</td>";
                            echo "<td>" . $row["product_id"] . "</td>";
                            echo "<td>" . $row["supplier_id"] . "</td>";
                            echo "<td>" . $row["product_name"] . "</td>";
                            echo "<td>" . $row["category"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "<td>" . $row["quantity_per_item"] . "</td>";
                            echo "<td>" . $row["critical_stock"] . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            // Insert the following two lines to handle date and time
                            echo "<td>" . $row["time"] . "</td>";
                            echo "<td>" . $row["total"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No records found</td></tr>";
                    }
                } else {
                    echo "Error: " . $conn->error; // Output any errors that occurred during query execution
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="content5" class="content">
        <h1> List of Suppliers </h1>
            <form action="" method="GET">
            <div class="search-container">
                <input type="text" name="search" class="content5-search" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
            </div> 
    </form>
            <table class="content5-table">
                <thead>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Product Name</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                <?php
$result = $conn->query("SELECT * FROM productsupplierview");
if ($result) {
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["supplier_id"] . "</td>";
            echo "<td>" . $row["supplier_name"] . "</td>";
            echo "<td>" . $row["address"] . "</td>";
            echo "<td>" . $row["phone_number"] . "</td>";
            echo "<td>" . $row["product_name"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";      
            echo "<td>";
            echo "<button class='action-btn edit-btn' onclick='toggle(" . json_encode($row) . ")' style='display: inline-block; vertical-align: middle; margin-right: 5px;'><i class='fas fa-edit' style='color: blue;'></i></button>";
            echo "</td>";
            echo "</tr>";
        }        
    } else {
        echo "<tr><td colspan='13'>No records found</td></tr>";
    }
} else {
    echo "Error: " . $conn->error;
}
?>
                </tbody>
            </table>
        <!-- Modal overlay -->
        <div id="modal-overlaysupplier" class="modal-overlay">
    <!-- Popup form for updating stock -->
                <div id="popup-formsupplier" class="popup-form">
                <form id="update-form" action="update_supplierstaff.php" method="post" class="popup-form-content">
                        <h2>Edit Stock Information</h2>
                        <!-- Close button -->
                        <span class="close" onclick="toggle()">&times;</span>
                        <!-- Your form fields for updating stock -->

                        <label for="product-name" class="label-product">Supplier Name</label>
                        <input type="text" name="supplier_name" class="content2-productname" id="supplier-suppliername" readonly>

                        <label for="address" class="lbladdress">Address</label>
                        <textarea name="address" class="address" id="supplier_address" rows="4" cols="50" required></textarea>

                            <label for="status" class="lbl-category">Status</label>
                            <select name="status" id="supplier-status" class="select-category" required>
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                             
                        <label for="type" class="lbltype">Phone number</label>
                        <input type="text" class="supplier-contact" id="supplier-contact" name="phone_number" onkeypress="return onlyNumberKey(event)"  maxlength="11" required>



                        <input type="hidden" name="supplier_id" id="supplier-supplierid">

                        <button type="submit" class="popup-form-submit-button add-btn">Update Supplier</button>
        </form>
    </div>
</div>




    </div>
    
    <script src="staff.js"></script>
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

    $(document).ready(function(){
        $('.content4-search').on('input', function(){
            var searchQuery = $(this).val();
            $.ajax({
                url: 'search_stockreport.php', // Replace 'search_products.php' with the actual URL to your server-side script for searching products
                method: 'GET',
                data: {search: searchQuery},
                success: function(response){
                    $('.content4-table tbody').html(response);
                }
            });
        });
    });

    $(document).ready(function(){
        $('.content5-search').on('input', function(){
            var searchQuery = $(this).val();
            $.ajax({
                url: 'search_supplier.php', // Replace 'search_products.php' with the actual URL to your server-side script for searching products
                method: 'GET',
                data: {search: searchQuery},
                success: function(response){
                    $('.content5-table tbody').html(response);
                }
            });
        });
    });

    document.getElementById("editForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        var formData = new FormData(this);

        // Send AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_product.php", true); // Specify the URL of your PHP script
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Handle the response from the server
                alert(xhr.responseText); // Display response message
                // Redirect to inventory_manager.php after 2 seconds
                setTimeout(function() {
                    window.location.href = 'inventory_manager.php';
                }, 2000);
            }
        };
        xhr.send(formData); // Send form data
    });

    
function deleteProduct(productId) {
    if (confirm("Are you sure you want to delete this product?")) {
        // Create a form to submit the product id to delete_product.php
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "delete_product.php");

        // Create an input field to hold the product id
        var productIdField = document.createElement("input");
        productIdField.setAttribute("type", "hidden");
        productIdField.setAttribute("name", "product_id");
        productIdField.setAttribute("value", productId);

        // Append the input field to the form
        form.appendChild(productIdField);

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteStock(stockId) {
    if (confirm("Are you sure you want to delete this product?")) {
        // Create a form to submit the stock id to delete_stock.php
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "delete_stockstaff.php");

        // Create an input field to hold the stock id
        var stockIdField = document.createElement("input");
        stockIdField.setAttribute("type", "hidden");
        stockIdField.setAttribute("name", "stock_id");
        stockIdField.setAttribute("value", stockId);

        // Append the input field to the form
        form.appendChild(stockIdField);

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();
    }
}


function togglePopupForm() {
    var popup = document.getElementById("popupform_editstocks");
    if (popup.style.display === "none" || popup.style.display === "") {
        popup.style.display = "block";
        // Disable scrolling on the body
        document.body.style.overflow = "hidden";
    } else {
        popup.style.display = "none";
        // Enable scrolling on the body
        document.body.style.overflow = "auto";
    }
}


function closePopupForm3() {
    var popup = document.getElementById("popupform_editstocks");
    popup.style.display = "none";
    // Enable scrolling on the body
    document.body.style.overflow = "auto";
}

function closePopupForm1() {
    var form = document.getElementById("popupform_edit");
    form.style.display = "none";
}

document.querySelectorAll('.update-button').forEach(button => {
        button.addEventListener('click', function() {
            // Get product ID from data attribute
            const productId = button.getAttribute('data-product-id');
            // Set product ID in the hidden input field of the form
            document.getElementById('product_id').value = productId;
            // Display the popup form
            document.getElementById('popup-form').style.display = 'block';
        });
    });

    // Function to show modal overlay and popup form
    function togglePopupForm(rowData) {
    var modalOverlay = document.getElementById('modal-overlay');
    var popupForm = document.getElementById('popup-form');
    if (modalOverlay.style.display === 'block') {
        modalOverlay.style.display = 'none';
        popupForm.style.display = 'none';
        // Enable scrolling on body when modal is closed
        document.body.style.overflow = ''; // Reset overflow to default
    } else {
        modalOverlay.style.display = 'block';
        popupForm.style.display = 'block';
        // Disable scrolling on body when modal is open
        document.body.style.overflow = 'hidden';

        document.getElementById("editstock_id").value = rowData.stock_id;
    document.getElementById("editproduct_id").value = rowData.product_id;
    document.getElementById("editsupplier_id").value = rowData.supplier_id;
    document.getElementById("editproduct_name").value = rowData.product_name;
    document.getElementById("editsupplier").value = rowData.supplier;
    document.getElementById("category_stock").value = rowData.category;
    document.getElementById("type_stock").value = rowData.type;
    document.getElementById("editexpiry").value = rowData.expiry_date;
    document.getElementById("editquantity").value = rowData.quantity;
    document.getElementById("editqtyperitem").value = rowData.quantity_per_item;
    document.getElementById("editprice").value = rowData.price;
    document.getElementById("datepurchased").value = rowData.date;
    document.getElementById("timepurchased").value = rowData.time;
    document.getElementById("edittotal").value = rowData.total;
        
    }
}

function toggle(rowData) {
    var modalOverlay = document.getElementById('modal-overlaysupplier');
    var popupForm = document.getElementById('popup-formsupplier');
    if (modalOverlay.style.display === 'block') {
        modalOverlay.style.display = 'none';
        popupForm.style.display = 'none';
        document.body.style.overflow = ''; 
    } else {
        modalOverlay.style.display = 'block';
        popupForm.style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        document.getElementById("supplier-suppliername").value = rowData.supplier_name;
        document.getElementById("supplier-supplierid").value = rowData.supplier_id;
        document.getElementById("supplier_address").value = rowData.address;
        document.getElementById("supplier-contact").value = rowData.phone_number;
        document.getElementById("supplier-status").value = rowData.status;

    }
}

function onlyNumberKey(evt) {
 
 // Only ASCII character in that range allowed
 let ASCIICode = (evt.which) ? evt.which : evt.keyCode
 if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
     return false;
 return true;
}






function setProductID(productId) {
        document.getElementById("productid").value = productId;
    }

    function setsupplier(supplier) {
        document.getElementById("supplier").value = supplier;
    }

    function downloadCSV() {
            // Get table element
            const table = document.getElementById('stockTable');
            // Prepare CSV content
            let csv = [];
            // Loop through rows
            for (let i = 0; i < table.rows.length; i++) {
                let row = [];
                // Loop through cells
                for (let j = 0; j < table.rows[i].cells.length; j++) {
                    row.push(table.rows[i].cells[j].innerText);
                }
                csv.push(row.join(','));
            }
            // Join rows with newline character
            csv = csv.join('\n');
            // Create Blob object
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            // Create link element to trigger download
            const link = document.createElement('a');
            if (link.download !== undefined) {
                // Create link URL
                const url = URL.createObjectURL(blob);
                // Set link attributes
                link.setAttribute('href', url);
                link.setAttribute('download', 'stock_report.csv');
                link.style.visibility = 'hidden';
                // Append link to body and trigger click event
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>

