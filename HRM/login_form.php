<?php

include 'config.php';

$currentDateTime = new DateTime();
$time = $currentDateTime->format("h:i:s A"); 
$today = $currentDateTime->format("D, F j, Y"); 
if(isset($_POST['submit'])){
   $adminID = mysqli_real_escape_string($conn, $_POST['adminID']);
   $password = $_POST['password'];
   
   $select = "SELECT * FROM admin_tbl WHERE adminID = '$adminID' AND password = '$password'";
   
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);
      if($row['Department'] === 'HRM Department'){
         header("Location: attendance.php");
         exit();
         
      } else {
         $error[] = 'User is not from the HRM Department!';
      }
   } else {
      $error[] = 'Incorrect ID or password!';
   }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Login Form</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file link-->
    <link rel="stylesheet" href="style.css">

    <style>
    /* CSS to style the eye icon within the input field */
    .password-container {
        position: relative;
    }

    .password-container input[type="password"] {
        padding-right: 10px;
        /* Ensure space for the icon */
    }

    .password-toggle {
        position: absolute;
        right: 25px;
        /* Adjust the position of the icon */
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #777;
        font-size: 25px;
        /* Adjust icon color */
    }
    </style>
</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>Admin Login</h3>
            <p id="date"></p> <!-- Display current date -->
            <p id="time" class="bold"></p> <!-- Display current time -->

            <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         }
      }
      ?>

            <div class="row">
                <input type="text" name="adminID" placeholder="Enter your ID" required>
            </div>
            <div class="row password-container">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="password-toggle fa fa-fw fa-eye field-icon toggle-password" toggle="#password"></span>
            </div>
            <input type="submit" name="submit" value="Login Now" class="form-btn">
        </form>
    </div>

    <!-- JavaScript to toggle password visibility and update time -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordToggle = document.querySelector('.toggle-password');
        passwordToggle.addEventListener('click', function() {
            const passwordField = document.querySelector(this.getAttribute('toggle'));
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });

        // Function to update the time every second
        function updateTime() {
            const now = new Date();
            const timeElement = document.getElementById('time');
            const timeString = now.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });
            timeElement.textContent = timeString;
        }

        // Update time initially and then every second
        updateTime();
        setInterval(updateTime, 1000);

        // Function to update the date
        function updateDate() {
            const now = new Date();
            const dateElement = document.getElementById('date');
            const options = {
                weekday: 'short',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const dateString = now.toLocaleDateString('en-US', options);
            dateElement.textContent = dateString;
        }

        // Update date initially
        updateDate();
    });
    </script>

</body>

</html>