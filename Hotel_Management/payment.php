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
            overflow-x: auto;
            padding: 0 20px; /* Add padding to the left and right sides */
            box-sizing: border-box; /* Include padding and border in the total width and height */
        }

        .table {
            /* Set a fixed width or max-width for the table */
            /* Adjust the value as needed to fit the container */
            max-width: 100%;
            table-layout: fixed; /* Enforce fixed layout */

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
            <p class="font-weight-bold">Payment Details</p>
        </div>
        <!-- Payment details card -->
        <div class="card bg-white">
            <div class="container">
                <div class="card-body">
                    <div class="table-container">
                        <!-- Table to display payment details -->
                        <table id="reportsTable">
                            <thead>
                                <tr>
                                    <th>Checked ID</th>
                                    <th>Room No</th>
                                    <th>Name</th>
                                    <th>Check-in Date</th>
                                    <th>Check-in Time</th>
                                    <th>Check-out Date</th>
                                    <th>Check-out Time</th>
                                    <th>Payment Method</th>
                                    <th>Total Room Amount</th>
                                    <th>Total Order Amount</th>

                                    <th>Total Amount Paid</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                        // Include database connection file
                                        include 'db_connection.php';

                                        // SQL query to fetch payment details
                                        $sql = "SELECT c.checkedid, c.roomnumber, c.guestname, c.checkindate, c.checkintime, 
                                                    c.checkoutdate, c.checkouttime, c.payment_method, 
                                                    c.room_total_price, p.ordtotalamount, p.paidamount
                                                FROM checked c
                                                INNER JOIN payments p ON c.checkedid = p.checkedids
                                                WHERE c.status = 2
                                                ORDER BY p.checkedids DESC ";

                                        $result = $conn->query($sql); // Execute the SQL query

                                        if ($result === false) {
                                            // Display SQL error if the query fails
                                            echo "Error: " . $conn->error;
                                        } else {
                                            // Check if there are any rows returned
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    // Display each row of payment details in the table
                                                    echo "<tr>";
                                                    echo "<td>" . $row["checkedid"] . "</td>";
                                                    echo "<td>" . $row["roomnumber"] . "</td>";
                                                    echo "<td>" . $row["guestname"] . "</td>";
                                                    echo "<td>" . $row["checkindate"] . "</td>";
                                                    echo "<td>" . $row["checkintime"] . "</td>";
                                                    echo "<td>" . $row["checkoutdate"] . "</td>";
                                                    echo "<td>" . $row["checkouttime"] . "</td>";
                                                    echo "<td>" . $row["payment_method"] . "</td>";
                                                    echo "<td>" . $row["room_total_price"] . "</td>";
                                                    echo "<td>" . $row["ordtotalamount"] . "</td>";
                                                    echo "<td>" . $row["paidamount"] . "</td>";
                                                    // Print button to redirect to receipt page
                                                    echo "<td><a href='print.php?pid=" . $row["checkedid"] . "' class='btn btn-primary'><i class='fa fa-print'></i> Print</a></td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                // Display a message if no records found
                                                echo "<tr><td colspan='11'>No records found</td></tr>";
                                            }
                                        }
                                        $conn->close(); // Close the database connection
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



</body>
</html>