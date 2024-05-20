<?php
// Include necessary files
include "db_conn.php";
include "sidebar.php";

// Initialize variables to store form data
$employeeId = $start_date = $end_date = $time_in = $time_out = $schedule_days = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employeeId = $_POST['Employee_ID'];
    $Name = $_POST['Name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $schedule_days = implode(",", $_POST['days']); // Combine selected days into a comma-separated string

    // Check if the employee already has a schedule within the specified date range
    $check_sql = "SELECT * FROM schedule WHERE Employee_ID = '$employeeId' AND ('$start_date' BETWEEN start_date AND end_date OR '$end_date' BETWEEN start_date AND end_date)";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        // Employee already has a schedule within the specified date range, display an error message
        echo "<script>alert('Employee already has a schedule within the specified date range!');</script>";
    } else {
        // Prepare and execute SQL statement to insert schedule into the database
        $sql = "INSERT INTO schedule (Employee_ID, Name, start_date, end_date, Time_in, Time_out, schedule_days) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $employeeId, $Name, $start_date, $end_date, $time_in, $time_out, $schedule_days);

        if ($stmt->execute()) {
            // Redirect to schedule.php
            echo "<script>window.location.href = 'schedule.php?msg=New Schedule created successfully';</script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
    
    <!-- Your existing CSS and external dependencies -->

    <style>
        /* CSS to align checkboxes and labels horizontally */
        .checkbox-container label {
            display: inline-block;
            width: 100px; /* Adjust the width as needed */
        }

        /* CSS to align start date and end date horizontally */
        .date-container input[type="date"] {
            display: inline-block;
            width: calc(20% - 5px); /* Adjust the width as needed */
            margin-right: 10px;
            margin-bottom: 20px;
            border-radius: 5px; /* Rounded corners */
        }

        /* CSS to align time-in and time-out horizontally */
        .time-container input[type="time"] {
            display: inline-block;
            width: calc(20% - 5px); /* Adjust the width as needed */
            margin-right: 10px;
            border-radius: 5px; /* Rounded corners */
        }

        .name-container input[type="text"] {
            display: inline-block;
            width: calc(20% - 5px); /* Adjust the width as needed */
            margin-right: 10px;
            margin-bottom: 20px;
            border-radius: 5px; /* Rounded corners */
        }

        /* Rounded corners for checkboxes */
        .checkbox-container input[type="checkbox"] {
            border-radius: 5px;
        }

        /* Rounded corners for submit button */
        input[type="submit"] {
            border-radius: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080; color: white;">Add New Schedule
        </nav><br><br>
    <form method="post" action="">
        <div class="name-container">
            <label for="Employee_ID">Employee ID:</label><br>
            <input type="text" id="Employee_ID" name="Employee_ID" required><br><br>

            <label for="Name">Employee Name:</label><br>
            <input type="text" id="Name" name="Name" readonly><br><br>
        </div>

        <div class="date-container">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
        </div>

        <div class="time-container">
            <label for="time_in">Time-in:</label>
            <input type="time" id="time_in" name="time_in" required>
            <label for="time_out">Time-out:</label>
            <input type="time" id="time_out" name="time_out" required>
        </div><br><br>

        <label for="days">Select Days:</label>
        <div class="checkbox-container">
            <input type="checkbox" id="day_monday" name="days[]" value="Monday">
            <label for="day_monday">Monday</label>
            <input type="checkbox" id="day_tuesday" name="days[]" value="Tuesday">
            <label for="day_tuesday">Tuesday</label>
            <input type="checkbox" id="day_wednesday" name="days[]" value="Wednesday">
            <label for="day_wednesday">Wednesday</label>
            <input type="checkbox" id="day_thursday" name="days[]" value="Thursday">
            <label for="day_thursday">Thursday</label>
            <input type="checkbox" id="day_friday" name="days[]" value="Friday">
            <label for="day_friday">Friday</label>
            <input type="checkbox" id="day_saturday" name="days[]" value="Saturday">
            <label for="day_saturday">Saturday</label>
            <input type="checkbox" id="day_sunday" name="days[]" value="Sunday">
            <label for="day_sunday">Sunday</label>
        </div><br><br>
        <button type="submit" class="btn btn-dark" name="submit">Add Schedule</button>
        <!-- <input type="submit" value="Add Schedule"> -->
    </form>

    <script>
        document.getElementById('start_date').addEventListener('change', function () {
            var startDate = new Date(this.value);
            var endDateField = document.getElementById('end_date');
            var endDate = new Date(endDateField.value);
            if (endDate < startDate) {
                endDateField.value = ''; // Reset end date if it's before the start date
            }
            endDateField.min = this.value; // Set the minimum allowed end date
        });

        document.getElementById('Employee_ID').addEventListener('change', function () {
            var employeeId = this.value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('Name').value = xhr.responseText;
                    } else {
                        console.error('Error fetching employee name');
                        // Clear the name field if an error occurs
                        document.getElementById('Name').value = '';
                    }
                }
            };
            xhr.open('GET', 'get_employee_name.php?Employee_ID=' + employeeId, true);
            xhr.send();
        });

        // Calculate time_out based on time_in
        document.getElementById('time_in').addEventListener('change', function () {
            var time_in = this.value;
            var time_in_hours = parseInt(time_in.split(':')[0]);
            var time_out_hours = time_in_hours + 8; // Adding 8 hours to time_in
            var time_out_minutes = time_in.split(':')[1]; // Keeping the minutes the same
            var time_out = (time_out_hours < 10 ? '0' : '') + time_out_hours + ':' + time_out_minutes;
            document.getElementById('time_out').value = time_out;
        });
    </script>
</body>
</html>
