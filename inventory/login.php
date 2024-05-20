<?php
session_start();
include 'dbconnection.php'; // Ensure this file exists and the path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($con) {
        // Check admin_tbl first
        $admin_query = "SELECT * FROM admin_tbl WHERE email = '$email' AND password = '$password'";
        $admin_result = mysqli_query($con, $admin_query);

        if (mysqli_num_rows($admin_result) == 1) {
            $admin_data = mysqli_fetch_assoc($admin_result);
            $_SESSION['adminName'] = $admin_data['adminName'];
            header('Location: inventory_manager.php');
            exit;
        } else {
            // Check employee_info if not found in admin_tbl
            $employee_query = "SELECT * FROM employee_info WHERE email = '$email' AND password = '$password'";
            $employee_result = mysqli_query($con, $employee_query);

            if (mysqli_num_rows($employee_result) == 1) {
                $employee_data = mysqli_fetch_assoc($employee_result);
                $_SESSION['first_name'] = $employee_data['first_name'];
                $_SESSION['last_name'] = $employee_data['last_name'];
                header('Location: staff.php');
                exit;
            } else {
                echo "<script>alert('Invalid email or password'); window.location.href='login.html';</script>";
            }
        }
    } else {
        echo "Database connection error: " . mysqli_connect_error();
    }
}
?>
