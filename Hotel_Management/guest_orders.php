<?php
// Database credentials
include('db_connection.php');

// Pagination variables
$records_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to fetch data from products table
    $sql = "SELECT stock_id, product_id, product_name, category, type, quantity_per_item, price, expiry_date
    FROM stock";
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    
    // Execute the SQL statement
    $stmt->execute();
    
    // Fetch all rows as associative array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database connection error
    die("Connection failed: " . $e->getMessage());


}


try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to fetch data from checked table with selected columns
    $sql = "SELECT checkedid, guestname, roominfoid, status FROM checked LIMIT :offset, :records_per_page";
    
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    
    // Execute the SQL statement
    $stmt->execute();
    
    // Fetch all rows as associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database connection error
    die("Connection failed: " . $e->getMessage());
}




if (isset($_POST['submitOrder'])) {
    // Check if any items were selected
    if (!empty($_POST['selectedItems'])) {
        // Connect to your database (replace placeholders with actual values)
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'hotel_billing';

        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO orders (StockID, ProductName, OrderQuantity, Category, Price, TotalAmount, Status, CheckedID, OrderDate) VALUES (?, ?, ?, ?, ?, ?, 1, ?, ?)");

        // Check if the statement was prepared successfully
        if ($stmt) {
            // Get the values of checkInNo and orderDate from the POST data
            $checkInNo = $_POST['checkInNo'];
            $orderDate = $_POST['orderDate'];

            // Assuming you have access to product details in $products array
            foreach ($_POST['selectedItems'] as $stockId) {
                // Fetch product details based on stock ID
                $stmtProduct = $conn->prepare("SELECT product_id, product_name, category, price FROM stock WHERE stock_id = ?");
                $stmtProduct->bind_param("i", $stockId);
                $stmtProduct->execute();
                $productDetails = $stmtProduct->get_result()->fetch_assoc();
                $stmtProduct->close();

                // Calculate total amount based on quantity and price
                $totalAmount = $productDetails['price'] * $_POST['orderQty'][$stockId];

                // Bind parameters and execute the statement for orders table insertion
                $stmt->bind_param("isissdss", $stockId, $productDetails['product_name'], $_POST['orderQty'][$stockId], $productDetails['category'], $productDetails['price'], $totalAmount, $checkInNo, $orderDate);
                $stmt->execute();

                // Check for successful insertion
                if ($stmt->affected_rows < 1) {
                    echo "Error inserting order for StockID: " . $stockId;
                }
            }

            // Close the statement
            $stmt->close();

            // Close database connection
            $conn->close();

            // Show SweetAlert on successful submission
            echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "Order saved successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        // Redirect to another page or perform any other action
                        window.location.href = "success_page.php";
                    });
                  </script>';
        } else {
            echo "Error: Failed to prepare the statement.";
        }
    }
}

?>

       

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
      <!-- Include DataTables CSS -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <?php
    include('header.php');
    include('sidebar.php');
    ?>
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        
        .main-container {
            padding: 20px;
        }

        .main-title {
            margin-bottom: 20px;
        }

        .search-bar {
            position: relative;
            display: inline-block;
            width: 300px;

            margin-bottom: 10px; /* Added margin at the bottom */
        }

        .search-bar input {
            width: calc(100% - 40px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            margin-right: 40px; /* Adjusted margin to avoid overlapping */
        }

        .search-bar .material-icons-outlined {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #333;
            cursor: pointer;
        }

        .card {
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .table-container {
            width: 100%;
            overflow-x: auto; /* Enable horizontal scrollbar */
        }

        .table-wrapper {
            
        max-height: 300px;
        margin: 20px;
        overflow-y: scroll;
}
        .table {
            width: 100%;
            border: 1px solid black;
            border-collapse: separate;
            border-spacing: 0px;
            min-width: max-content;
        }

        th {
            position: sticky;
            top: 0px;
            background-color: #DAA520;
            color: black;
        }

        .table th, .table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            white-space: nowrap; /* Added to prevent line breaks */
            overflow: hidden; /* Added to hide overflow */
            text-overflow: ellipsis; /* Added to show ellipsis for overflow */
        }      

        .total-amount-container {
            display: flex;
            justify-content: start;
             margin-top: 10px;
            }

        .total-amount-container div {
            margin-left: 0px;
        }

  
        .btn-primary {
            background-color: #DAA520;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 10px;
           
        }

        .selected-item{
            background-color: #DAA520;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 10px;
            margin-top: 10px;
            
        }
        

        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .action-buttons button {
            margin-right: 5px; /* Adjust the margin between buttons as needed */
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #32CD32;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .save-btn {
            background-color: #DAA520; /* Same color as btn-primary */
            color: #fff; /* Same text color as btn-primary */
            border: none; /* Remove border */
            padding: 8px 16px; /* Same padding as btn-primary */
            border-radius: 5px; /* Same border-radius as btn-primary */
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 10px;
            margin-top: 10px; /* Adjust margin as needed */
            display: block; /* Align to center */
            margin-left: auto; /* Align to center */
            margin-right: auto; /* Align to center */
        }

        .pagination {
    display: flex;
    justify-content: start;
    margin-top: 20px;
    list-style-type: none; /* Remove default list-style */
    padding-left: 0; /* Remove default padding */
}

.page-item {
    margin: 0 5px;
}

.page-link {
    padding: 6px 12px;
    border: 1px solid #007bff;
    color: #007bff;
    border-radius: 3px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.page-link:hover {
    background-color: #007bff;
    color: #fff;
}

.page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

        .status-color {
          
            text-align: center;
           
        }
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
         top: 0;
         width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scrolling if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

       
/* Modal content */
.modal-content {
        background-color: #fefefe;
        margin: auto; /* Center horizontally */
        margin-top: 50px;
        padding: 20px;
        border: 1px solid #888;
        width: 90%; /* Adjusted width to make it wider */
        max-width: 800px; /* Set a maximum width */
        max-height: 80vh; /* Set a maximum height (optional) */
        overflow-y: auto; /* Enable vertical scrolling if needed */
    }

/* Close button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.modal-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* Styling for Guest Info section */
.guest-info {
  margin-bottom: 20px;
}

/* Styling for labels */
label {
  display: block;
  margin-bottom: 5px;
}

.input-group-modal {
  display: flex;
  flex-wrap: wrap;
}

.input-item {
  width: 30%;
  margin-right: 5px; /* Adjust spacing between input fields */
}

/* Styling for input fields */
input[type="text"],
input[type="number"],
input[type="date"]{
  width: 50%; /* Adjust the width as needed */
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box; /* Ensures padding and border are included in the width */
}




/* Styling for the Submit button */
.submit-button {
  text-align: center;
}
#checkInDate,
#checkInTime,
#gender {
    width: 50%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


.custom-checkbox {
        width: 100px; 
        height: 20px;
        margin: 0;
    }	

    </style>
</head>
<body>


  <!-- Main content -->
  <main class="main-container">
        <div class="main-title">
            <p class="font-weight-bold">Order Details</p>
        </div>

        <div class="container">
            <div class="card bg-white">
                <div class="card-body">
                <button class="btn btn-primary checkInGuest">Check-In-Guest</button>
                <form method="POST" action="guest_orders.php" onsubmit="return validateForm()">
                <div class="guest-info">
                <h3>Guest Info</h3>
                <div class="input-group-modal">
                <div class="input-item">
                <label for="checkInNo">Checked-In-No</label> 
                <input type="number" id="checkInNo" name="checkInNo" readonly>
        </div>
        <div class="input-item">
                <label for="guestName">Guest Name:</label> 
                <input type="text" id="guestName" name="guestName" readonly>
        </div>
        <div class="input-item">
            <label for="roomId">Room ID:</label>
            <input type="number" id="roomId" name="roomId" readonly>
        </div>
        <div class="input-item">
            <label for="roomId">Order Date:</label>
            <input type="date" id="orderDate" name="orderDate" >
        </div>
    </div>
</div>

    <div class="table-container">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th>Category</th>
                    <th>Order Qty</th>
                    <th>Available Qty</th>
                    <th>Price</th> 
                    <th>Expiry Date</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><input type="checkbox" name="selectedItems[]" class="selectItem" value="<?php echo $product['stock_id']; ?>"></td>
                        <td><?php echo $product['product_id']; ?></td>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['type']; ?></td>
                        <td><?php echo $product['category']; ?></td>
                        <td><input type="number" class="orderQty" name="orderQty[<?php echo $product['stock_id']; ?>]" value="1" min="1" max="<?php echo $product['quantity_per_item']; ?>" onchange="validateInput(this)" onchange="validateOrderQty(this)" data-price="<?php echo $product['price']; ?>"></td>
                        <td><?php echo $product['quantity_per_item']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['expiry_date']; ?></td>
                        <td><input type="number" class="totalAmount" name="totalAmount[<?php echo $product['stock_id']; ?>]" ></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="save-btn" name="submitOrder">Save Order</button>
    </div>
</form>
                </div>
                </div>
                    <div>

        </div>
    </div>
 </div>
 
</main>



    
<div id="checkInModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Checked In Guest</h2>
        <hr>
        <div class="checkin-room">
            <h3>Checked In</h3>
            <div class="table-container">
                <!-- Table code -->
                <div class="outer-wrapper">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guest Name</th>
                                    <th>Room ID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <td><?php echo $row['checkedid']; ?></td>
                                        <td><?php echo $row['guestname']; ?></td>
                                        <td><?php echo $row['roominfoid']; ?></td>
                                        <td>
                                            <span class="status-color" style="background-color: <?php echo ($row['status'] == 1) ? '#FFD700' : 'transparent'; ?>; color: white; padding: 2px 5px; border-radius: 5px;">
                                                <?php echo ($row['status'] == 1) ? 'Checked-In' : 'Checked-Out'; ?>
                                            </span>
                                        </td>
                                        <td class="action-buttons">
                                            <button class="btn btn-primary selectGuest" 
                                                    data-room-id="<?php echo $row['roominfoid']; ?>"
                                                    data-checkin-no="<?php echo $row['checkedid']; ?>"
                                                    data-guest-name="<?php echo $row['guestname']; ?>">Select
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <?php
            // Count total records
            $sql_count = "SELECT COUNT(*) AS count FROM checked";
            $stmt_count = $pdo->prepare($sql_count);
            $stmt_count->execute();
            $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
            $total_records = $row_count['count'];

            // Calculate total pages
            $total_pages = ceil($total_records / $records_per_page);
            ?>
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>


<div id="secondModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Product Menu</h2>
        <div class="table-container">
            <!-- Table code -->
            <table class="table" id="selectedItemsTable">
                <thead>
                <tr>
                    <th>Select</th> <!-- Added a new column for checkboxes -->
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th>Category</th>
                    <th>Available Quantity</th>
                    <th>Price</th> 
                    <th>Expiry Date</th>
                    
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                <tr>
                    <td><input type="checkbox"></td> <!-- Added checkbox -->
                    <td><?php echo $product['Products_ID']; ?></td>
                    <td><?php echo $product['Product_Name']; ?></td>
                    <td><?php echo $product['Type']; ?></td>
                    <td><?php echo $product['Category']; ?></td>
                    <td><?php echo $product['Quantity']; ?></td>
                    <td><?php echo $product['Price']; ?></td>
                    <td><?php echo $product['Expiry_Date']; ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total-amount-container">
            <div>Total Amount: <span id="totalAmountDisplay"></span></div>
                <div>600</div>
            </div>
            <!-- Pagination -->
            <?php
            // Count total records
            $sql_count = "SELECT COUNT(*) AS count FROM checked";
            $stmt_count = $pdo->prepare($sql_count);
            $stmt_count->execute();
            $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
            $total_records = $row_count['count'];
            
            // Calculate total pages
            $total_pages = ceil($total_records / $records_per_page);
            ?>
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
        <!-- Select button inside the second modal -->
        <button type="submit" class="selected-item" name="submit">Select Items</button>
    </div>
</div>

               



<!-- Scripts -->
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
<!-- Custom JS -->
<script src="js/scripts.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                        


    <script>
    var modal = document.getElementById('checkInModal'); 
var checkInGuestBtns = document.querySelectorAll('.checkInGuest'); // Updated selector for Check-In buttons
var selectGuest = document.querySelectorAll('.selectGuest');

function openModal(event) {
    modal.style.display = 'block';
}

function closeModal(event) {
    // Retrieve data from the clicked button's data attributes
    var roomId = event.target.getAttribute('data-room-id');
    var checkInNo = event.target.getAttribute('data-checkin-no');
    var guestName = event.target.getAttribute('data-guest-name');

    // Set the values in the input fields outside the modal
    document.getElementById('checkInNo').value = checkInNo;
    document.getElementById('guestName').value = guestName;
    document.getElementById('roomId').value = roomId;

    // Close the modal
    modal.style.display = 'none';
}

checkInGuestBtns.forEach(function(btn) {
    btn.addEventListener('click', openModal);
});

selectGuest.forEach(function(btn) {
    btn.addEventListener('click', closeModal);
});

var closeBtn = document.getElementsByClassName('close')[0];

closeBtn.onclick = function() {
    modal.style.display = 'none';
    resetInputFields(); // Call the function to reset input fields
};

var inputFields = document.querySelectorAll('.modal-content input, .modal-content select');

// Function to reset input fields
function resetInputFields() {
    inputFields.forEach(function(field) {
        field.value = '';
    });
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
        resetInputFields(); // Call the function to reset input fields
    }
};


    var orderItems = document.querySelectorAll('.orderItems');

    var secondModal = document.getElementById('secondModal');
        var openSecondModalBtn = document.querySelector('.openSecondModal');
        var closeSecondModalBtn = secondModal.querySelector('.close');

        // Function to open the second modal
        function openSecondModal() {
            secondModal.style.display = 'block';
        }

        // Function to close the second modal
        function closeSecondModal() {
            secondModal.style.display = 'none';
        }

        // Event listener for opening the second modal
        openSecondModalBtn.addEventListener('click', openSecondModal);

        // Event listener for closing the second modal
        closeSecondModalBtn.addEventListener('click', closeSecondModal);

        // Close the second modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == secondModal) {
                closeSecondModal();
            }
        };

    $(document).ready(function(){
        // Initialize DateTimePicker
        $('#checkInDate').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss', // Specify the date-time format you want
            useCurrent: false, // Do not set the current date-time automatically
            icons: {
                time: 'far fa-clock', // Customize the time icon
                date: 'far fa-calendar', // Customize the date icon
                up: 'fas fa-chevron-up', // Customize the up arrow icon
                down: 'fas fa-chevron-down', // Customize the down arrow icon
                previous: 'fas fa-chevron-left', // Customize the previous month icon
                next: 'fas fa-chevron-right', // Customize the next month icon
                today: 'far fa-calendar-check', // Customize the today icon
                clear: 'far fa-trash-alt', // Customize the clear icon
                close: 'far fa-times-circle' // Customize the close icon
            }
        });
    });

    
function openSecondModalOnClick() {
    // Get the values of guestName, checkedId, and roomId input fields
    var guestNameValue = document.getElementById('guestName').value;
    var checkedIdValue = document.getElementById('checkInNo').value;
    var roomIdValue = document.getElementById('roomId').value;

    // Check if any of the fields are empty
    if (guestNameValue.trim() === '' || checkedIdValue.trim() === '' || roomIdValue.trim() === '') {
        // Show an alert or message indicating that the fields are required
        alert('Please fill in all the required fields before opening the second modal.');
    } else {
        // If all fields are filled, open the second modal
        openSecondModal();
    }
}




function validateInput(input) {
    // Get the value entered by the user
    var value = input.value;
    
    // Check if the value is 0 or starts with multiple 0s
    if (value === '0' || /^0+/.test(value)) {
        // If the value is 0 or starts with multiple 0s, reset it to 1
        input.value = '1';
    }
    
    // Calculate the total amount
    calculateTotal(input);

    // Check if the input value is already 1
    if (value === '1') {
        // If the input value is 1, trigger the calculation of total amount directly
        calculateTotalAmount();
    }
}


function validateInput(input) {
    // Get the value entered by the user
    var value = input.value;

    // Check if the value is 0 or starts with multiple 0s
    if (value === '0' || /^0+/.test(value)) {
        // If the value is 0 or starts with multiple 0s, reset it to 1
        input.value = '1';
    }

    // Calculate the total amount
    calculateTotal(input);

    // Check if the input value is already 1
    if (value === '1') {
        // If the input value is 1, trigger the calculation of total amount directly
        calculateTotalAmount();
    }
}

function calculateTotal(input) {
    const row = input.closest('tr');
    const orderQty = parseInt(input.value);
    const price = parseFloat(row.cells[7].textContent); // Assuming price is in the 8th column
    const totalAmount = orderQty * price;
    row.querySelector('.totalAmount').value = totalAmount.toFixed(2);
    validateOrderQty(input); // Validate the input after calculating total amount
}

function validateOrderQty(input) {
    const row = input.closest('tr');
    const maxQty = parseInt(row.cells[6].textContent); // Assuming available quantity is in the 7th column
    let currentQty = parseInt(input.value);

    if (isNaN(currentQty) || currentQty < 1) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Quantity',
            text: 'Please enter a valid quantity.',
        });
        input.value = 1;
        currentQty = 1;
    } else if (currentQty > maxQty) {
        Swal.fire({
            icon: 'error',
            title: 'Quantity Exceeded',
            text: 'Order quantity cannot exceed available quantity (' + maxQty + ').',
        });
        input.value = maxQty;
    }

    // Calculate the total amount again after validation
    calculateTotal(input);
}

function validateForm() {
        // Form validation logic here
        // Example logic:
        const guestName = document.getElementById('guestName').value;
        const checkInNo = document.getElementById('checkInNo').value;
        const roomId = document.getElementById('roomId').value;
        const orderDate = document.getElementById('orderDate').value;
        const checkboxes = document.querySelectorAll('.selectItem:checked');

        if (guestName === '' || checkInNo === '' || roomId === '' || orderDate === '') {
            Swal.fire("Error", "Please fill in all required fields.", "error");
            return false;
        }

        if (checkboxes.length === 0) {
            Swal.fire("Error", "Please select at least one item.", "error");
            return false;
        }

        // If all validations pass, return true to submit the form
        return true;
    }
        </script>

<script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>





</body>
</html>