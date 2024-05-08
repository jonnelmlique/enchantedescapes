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
    $sql = "SELECT ri.roominfoid, ri.roomtype, ri.roomnumber, ri.roomfloor,
        rs.firstname, rs.mobilenumber, rs.adults, rs.children, rs.checkindate, rs.checkintime, rs.checkoutdate, rs.checkouttime, rs.price, rs.totalafterpromo, rs.status
        FROM reservationprocess rs
        INNER JOIN roominfo ri ON ri.roomnumber = rs.roomnumber
        WHERE rs.status = 'Accepted'";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    
    // Execute the SQL statement
    $stmt->execute();
    
    // Fetch all rows as associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database connection error
    die("Connection failed: " . $e->getMessage());
}


$conn = new mysqli($host, $username, $password, $dbname);


try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the checked row's data from the hidden input field
        $checkedData = $_POST['checked_data'];

        // Split the checked data into individual values (assuming tab-separated values)
        $checkedValues = explode("\t", $checkedData);

        // Assign the values to variables
        $roominfoid = $checkedValues[0]; // Assuming roominfoid is the first item in the checked data
        $guestname = $checkedValues[1];
        $firstname = $checkedValues[1];
        $contactno = $checkedValues[2];
        $roomnumber = $checkedValues[3];
        $roomfloor = $checkedValues[4];
        $roomtype = $checkedValues[5];
        $price = $checkedValues[6];
        $checkindate = $checkedValues[7];
        $checkintime = $checkedValues[8];
        $checkoutdate = $checkedValues[9];
        $checkouttime = $checkedValues[10];
        $adult = $checkedValues[11];
        $children = $checkedValues[12];
        $totalafterpromo = $checkedValues[13];

        // Start a transaction
        $pdo->beginTransaction();

        // Insert the checked row's data into the checked table
        $sqlInsertChecked = "INSERT INTO checked (roominfoid, guestname, contactno, roomnumber, roomfloor, roomtype, price, checkindate, checkintime, checkoutdate, checkouttime, adult, children, reservationfee) 
                            VALUES (:roominfoid, :guestname, :contactno, :roomnumber, :roomfloor, :roomtype, :price, :checkindate, :checkintime, :checkoutdate, :checkouttime, :adult, :children, :reservationfee)";
        $stmtInsertChecked = $pdo->prepare($sqlInsertChecked);
        $stmtInsertChecked->execute(array(
            ':roominfoid' => $roominfoid,
            ':guestname' => $guestname,
            ':contactno' => $contactno,
            ':roomnumber' => $roomnumber,
            ':roomfloor' => $roomfloor,
            ':roomtype' => $roomtype,
            ':price' => $price,
            ':checkindate' => $checkindate,
            ':checkintime' => $checkintime,
            ':checkoutdate' => $checkoutdate,
            ':checkouttime' => $checkouttime,
            ':adult' => $adult,
            ':children' => $children,
            ':reservationfee' => $totalafterpromo
        ));

        // Update the status in the reservationprocess table to 'Check-In'
        $updateQuery = "UPDATE reservationprocess SET status = 'Check-In' WHERE firstname = ?";
        $stmtUpdate = $pdo->prepare($updateQuery);
        $stmtUpdate->execute([$firstname]);

        // Commit the transaction
        $pdo->commit();

        echo "Checked data inserted successfully and status updated!";
    }
} catch (PDOException $e) {
    // Handle database connection or transaction error
    $pdo->rollBack(); // Roll back the transaction if an error occurs
    die("Error: " . $e->getMessage());
}

$conn->close();
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

        table th, .table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            white-space: nowrap; /* Added to prevent line breaks */
            overflow: hidden; /* Added to hide overflow */
            text-overflow: ellipsis; /* Added to show ellipsis for overflow */
        }      

        

        
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }


        .action-buttons {
            display: flex;
            justify-content: space-between;
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
            background-color: #DAA520;
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

        @media (max-width: 768px) {
            .search-bar {
                width: 100%;
                margin-bottom: 10px;
                float: none; /* Reset float for mobile */
            }

            .btn-primary, .btn-danger, .btn-secondary {
                width: 100%;
            }

        }

    </style>
</head>
<body>

<main class="main-container">
    <div class="main-title">
        <p class="font-weight-bold">BOOKING</p>
    </div>

    <div class="container">
        <div class="card bg-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Search bar code -->
                    <div class="search-bar">
                        <input type="text" placeholder="Search..." class="form-control">
                        <span class="material-icons-outlined text-primary">search</span>
                    </div>
                </div>
              
                <div class="table-container">
                <form method="post" action="booking.php" id="checkInForm"> <!-- Add form tags with an action to process_checked.php -->
                  <input type="hidden" name="checked_data" id="checkedData">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>#</th>
                                <th>Guest Name</th>
                                <th>Phone Number</th>
                                <th>Room Number</th>
                                <th>Room Floor</th>
                                <th>Room Type</th>
                                <th>Price</th>
                                <th>Check-in Date</th>
                                <th>Check-in Time</th>
                                <th>Check-out Date</th>
                                <th>Check-out Time</th>
                                <th>Adults</th>
                                <th>Children</th>
                                <th>Reservation Fee</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row): ?>
                                <tr>
                                <td><input type="checkbox" name="row_checkbox[]" value="<?php echo $row['roominfoid']; ?>" onclick="handleCheckbox(this)"></td> 
                                    <td><?php echo $row['roominfoid']; ?></td>
                                    <td><?php echo $row['firstname']; ?></td>
                                    <td><?php echo $row['mobilenumber']; ?></td>
                                    <td><?php echo $row['roomnumber']; ?></td>
                                    <td><?php echo $row['roomfloor']; ?></td>
                                    <td><?php echo $row['roomtype']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['checkindate']; ?></td>
                                    <td><?php echo $row['checkintime']; ?></td>
                                    <td><?php echo $row['checkoutdate']; ?></td>
                                    <td><?php echo $row['checkouttime']; ?></td>
                                    <td><?php echo $row['adults']; ?></td>
                                    <td><?php echo $row['children']; ?></td>
                                    <td><?php echo $row['totalafterpromo']; ?></td>
                                    <td class="fixed">
                                        <?php
                                            if ($row['status'] == 'Accepted') {
                                                echo '<span style="background-color: #D2691E; color: white; padding: 2px 5px; border-radius: 3px; font-weight: bold; font-size: 14px;">Accepted</span>';
                                            } else if ($row['status'] == 'Check-In') {
                                                echo '<span style="background-color: green; color: white; padding: 2px 5px; border-radius: 3px; font-weight: bold; font-size: 14px;">Checked-In</span>';
                                            } else if ($row['status'] == 3) {
                                                echo '<span style="background-color: red; color: white; padding: 2px 5px; border-radius: 3px; font-weight: bold; font-size: 14px;">Cancelled</span>';
                                            }
                                        ?>
                                    </td>
                                    
                                    <td class="action-buttons">
                                    <button type="submit" class="btn btn-secondary">Check-In</button> <!-- Add submit button to trigger form submission -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                   
                </div>
                
                <!-- Pagination -->
                <?php
                    // Count total records
                    $sql_count = "SELECT COUNT(*) AS count FROM reservationprocess";
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
 function handleCheckbox(checkbox) {
        var checkedData = document.getElementById('checkedData');
        var rowData = checkbox.closest('tr').innerText.trim(); // Get the text content of the checked row
        checkedData.value = rowData; // Update the hidden input field with the checked row's data
    }
</script>
<!-- Scripts -->
<!-- ApexCharts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
<!-- Custom JS -->
<script src="js/scripts.js"></script>

</body>
</html>