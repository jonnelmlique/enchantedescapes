<?php
// Database credentials
include('db_connection.php'); 

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT r.roominfoid, r.roomnumber, r.roomtype, r.roomfloor, rt.price, r.status
    FROM roominfo r
    JOIN room rt ON rt.roomtype = r.roomtype
    WHERE r.status = 'Available'";
    
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


// Initialize PDO and set error mode
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['insert'])) {
    // Extract data from $_POST
    $guestName = $_POST['guestName'];
    $contactNo = $_POST['contactNo'];
    $roomId = $_POST['roomId'];
    $roomNo = $_POST['roomNo'];
    $checkInDate = $_POST['checkInDate'];
    $checkInTime = $_POST['checkInTime'];
    $adult = $_POST['adult'];
    $children = $_POST['children'];
    $roomType = $_POST['roomType'];
    $roomPrice = $_POST['roomPrice'];
    $roomFloor = $_POST['roomFloor'];

    // Check room status
    $checkStatusQuery = "SELECT status FROM roominfo WHERE roominfoid = ?";
    $stmtStatus = $pdo->prepare($checkStatusQuery);
    $stmtStatus->execute([$roomId]);
    $statusResult = $stmtStatus->fetch(PDO::FETCH_ASSOC);

    if ($statusResult && $statusResult['status'] != 'Unavailable') {
        // Prepare and execute insert query
        $insertQuery = "INSERT INTO checked (guestname, contactno, roominfoid, roomnumber, roomtype, roomfloor, price, adult, children, checkindate, checkintime, status)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $stmtInsert = $pdo->prepare($insertQuery);
        $stmtInsert->execute([$guestName, $contactNo, $roomId, $roomNo, $roomType, $roomFloor, $roomPrice, $adult, $children, $checkInDate, $checkInTime]);

        // Update room status
        $updateQuery = "UPDATE roominfo SET status = 'Unavailable' WHERE roominfoid = ?";
        $stmtUpdate = $pdo->prepare($updateQuery);
        $stmtUpdate->execute([$roomId]);

        // Redirect to your page after successful check-in
        header("Location: checkin.php");
        exit;
    } else {
        echo "<script>alert('Room status is already checked in.'); window.location='checkin.php';</script>";
        exit; // Prevent further execution
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

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Added to enforce fixed layout */
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


    </style>
</head>
<body>

  <!-- Main content -->
  <main class="main-container">
        <div class="main-title">
            <p class="font-weight-bold">Check_In</p>
        </div>

        <div class="container">
            <div class="card bg-white">
                <div class="card-body">
                    <div class ="table-container">
                    <!-- Table code -->
                    <table class="table" id="table">
                        <thead>
                            <tr>
                             <th>#</th>
                             <th>Room No</th>
                             <th>Room Type</th>
                             <th>Room Price</th>
                             <th>Status</th>
                             <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row): ?>
                                <tr>
                                    <td><?php echo $row['roominfoid']; ?></td>
                                    <td><?php echo $row['roomnumber']; ?></td>
                                    <td><?php echo $row['roomtype']; ?></td>
                                    <td>₱<?php echo $row['price']; ?></td>
                                    <td><span class="status-color" style="background-color: <?php echo ($row['status'] == 'Available') ? 'green' : 'transparent'; ?>; color: white; padding: 2px 5px; border-radius: 5px;">
                                            <?php echo ($row['status'] == 'Available') ? 'Available' : 'Unavailable'; ?>
                                        </span></td>
                                    <td class="action-buttons">
                                    <button class="btn btn-primary checkInBtn" data-room-id="<?php echo $row['roominfoid']; ?>"
                                    data-room-no="<?php echo $row['roomnumber']; ?>"
                                    data-room-type="<?php echo $row['roomtype']; ?>"
                                    data-room-price="<?php echo $row['price']; ?>"
                                    data-room-floor="<?php echo $row['roomfloor']; ?>">Check-In</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div>
                </div>
            </div>
        </div>
    </main>

    
    <div id="checkInModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <form action="checkin.php" method="POST" onsubmit="return validateCheckIn()">
    <h2>Check-In Details</h2>
    <hr>
    <div class="container">
      <!-- Guest Info -->
      <div class="guest-info">
    <h3>Guest Info</h3>
    <div class="input-group-modal">
    <div class="input-item">
    <label for="guestName">Guest Name:</label> 
    <input type="text" id="guestName" name="guestName">
  </div>
  <div class="input-item">
    <label for="contactNo">Contact No:</label> 
    <input type="number" id="contactNo" name="contactNo">
  </div>

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
            <input type="text" id="roomNo" name="roomNo">
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
            <input type="number" id="adult" name="adult">
        </div>
        <div class="input-item">
            <label for="children">Children:</label>
            <input type="number" id="children" name="children">
        </div>
        <div class="input-item">
            <label for="roomType">Room Type:</label>
            <input type="text" id="roomType" name="roomType" readonly>
        </div>
        <div class="input-item">
            <label for="roomFloor">Room Floor</label>
            <input type="text" id="roomFloor" name="roomFloor" readonly>
        </div>
        <div class="input-item">
            <label for="roomPrice">Room Price:</label>
            <input type="number" id="roomPrice" name="roomPrice" readonly>
        </div>
    </div>
    <div class="submit-button">
    <button class="btn btn-primary" name="insert" >Check-In</button>
    </div>
    </form>
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
        $(document).ready(function() {
            $('#table').DataTable();
        });


</script>
                        


    <script>
     var modal = document.getElementById('checkInModal');
    var checkInBtns = document.querySelectorAll('.checkInBtn'); // Updated selector for Check-In buttons

    function openModal(event) {
        modal.style.display = 'block';

        // Fetch data from the clicked button's data attributes
        var roomId = event.target.getAttribute('data-room-id');
        var roomNo = event.target.getAttribute('data-room-no');
        var roomType = event.target.getAttribute('data-room-type');
        var roomPrice = event.target.getAttribute('data-room-price');
        var roomFloor = event.target.getAttribute('data-room-floor');
        

        // Fill the modal input fields with the fetched data
        document.getElementById('roomId').value = roomId;
        document.getElementById('roomNo').value = roomNo;
        document.getElementById('roomType').value = roomType;
        document.getElementById('roomPrice').value = roomPrice;
        document.getElementById('roomFloor').value = roomFloor;

        document.getElementById('checkInTime').value = '';
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
    var checkInDate = document.getElementById('checkInDate').value.trim();
    var checkInTime = document.getElementById('checkInTime').value.trim();
    var adult = document.getElementById('adult').value.trim();
    var children = document.getElementById('children').value.trim();

    // Check if any required field is empty
    if (guestName === '' || contactNo === '' ||  checkInDate === '' || checkInTime === '' || adult === '' || children === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill in all fields.'
        });
        return false; // Prevent form submission
    }

    // Check if Contact No is a number and has 11 digits
    if (!/^\d{11}$/.test(contactNo)) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Contact No must be a number with exactly 11 digits.'
        });
        return false; // Prevent form submission
    }

    // Proceed with check-in if all fields are filled and Contact No is valid
    // You can add further processing here
}

    function validateNumericInput(input) {
        input.value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    }

    
        </script>




</body>
</html>