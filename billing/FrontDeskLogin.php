<?php
session_start(); // Start the session to store user data
include('db_connection.php'); 
if (isset($_POST['submitbtn'])) {
    $username = $_POST['name']; // Assuming 'name' is the name attribute for the email input
    $password = $_POST['pass']; // Assuming 'pass' is the name attribute for the password input

    // SQL query to check if the username and password match a record in the database
    $sql = "SELECT * FROM admin_tbl WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // User found, set session variables for successful login
        $_SESSION['email'] = $username;
        $_SESSION['login_success'] = true; // Set session variable for successful login
        $_SESSION['success_message'] = 'Login Successful'; // Set success message
        header("Location: Dashboard.php"); // Redirect to your dashboard page after successful login
        exit();
    } else {
        // User not found or invalid credentials
        $_SESSION['error_message'] = 'Invalid username or password'; // Set error message
        header("Location: ./FrontDeskLogin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <video id="video-background" autoplay loop muted>
        <source src="img/vid2.mp4" type="video/mp4">
    </video>

    <div class="form-container">
        <form action="" method="POST" id="loginForm" onsubmit="return validateForm()"> <!-- Added onsubmit event for form validation -->
            <img src="img/hotel_logo.png" alt="img">
            <div class="input_form">
                <h3>Login Now</h3>
                <label for="username">Email:</label>
                <input type="text" id="username" name="name" class="box" placeholder="Enter Your Email Address">
                <label for="password">Password:</label>
                <input type="password" id="password" name="pass" class="box"  placeholder="Enter Your Password">
                <input type="submit" name="submitbtn" value="LOGIN" class="btn">
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        function validateForm() {
            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();

            if (username === '' || password === '') {
                // Display error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill in all fields.',
                    confirmButtonText: 'OK'
                });
                return false; // Prevent form submission
            }
            return true; // Proceed with form submission
        }


        var errorMessage = "<?php echo isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '' ?>";
    if (errorMessage !== '') {
        Swal.fire({
            icon: 'error',
            title: 'Login Error',
            text: errorMessage,
            confirmButtonText: 'OK'
        });
        // Clear the error message from the session
        <?php unset($_SESSION['error_message']); ?>
    }
    </script>
</body>
</html>
