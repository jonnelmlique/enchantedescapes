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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    
    
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
input[type="time"]{
  width: 100%; /* Adjust the width as needed */
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box; /* Ensures padding and border are included in the width */
}

.main-container {
            padding: 20px;
        }

        .main-title {
            margin-bottom: 20px;
        }

        .card {
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #DAA520;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-buttons button {
            background-color: #DAA520;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .action-buttons button:hover {
            background-color: #C0C0C0;
        }



/* Styling for the Submit button */
.submit-button {
  text-align: center;
}
#checkInDate,
#checkInTime,
#gender {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.dropdown {
        position: relative;
        display: inline-block;
        margin-right: 20px; /* Added margin for better spacing */
    }

    .payment-button {
        background-color: #DAA520;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        top: 40px; /* Adjusted top position */
        right: 0; /* Aligned to the right of the button */
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #DAA520;
        color: white;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .payment-button {
        background-color: #DAA520;
    }
    
    </style>
</head>
<body>
        <div class="main-container">
        <div class="main-title">
            <p class="font-weight-bold">Sales Report</p>
        </div>
            <div class="card bg-white">
            <div class="container">
                <div class="dropdown" style="margin-bottom: 20px">
                    <button class="payment-button">Sales Report</button>
                    <div class="dropdown-content">
                        <a href="#" onclick="redirectToDailySales()">Daily Sales</a>
                        <a href="#" onclick="redirectToMonthlySales()">Monthly Sales</a>
                        <a href="#" onclick="showSalesByDatesForm()">Sales by Dates</a>
                    </div>
                </div>

                    <!-- Form for Sales by Dates (Initially hidden) -->
                    <div id="salesByDatesForm" class="sales-by-dates-form" style="display: none; margin-bottom: 20px">
                        <h3>Sales by Dates</h3>
                        <form action="reps.php" method="POST"> <!-- Updated action attribute -->
                            <div class="form-group">
                                <label for="startDate">Start Date:</label>
                                <input type="date" id="startDate" name="startDate" required>
                            </div>
                            <div class="form-group" style="margin-top: 10px">
                                <label for="endDate">End Date:</label>
                                <input type="date" id="endDate" name="endDate" required>
                            </div>
                            <div class="form-group" style="margin-top: 20px">
                                <button type="submit" class="payment-button">Generate Report</button>
                            </div>
                        </form>
                    </div>

                      <!-- Form for Sales by Dates (Initially hidden) -->
                      <div id="dailysalesform" class="sales-by-dates-form" style="display: none; margin-bottom: 20px">
                        <h3>Sales by Dates</h3>
                        <form action="reps_daily.php" method="POST"> <!-- Updated action attribute -->
                            <div class="form-group">
                                <label for="dailydate">Select Date:</label>
                                <input type="date" id="dailydate" name="dailydate" required>
                            </div>

                            <div class="form-group" style="margin-top: 20px">
                                <button type="submit" class="payment-button">Generate Report</button>
                            </div>
                        </form>
                    </div>
                    
                <div class="card-body">
                    <div class ="table-container">
                        <div class="table-wrapper">
                    <!-- Table code -->
                    <table id="reportsTable">
                        <thead>
                            <tr>
                                <th>Room No</th>
                                <th>Name</th>
                                <th>Room Type</th>
                                <th>Room Price</th>
                                <th>Check-in Date</th>
                                <th>Check-in Time</th>
                                <th>Check-out Date</th>
                                <th>Check-out Time</th>
                                <th>Days</th>
                                <th>Payment Method</th>
                                <th>Total Room Amount</th>
                                <th>Total Order Amount</th>
                                <th>Total Amount Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
include('db_connection.php'); 

$sql = "SELECT 
    c.checkedid,
    c.guestname,
    c.contactno,
    c.roomnumber,
    c.price, 
    c.room_total_price, 
    c.checkindate, 
    c.checkintime, 
    c.checkoutdate, 
    c.checkouttime, 
    c.days,
    c.payment_method,
    c.adult,
    c.roomtype,
    c.children,
    c.status,
    c.reservationfee,
    p.overallamount,
    p.ordtotalamount,
    p.paidamount
FROM 
    checked c
INNER JOIN
    payments p ON p.checkedids = c.checkedid 
WHERE 
    c.status = 2";

$result = $conn->query($sql);

if (!$result) {
    echo "Error executing query: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["roomnumber"] . "</td>";
        echo "<td>" . $row["guestname"] . "</td>";
        echo "<td>" . $row["roomtype"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["checkindate"] . "</td>";
        echo "<td>" . $row["checkintime"] . "</td>";
        echo "<td>" . $row["checkoutdate"] . "</td>";
        echo "<td>" . $row["checkouttime"] . "</td>";
        echo "<td>" . $row["days"] . "</td>";
        echo "<td>" . $row["payment_method"] . "</td>";
        echo "<td>" . $row["room_total_price"] . "</td>";
        echo "<td>" . $row["paidamount"] . "</td>";
        // Calculate and display Total Amount Paid (Total Room Amount + Total Order Amount)
        $totalAmountPaid = $row["room_total_price"] + $row["paidamount"];
        echo "<td>" . $totalAmountPaid . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13'>No records found</td></tr>";
}
}

$conn->close();
?>
                </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Scripts -->
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<!-- Custom JS -->
<script src="js/scripts.js"></script>

<script>
    $(document).ready(function() {
        $('#reportsTable').DataTable();
    });
</script>

<script>
    function toggleSalesByDatesForm() {
        var salesByDatesForm = document.getElementById('salesByDatesForm');
        if (salesByDatesForm.style.display === 'none') {
            salesByDatesForm.style.display = 'block';
        } else {
            salesByDatesForm.style.display = 'none';
        }
    }

    function showSalesByDatesForm() {
        var salesByDatesForm = document.getElementById('salesByDatesForm');
        salesByDatesForm.style.display = 'block';
    }

    function generateSalesReport() {
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;

            // You can perform further actions here, such as sending AJAX request to fetch sales data for the specified dates and displaying them in the table

            // For now, let's just log the selected dates
            console.log('Start Date:', startDate);
            console.log('End Date:', endDate);

            // Redirect to rep.php
            window.location.href = "reps.php";
        }

        // Attach event listener to the "Generate Report" button
        document.getElementById('generateReportButton').addEventListener('click', generateSalesReport);4

        // Function to redirect to reps.php with the current date
        function redirectToDailySales() {
        // Get the current date
        var currentDate = new Date().toISOString().split('T')[0];

        // Construct the URL with the current date
        var url = "reps_daily.php?date=" + currentDate;

        // Redirect the user to the constructed URL
        window.location.href = "reps_daily.php";
    }

    function redirectToMonthlySales() {
        // Redirect to reps_monthly.php
        window.location.href = "reps_monthly.php";
    }
</script>


</body>
</html>