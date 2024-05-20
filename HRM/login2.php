<?php
include 'config.php';

date_default_timezone_set('Asia/Manila');
$time = date("h:i:s A");
$today = date("D, F j, Y");
try {

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imageData = $_POST['imageData'];
    $img = str_replace('data:image/jpeg;base64,', '', $imageData);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $imageName = uniqid() . '.jpg';
    $filePath = './uploads/' . $imageName;
    $employee_ID = $_POST['employee_ID'];
    $password = $_POST['password'];

    $sql = "SELECT Employee_ID, password, first_name, last_name FROM employee_info WHERE Employee_ID = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die("Error preparing statement: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ss", $employee_ID, $password);
    $execute_success = mysqli_stmt_execute($stmt);
    if (!$execute_success) {
        die("Error executing statement: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $employeeId, $dbPassword, $fname, $lname);
    mysqli_stmt_fetch($stmt);

    if ($dbPassword === $password && $employeeId === $employee_ID) {
        mysqli_stmt_close($stmt);

        $sql_check_sched = "SELECT start_date, end_date, Time_in, Time_out, schedule_days FROM `schedule` WHERE Employee_ID = ? AND schedule_days LIKE ? AND ? BETWEEN start_date AND end_date";
        $stmt_check_sched = mysqli_prepare($conn, $sql_check_sched);
        $currentDate = date("Y-m-d");
        $currentDayName = "%" . date("l") . "%";
        mysqli_stmt_bind_param($stmt_check_sched, "sss", $employee_ID, $currentDayName, $currentDate);
        $execute_success = mysqli_stmt_execute($stmt_check_sched);
        if (!$execute_success) {
            die("Error executing statement: " . mysqli_stmt_error($stmt_check_sched));
        }
        mysqli_stmt_store_result($stmt_check_sched);
        mysqli_stmt_bind_result($stmt_check_sched, $start_date, $end_date, $time_in, $time_out, $schedule_days);
        mysqli_stmt_fetch($stmt_check_sched);

        if (mysqli_stmt_num_rows($stmt_check_sched) > 0) {
            mysqli_stmt_close($stmt_check_sched);

            $sql_check_time_in = "SELECT id,Time_in, Timeout_img FROM pending_attendance WHERE employee_ID = ? AND Date = CURDATE()";
            $stmt_check_time_in = mysqli_prepare($conn, $sql_check_time_in);
            mysqli_stmt_bind_param($stmt_check_time_in, "s", $employee_ID);
            $execute_success = mysqli_stmt_execute($stmt_check_time_in);
            if (!$execute_success) {
                die("Error executing statement: " . mysqli_stmt_error($stmt_check_time_in));
            }
            mysqli_stmt_store_result($stmt_check_time_in);
            mysqli_stmt_bind_result($stmt_check_time_in, $pending_attendance_id, $timed_in, $img);
            mysqli_stmt_fetch($stmt_check_time_in);

            $current_time = date("H:i:s");
            if ($timed_in === "" || $timed_in === null) {
                if (strtotime($time_in) <= strtotime($current_time)) {
                    $sql_insert = "INSERT INTO pending_attendance (employee_ID, Date, Time_in, Timein_img) VALUES (?, CURDATE(), CURTIME(), ?)";
                    $stmt_insert = mysqli_prepare($conn, $sql_insert);
                    if ($stmt_insert === false) {
                        die("Error preparing statement: " . mysqli_error($conn));
                    }
                    mysqli_stmt_bind_param($stmt_insert, "ss", $employee_ID, $imageName);
                    $execute_success = mysqli_stmt_execute($stmt_insert);
                    if (!$execute_success) {
                        die("Error executing statement: " . mysqli_stmt_error($stmt_insert));
                    }
                   // After the image saving attempts

if (!file_exists('./uploads/')) {
    if (!mkdir('./uploads/', 0777, true)) {
        die('Failed to create directory...');
    }
}

if (file_put_contents($filePath, $data)) {
    echo "Image saved successfully.";
} else {
    echo "Error: Failed to save the image.";
    // Debugging info
    echo "Debugging info: " . error_get_last()['message'];
}
                    echo "Welcome $lname,$fname! You have successfully Time-in at $time on $today.";
                } else {
                    echo "You cannot time in yet. You're scheduled to time in on : " . $time_in;
                }
            } else {
                if (strtotime($time_out) <= strtotime($current_time)) {
                    $sql_update = "UPDATE pending_attendance SET Time_out = CURTIME(), Timeout_img = ? WHERE id = ?";
                    $stmt_update = mysqli_prepare($conn, $sql_update);
                    if ($stmt_update === false) {
                        die("Error preparing statement: " . mysqli_error($conn));
                    }
                    mysqli_stmt_bind_param($stmt_update, "ss", $imageName, $pending_attendance_id);
                    $execute_success = mysqli_stmt_execute($stmt_update);
                    if (!$execute_success) {
                        die("Error executing statement: " . mysqli_stmt_error($stmt_update));
                    }
                    if (strtotime($current_time) - strtotime($time_out) >= 20 * 60) {
                        echo "This checkout will be considered as overtime <br>";
                        $sql_overtime_insert = "INSERT INTO overtime_tbl VALUES (default, ?, ?, CURDATE(), ?, ?)";
                        $stmt_overtime_insert = mysqli_prepare($conn, $sql_overtime_insert);
                        if ($stmt_overtime_insert === false) {
                            die("Error preparing statement: " . mysqli_error($conn));
                        }
                        $time_diff_seconds = abs(strtotime($current_time) - strtotime($time_out));
                        $hours = floor($time_diff_seconds / 3600);
                        $minutes = floor(($time_diff_seconds % 3600) / 60);
                        mysqli_stmt_bind_param($stmt_overtime_insert, "ssss", $employee_ID, $lname, $hours, $minutes);
                        $execute_success = mysqli_stmt_execute($stmt_overtime_insert);
                        if (!$execute_success) {
                            die("Error executing statement: " . mysqli_stmt_error($stmt_overtime_insert));
                        }
                    }
                    $sql_emp_rec_insert = "INSERT INTO employee_record VALUES (default, ?, CURDATE(), ?, ?, 8, 1,0)";
                    $stmt_emp_rec_insert = mysqli_prepare($conn, $sql_emp_rec_insert);
                    if ($stmt_emp_rec_insert === false) {
                        die("Error preparing statement: " . mysqli_error($conn));
                    }
                    mysqli_stmt_bind_param($stmt_emp_rec_insert, "sss", $employee_ID, $timed_in, $current_time);
                    $execute_success = mysqli_stmt_execute($stmt_emp_rec_insert);
                    if (!$execute_success) {
                        die("Error executing statement: " . mysqli_stmt_error($stmt_emp_rec_insert));
                    }
                    if (!file_exists('../employee/uploads')) {
                        mkdir('../employee/uploads', 0777, true);
                    }
                    if (file_put_contents($filePath, $data)) {
                    } else {
                        echo "Error: Failed to save the image.";
                    }
                    echo "Thank you for your work! You have successfully Time-out at $time on $today.";
                } else {
                    echo "You cannot time out yet. You're scheduled to time out on : " . $time_out;
                }
            }
            mysqli_stmt_close($stmt_check_time_in);
        } else {
            echo "This employee does not have a schedule in this day yet. Please contact your admin.";
        }
    } else {
        echo "Error: Invalid credentials.";
    }
    mysqli_close($conn);
}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Image Capture</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="employee.css">
</head>

<body>
    <div id="container">
        <div id="login-form">
            <a href="employeeschedule.php"><button id="Schedule">View Schedules</button></a>
            <p id="date"></p>
            <p id="time" class="bold"></p>
            <video id="video" autoplay></video>
            <form action="login2.php" method="post">
                <canvas id="canvas" style="display: none;"></canvas>
                <br>
                <input type="text" name="employee_ID" placeholder="Employee ID" required>
                <br>
                <div class="password-container">
                    <input type="password" name="password" placeholder="Password" id="password" required>
                    <span class="password-toggle fa fa-eye field-icon toggle-password" toggle="#password"></span>
                </div>
                <br>
                <input type="hidden" name="imageData" id="imageData">
                <button id="capture">Submit</button>
            </form>

        </div>
    </div>

    <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('capture');

    navigator.mediaDevices.getUserMedia({
            video: true
        })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            console.error('Error accessing webcam:', err);
        });

    captureButton.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/jpeg');
        document.getElementById('imageData').value = imageData;
        const capturedImage = new Image();
        capturedImage.src = imageData;
        document.body.appendChild(capturedImage);
    });

    setInterval(() => {
        const now = new Date();
        const dateElement = document.getElementById('date');
        const timeElement = document.getElementById('time');
        dateElement.textContent = formatDate(now);
        timeElement.textContent = formatTime(now);
    }, 1000);

    function formatDate(date) {
        const options = {
            weekday: 'short',
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        };
        return date.toLocaleDateString('en-US', options);
    }

    function formatTime(date) {
        const hours = date.getHours() % 12 || 12;
        const minutes = ('0' + date.getMinutes()).slice(-2);
        const seconds = ('0' + date.getSeconds()).slice(-2);
        const ampm = date.getHours() >= 12 ? 'PM' : 'AM';
        return `${hours}:${minutes}:${seconds} ${ampm}`;
    }

    const togglePassword = document.querySelector('.toggle-password');
    const passwordField = document.querySelector('#password');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>

</html>