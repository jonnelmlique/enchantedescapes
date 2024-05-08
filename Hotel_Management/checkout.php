<?php
// Database credentials
include('db_connection.php');

// Pagination variables
$records_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;


try {
    // Create a new PDO instance
    $pdo_checked = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo_checked->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to fetch data from checked table
                $sql_checked = "SELECT 
                c.checkedid, 
                c.guestname, 
                c.contactno, 
                c.roominfoid, 
                r.roomnumber, 
                r.roomfloor, 
                c.roomtype, 
                c.price, 
                c.adult, 
                c.children, 
                c.checkindate, 
                c.checkintime, 
                c.checkoutdate, 
                c.checkouttime, 
                c.days, 
                c.payment_method, 
                c.status,
                c.reservationfee
            FROM 
                checked c
            INNER JOIN 
                roominfo r 
            ON 
                c.roominfoid = r.roominfoid
            WHERE 
                c.status = 1 OR c.status = 2
            LIMIT 
                $records_per_page 
            OFFSET 
                $offset";
    // Prepare the SQL statement
    $stmt_checked = $pdo_checked->prepare($sql_checked);
    
    // Execute the SQL statement
    $stmt_checked->execute();
    
    // Fetch all rows from checked as associative array
    $result_checked = $stmt_checked->fetchAll(PDO::FETCH_ASSOC);

    // Check if $result_checked is not null before iterating
    if ($result_checked !== null) {
        foreach ($result_checked as $row) {
            // Your table row code here
        }
    } else {
        echo "No records found."; // Display a message if no records are fetched
    }
} catch (PDOException $e) {
    // Handle database connection error
    die("Checked Connection failed: " . $e->getMessage());
}


try {
    // Create a new PDO instance
    $pdo_orders = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo_orders->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_orders = "SELECT 
                CheckedID,
                 
                ProductName, 
                Category, 
                OrderQuantity,
                Price, 
                TotalAmount
            FROM 
                orders
             ";
    
    // Prepare the SQL statement
    $stmt_orders = $pdo_orders->prepare($sql_orders);
    
    // Execute the SQL statement
    $stmt_orders->execute();
    
    // Fetch all rows as associative array
    $result_orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database connection error
    die("Orders Connection failed: " . $e->getMessage());
}


// Initialize PDO and set error mode
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['update'])) {
    // Extract data from $_POST
    $checkedId = $_POST['checkedId'];
    $checkOutDate = $_POST['checkOutDate'];
    $checkOutTime = $_POST['checkOutTime'];
    $days = $_POST['days'];
    $paymentMethod = $_POST['paymentMethod'];
    $roomTotalPrice = $_POST['roomTotalPrice'];
    $ordersTotalAmount = $_POST['totalAmount'];
    $overallAmount = $_POST['ovAmount'];
    $checkedIds = $_POST['checkedIds'];
    $paidAmount = $_POST['paidAmount'];

    // Update query for checked table
    $updateCheckedQuery = "UPDATE checked SET checkoutdate = ?, checkouttime = ?, days = ?, payment_method = ?, room_total_price = ? WHERE checkedid = ?";
    $stmtUpdateChecked = $pdo->prepare($updateCheckedQuery);
    $stmtUpdateChecked->execute([$checkOutDate, $checkOutTime, $days, $paymentMethod, $roomTotalPrice, $checkedId]);

    // Update status query
    $updateStatusQuery = "UPDATE checked SET status = 2 WHERE checkedid = ?";
    $stmtUpdateStatus = $pdo->prepare($updateStatusQuery);
    $stmtUpdateStatus->execute([$checkedId]);

    // Update room status query
    $fetchRoomIdQuery = "SELECT roominfoid FROM checked WHERE checkedid = ?";
    $stmtFetchRoomId = $pdo->prepare($fetchRoomIdQuery);
    $stmtFetchRoomId->execute([$checkedId]);
    $roomIdResult = $stmtFetchRoomId->fetch(PDO::FETCH_ASSOC);

    $updateRoomStatusQuery = "UPDATE roominfo SET status = 'Available' WHERE roominfoid = ?";
    $stmtUpdateRoomStatus = $pdo->prepare($updateRoomStatusQuery);
    $stmtUpdateRoomStatus->execute([$roomIdResult['roominfoid']]);

    // Insert query for payments table
    $insertPaymentQuery = "INSERT INTO payments (checkedids, rmtotalamount, ordtotalamount, overallamount, paidamount) VALUES (?, ?, ?, ?, ?)";
    $stmtInsertPayment = $pdo->prepare($insertPaymentQuery);
    $stmtInsertPayment->execute([$checkedIds, $roomTotalPrice, $ordersTotalAmount, $overallAmount, $paidAmount]);

    // Redirect to your page after successful update
    header("Location: checkout.php");
    exit;
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

        
        .btn-primary {
            background-color: #DAA520;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
           
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
            width: 80%; /* Adjust the width as needed */
            max-width: 600px; /* Set a maximum width */
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
  margin-right: 10px; /* Adjust spacing between input fields */
}

/* Styling for input fields */
input[type="text"],
input[type="number"],
input[type="time"],
input[type="date"] {
  width: 100%; /* Adjust the width as needed */
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
#gender,
#checkOutDate,
#checkOutTime,
#paymentMethod  {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


.totalLabel{
    margin-top: 5px;
    text-align: right;
}

    </style>
</head>
<body>

  <!-- Main content -->
  <main class="main-container">
        <div class="main-title">
            <p class="font-weight-bold">Check-Out</p>
        </div>

        <div class="container">
            <div class="card bg-white">
                <div class="card-body">
                    <div class ="table-container">
                    <!-- Table code -->
                    <div class="table-wrapper">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Guest Name</th>
                            <th>Contact No</th>
                            <th>Room ID</th> <!-- Updated header for rooms_id -->
                            <th>Room No</th>
                            <th>Room Type</th>
                            <th>Room Floor</th>
                            <th>Price</th>
                            <th>Adult</th>
                            <th>Children</th>
                            <th>Check-In Date</th>
                            <th>Check-In Time</th>
                            <th>Checkout Date</th>
                            <th>Checkout Time</th>
                            <th>Days</th>
                            <th>Payment Method</th>
                            <th>Reservation Fee</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result_checked as $row): ?>
                                <tr>
                                        <td><?php echo $row['checkedid']; ?></td>
                                        <td><?php echo $row['guestname']; ?></td>
                                        <td><?php echo $row['contactno']; ?></td>
                                        <td><?php echo $row['roominfoid']; ?></td>
                                        <td><?php echo $row['roomnumber']; ?></td>
                                        <td><?php echo $row['roomtype']; ?></td>
                                        <td><?php echo $row['roomfloor']; ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['adult']; ?></td>
                                        <td><?php echo $row['children']; ?></td>
                                        <td><?php echo $row['checkindate']; ?></td>
                                        <td><?php echo $row['checkintime']; ?></td>
                                        <td><?php echo $row['checkoutdate']; ?></td>
                                        <td><?php echo $row['checkouttime']; ?></td>
                                        <td><?php echo $row['days']; ?></td>
                                        <td><?php echo $row['payment_method']; ?></td>
                                        <td><?php echo $row['reservationfee']; ?></td>
                                    <td><span class="status-color" style="background-color: <?php echo ($row['status'] == 1) ? '#FFD700' : (($row['status'] == 2) ? '#808080' : 'transparent'); ?>; color: white; padding: 2px 5px; border-radius: 5px;">
                                        <?php echo ($row['status'] == 1) ? 'Checked-In' : (($row['status'] == 2) ? 'Checked-Out' : ''); ?>
                                        </span></td>
                                    <td class="action-buttons">
                                    <?php if ($row['status'] == 1) : ?>
                                        <button class="btn btn-primary checkInBtn" name="checkedId" data-checked-id="<?php echo $row['checkedid']; ?>"
                                            data-room-id="<?php echo $row['roominfoid']; ?>"
                                            data-room-no="<?php echo $row['roomnumber']; ?>"
                                            data-room-type="<?php echo $row['roomtype']; ?>"
                                            data-room-floor="<?php echo $row['roomfloor']; ?>"
                                            data-room-price="<?php echo $row['price']; ?>"
                                            data-days="<?php echo $row['days']; ?>"
                                            data-payment-method="<?php echo $row['payment_method']; ?>"
                                            data-checkin-time="<?php echo $row['checkintime']; ?>"
                                            data-checkin-date="<?php echo $row['checkindate']; ?>"
                                            data-guest-name="<?php echo $row['guestname']; ?>"
                                            data-contact-no="<?php echo $row['contactno']; ?>"
                                            data-adult="<?php echo $row['adult']; ?>" 
                                            data-children="<?php echo $row['children']; ?>"
                                            data-checkout-date="<?php echo $row['checkoutdate'];?>"
                                            data-checkout-time="<?php echo $row['checkouttime'];?>"
                                            data-checked-ids="<?php echo $row['checkedid'];?>"
                                            data-reservation-fee="<?php echo $row['reservationfee'];?>">Check-Out</button>
                                    <?php else: ?>
                                        <button class="btn btn-primary checkInBtn" name="checkedId" data-checked-id="<?php echo $row['checkedid']; ?>"
                                        data-room-id="<?php echo $row['roominfoid']; ?>"
                                            data-room-no="<?php echo $row['roomnumber']; ?>"    
                                            data-room-type="<?php echo $row['roomtype']; ?>"
                                            data-room-floor="<?php echo $row['roomfloor']; ?>"
                                            data-room-price="<?php echo $row['price']; ?>"
                                            data-days="<?php echo $row['days']; ?>"
                                            data-payment-method="<?php echo $row['payment_method']; ?>"
                                            data-checkin-time="<?php echo $row['checkintime']; ?>"
                                            data-checkin-date="<?php echo $row['checkindate']; ?>"
                                            data-guest-name="<?php echo $row['guestname']; ?>"
                                            data-contact-no="<?php echo $row['contactno']; ?>"
                                            data-adult="<?php echo $row['adult']; ?>" 
                                            data-children="<?php echo $row['children']; ?>"
                                            data-checkout-date="<?php echo $row['checkoutdate'];?>"
                                            data-checkout-time="<?php echo $row['checkouttime'];?>"
                                            data-checked-ids="<?php echo $row['checkedid'];?>"
                                            data-reservation-fee="<?php echo $row['reservationfee'];?>" disabled>Check-Out</button>
                                    <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                </div>
                    <div>

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
    </main>

    
    <div id="checkInModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>

    <h2>Check-Out Details</h2>
    <hr>
    <div class="container">
      <!-- Guest Info -->
      <div class="guest-info">
    <h3>Guest Info</h3>
    <div class="input-group-modal">
    <div class="input-item">
    <label for="guestName">Guest Name:</label> 
    <input type="text" id="guestName" name="guestName" readonly>
  </div>
  <div class="input-item">
    <label for="contactNo">Contact No:</label> 
    <input type="number" id="contactNo" name="contactNo"  readonly>
                        </div>
</div>


<div class="checkin-room">
    <h3>Check-In Room</h3>
    <div class="input-group-modal">
        <div class="input-item">
            <label for="roomId">Room ID:</label>
            <input type="number" id="roomId" name="roomId" readonly>
        </div>
        <div class="input-item">
            <label for="roomNo">Room No:</label>
            <input type="text" id="roomNo" name="roomNo" readonly>
        </div>
        <div class="input-item">
            <label for="checkInDate">Check-In Date:</label>
            <input type="date" id="checkInDate" name="checkInDate" class="form-control">
        </div>
        <div class="input-item">
            <label for="checkInTime">Check-In Time:</label>
            <input type="time" id="checkInTime" name="checkInTime">
        </div>
        <div class="input-item">
            <label for="adult">Adult:</label>
            <input type="number" id="adult" name="adult" readonly>
        </div>
        <div class="input-item">
            <label for="children">Children:</label>
            <input type="number" id="children" name="children"  readonly>
        </div>
        <div class="input-item">
            <label for="roomType">Room Type:</label>
            <input type="text" id="roomType" name="roomType" readonly>
        </div>
        <div class="input-item">
            <label for="roomPrice">Room Price:</label>
            <input type="number" id="roomPrice" name="roomPrice" readonly>
        </div>
        <div class="input-item">
            <label for="roomPrice">Reservation Fee:</label>
            <input type="text" id="reservationFee" name="reservationFee" placeholder="Reservation Fee" readonly>
        </div>
        
    <div class="order-details">
    <h3>Order Details</h3>
    <div class="input-group-modal">
        <div class="input-item">
            <input type="hidden" name="checkedids" value="<?php echo $checkedIds; ?>">
            <label for="checkedIds">Checked ID:</label>
            <button type="button" class="btnCalc" onclick="calculateTotal()">Calculate</button>
            
            <form id="checkoutForm" action="checkout.php" method="POST"> 
            <input type="text" id="checkedIds" name="checkedIds" oninput="filterTable()">
        </div>

        <div class ="table-container">
                    <!-- Table code -->
                    
                    <table id="ordersTable" class="table">
                    
                        <thead>
                            <tr>
                             <th>#</th>
                             <th>Product_Name</th>
                             <th>Category</th>
                             <th>Order QTY</th>
                             <th>Price</th>
                             <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result_orders as $row): ?>
                                <tr>
                                    <td><?php echo $row['CheckedID']; ?></td>
                                    <td><?php echo $row['ProductName']; ?></td>
                                    <td><?php echo $row['Category']; ?></td>
                                    <td><?php echo $row['OrderQuantity']; ?></td>
                                    <td>₱<?php echo $row['Price']; ?></td>
                                    <td>₱<?php echo $row['TotalAmount']; ?></td>
    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>  
                    </div>
                    </div>

                   
                
                    <label class="totalLabel">Orders Total Amount: <span id="totalAmount" name="totalAmount">0</span></label>
                    <label class="overAllLabel">Overall Amount: <span id="ovAmount" name="ovAmount">0</span></label>

                    <!-- Add hidden input fields -->
                    <input type="hidden" id="totalAmountHidden" name="totalAmount" value="0">
                    <input type="hidden" id="ovAmountHidden" name="ovAmount" value="0">
                                    
        </div>
    </div>
                        
    <div class="check-out-details">
    <h3>Check-Out Details</h3>
    <div class="input-group-modal">
        <div class="input-item">
            <input type="hidden" name="checkedid" value="<?php echo $checkedId; ?>">
            <label for="checkedId">Checked ID:</label>
            <input type="text" id="checkedId" name="checkedId">
        </div>
        <div class="input-item">
            <label for="checkOutDate">Check-Out Date:</label>
            <input type="date" id="checkOutDate" name="checkOutDate" class="form-control">
        </div>
        <div class="input-item">
            <label for="checkOutTime">Check-Out Time:</label>
            <input type="time" id="checkOutTime" name="checkOutTime">
        </div>
        <div class="input-item">
            <label for="days">Days:</label>
            <input type="text" id="days" name="days">
        </div>
        <div class="input-item">
            <label for="roomTotalPrice">Room Total Price:</label>
            <input type="hidden" id="roomTotalPriceHidden" name="roomTotalPrice">
            <input type="number" id="roomTotalPrice" name="roomTotalPrice" >
        </div>
        
        <div class="input-item">
            <label for="paymentMethod">Payment Method:</label>
            <select id="paymentMethod" name="paymentMethod">
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="debit_card">Paypal</option>
                <option value="debit_card">Gcash</option>
            </select>
        </div>
        <div class="input-item">
            <label for="paidAmount">Paid Amount:</label>
            <input type="text" id="paidAmount" name="paidAmount">
        </div>
    </div>
</div>
    </div>

        
    <div class="action-button">
    <button type="submit" class="btn btn-primary" name="update" onclick="validateCheckIn()">Check-Out</button>
    </div>
    </form>
</div>     
</div>

    
<!-- ApexCharts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
<!-- Custom JS -->
<script src="js/scripts.js"></script>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>

    <script>
     var modal = document.getElementById('checkInModal');
    var checkInBtns = document.querySelectorAll('.checkInBtn'); // Updated selector for Check-In buttons

    function openModal(event) {
    modal.style.display = 'block';

    var roomId = event.target.getAttribute('data-room-id');
var roomNo = event.target.getAttribute('data-room-no');
var roomType = event.target.getAttribute('data-room-type');
var roomPrice = event.target.getAttribute('data-room-price');
var checkedId = event.target.getAttribute('data-checked-id');
var checkInDate = event.target.getAttribute('data-checkin-date');
var checkInTime = event.target.getAttribute('data-checkin-time'); 
var checkOutDate = event.target.getAttribute('data-checkout-date');
var checkOutTime = event.target.getAttribute('data-checkout-time');
var days = event.target.getAttribute('data-days');
var paymentMethod = event.target.getAttribute('data-payment-method');
var guestName = event.target.getAttribute('data-guest-name'); // Added line
var contactNo = event.target.getAttribute('data-contact-no'); // Added line
var adults = event.target.getAttribute('data-adult'); // Added line
var children = event.target.getAttribute('data-children'); // Added line
var checkedIds = event.target.getAttribute('data-checked-ids');
var reservationfee = event.target.getAttribute('data-reservation-fee');

// Fill the modal input fields with the fetched data
document.getElementById('roomId').value = roomId;
document.getElementById('roomNo').value = roomNo;
document.getElementById('roomType').value = roomType;
document.getElementById('roomPrice').value = roomPrice;
document.getElementById('checkedId').value = checkedId; // Fill checkedId input field
document.getElementById('checkInDate').value = checkInDate;
document.getElementById('checkInTime').value = checkInTime;
document.getElementById('checkOutDate').value = checkOutDate;
document.getElementById('checkOutTime').value = checkOutTime;
document.getElementById('days').value = days;
document.getElementById('paymentMethod').value = paymentMethod;
document.getElementById('guestName').value = guestName; // Added line
document.getElementById('contactNo').value = contactNo; 
document.getElementById('checkInTime').value = checkInTime;
document.getElementById('adult').value = adults; // Added line
document.getElementById('children').value = children; // Added line
document.getElementById('checkedIds').value = checkedIds;
document.getElementById('reservationFee').value = reservationfee;


var genderSelect = document.getElementById('gender');
for (var i = 0; i < genderSelect.options.length; i++) {
    if (genderSelect.options[i].value === gender) {
        genderSelect.options[i].selected = true;
        break;
    }
}
    }
    checkInBtns.forEach(function(btn) {
        btn.addEventListener('click', openModal);
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

    function validateCheckIn() {
    var guestName = document.getElementById('guestName').value.trim();
    var contactNo = document.getElementById('contactNo').value.trim();
    var age = document.getElementById('age').value.trim();
    var gender = document.getElementById('gender').value.trim();
    var checkInDate = document.getElementById('checkInDate').value.trim();
    var checkInTime = document.getElementById('checkInTime').value.trim();
    var adult = document.getElementById('adult').value.trim();
    var children = document.getElementById('children').value.trim();

    // Check if any required field is empty
    if (guestName === '' || contactNo === '' || age === '' || gender === '' || checkInDate === '' || checkInTime === '' || adult === '' || children === '') {
        alert('Please fill in all fields.');
        return false; // Prevent form submission
    }

    // Check if Contact No is a number and has 11 digits
    if (!/^\d{11}$/.test(contactNo)) {
        alert('Contact No must be a number with exactly 11 digits.');
        return false; // Prevent form submission
    }

    // Proceed with check-in if all fields are filled and Contact No is valid
    // You can add further processing here
}
function validateNumericInput(input) {
        input.value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    }

    function validateForm(event) {
        event.preventDefault(); // Prevent form submission
        let form = document.getElementById('checkoutForm');
        let inputs = form.querySelectorAll('input, select');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('error');
            } else {
                input.classList.remove('error');
            }
        });

        if (isValid) {
            form.submit(); // Submit the form if all inputs are valid
        } else {
            // You can add error handling here, such as displaying a message to the user
            alert('Please fill in all required fields.');
        }
    }
 
</script>

<script>
 document.addEventListener("DOMContentLoaded", function() {
    const checkInDateInput = document.getElementById('checkInDate');
    const checkOutDateInput = document.getElementById('checkOutDate');
    const daysInput = document.getElementById('days');
    const roomPriceInput = document.getElementById('roomPrice');
    const roomTotalPriceInput = document.getElementById('roomTotalPrice');
    const roomTotalPriceHiddenInput = document.getElementById('roomTotalPriceHidden');
    const reservationFeeInput = document.getElementById('reservationFee'); // New input for reservation fee

    checkInDateInput.addEventListener('change', updateDays);
    checkOutDateInput.addEventListener('change', updateDays);
    roomPriceInput.addEventListener('input', updateRoomTotalPrice);
    roomTotalPriceInput.addEventListener('input', calculateOverallAmount);
    reservationFeeInput.addEventListener('input', calculateOverallAmount); // Listen for changes in reservation fee

    function updateDays() {
        const checkInDate = new Date(checkInDateInput.value);
        const checkOutDate = new Date(checkOutDateInput.value);

        if (checkOutDate < checkInDate) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Check-out date must be after check-in date',
            });
            checkOutDateInput.value = '';
            daysInput.value = '';
            return;
        }

        const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
        const diffDays = Math.round(Math.abs((checkOutDate - checkInDate) / oneDay));
        daysInput.value = diffDays;

        updateRoomTotalPrice(); // Update roomTotalPrice when days change
    }

    function updateRoomTotalPrice() {
        const days = parseInt(daysInput.value);
        const roomPrice = parseFloat(roomPriceInput.value);

        if (!isNaN(days) && !isNaN(roomPrice)) {
            const roomTotalPrice = days * roomPrice;
            roomTotalPriceInput.value = roomTotalPrice.toFixed(2);
            roomTotalPriceHiddenInput.value = roomTotalPrice.toFixed(2); // Set hidden input value

            calculateOverallAmount(); // Calculate overall amount when roomTotalPrice changes
        }
    }

    function calculateOverallAmount() {
        const roomTotalPrice = parseFloat(roomTotalPriceInput.value);
        const ordersTotalAmount = parseFloat(document.getElementById('totalAmount').textContent.replace('₱', ''));
        const reservationFee = parseFloat(reservationFeeInput.value); // Get reservation fee

        const overallAmount = roomTotalPrice + ordersTotalAmount + reservationFee; // Add reservation fee to overall amount

        // Update the displayed value in the span
        document.getElementById('ovAmount').textContent = '₱' + overallAmount.toFixed(2);

        // Set the value of hidden inputs
        document.getElementById('totalAmountHidden').value = ordersTotalAmount.toFixed(2);
        document.getElementById('ovAmountHidden').value = overallAmount.toFixed(2);

        document.getElementById('paidAmount').value = overallAmount.toFixed(2);

    }

    
});


function calculateTotal() {
    // Get the value of the checkedIds input field
    var checkedIds = document.getElementById('checkedIds').value;

    // Reset totalAmount to 0 if checkedIds is empty or not a number
    var totalAmount = (checkedIds && !isNaN(parseFloat(checkedIds))) ? 0 : '0';
    
    // Filter the table based on the checkedIds value
    filterTable(checkedIds);

    // Calculate the total amount if checkedIds is a valid number
    if (totalAmount !== '0') {
        var table = document.getElementById('ordersTable');
        var rows = table.getElementsByTagName('tr');
        for (var i = 1; i < rows.length; i++) { // Start from index 1 to skip the header row
            var row = rows[i];
            var quantity = parseInt(row.cells[3].textContent); // Assuming quantity is in the fourth column (index 3)
            var price = parseFloat(row.cells[4].textContent.replace('₱', '')); // Assuming price is in the fifth column (index 4)
            totalAmount += quantity * price;
        }
        totalAmount = '₱' + totalAmount.toFixed(2);
    }

    document.getElementById('totalAmount').textContent = totalAmount;
    document.getElementById('totalAmountHidden').value = totalAmount.replace('₱', '');
    
}

    function filterTable() {
        var checkedIds = document.getElementById('checkedIds').value;
        var table = document.getElementById('ordersTable');
        var tbody = table.querySelector('tbody');
        tbody.innerHTML = ''; // Clear existing rows
        
        // Add rows based on the checkedIds value
        <?php foreach ($result_orders as $row): ?>
            if ('<?php echo $row['CheckedID']; ?>' === checkedIds) {
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><?php echo $row['CheckedID']; ?></td>
                    <td><?php echo $row['ProductName']; ?></td>
                    <td><?php echo $row['Category']; ?></td>
                    <td><?php echo $row['OrderQuantity']; ?></td>
                    <td>₱<?php echo $row['Price']; ?></td>
                    <td>₱<?php echo $row['TotalAmount']; ?></td>
                `;
                tbody.appendChild(tr);
            }
        <?php endforeach; ?>
    }

    
    
   
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


<!-- Scripts -->

</body>
</html>