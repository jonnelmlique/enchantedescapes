<?php
// Database connection
include '../config.php';
// Assuming 'Time_in' is the current time
$timeIn = date("H:i:s");

// Assuming 'Date' is the current date
$date = date("Y-m-d");
if(isset($_POST['submit'])){

    $employeeID = mysqli_real_escape_string($conn, $_POST['Employee_ID']);
    $password = $_POST['password'];
    
    // Query to check if the provided username and password match any record in the database
    $select = "SELECT * FROM employee_info WHERE Employee_ID = '$employeeID' AND password = '$password'";
    
    $result = mysqli_query($conn, $select);
 
    if(mysqli_num_rows($result) > 0){
 
       // Redirect to attendance.php if login is successful
       header("Location: employeedashboard.php");
       exit(); // Ensure that no further code is executed after redirection
      
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file link-->
    <link rel="stylesheet" href="../style.css">

    <style>
        /* CSS to style the eye icon within the input field */
        .password-container {
            position: relative;
        }
        .password-container input[type="password"] {
            padding-right: 10px; /* Ensure space for the icon */
        }
        .password-toggle {
            position: absolute;
            right: 25px; /* Adjust the position of the icon */
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777; 
            font-size: 25px;/* Adjust icon color */
        }
    </style>
</head>
<body>
    
<div class="form-container">
   <form action="" method="post">
   <div class="login-logo">
   <h3>Employee Login</h3>
    <p id="date"><?php echo $today; ?></p>
    <p id="time" class="bold"><?php echo $time; ?></p>
  </div>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         }
      }
      ?>
      <div class="row">
      <input type="text" name="Employee_ID" placeholder="Enter your ID" required>

      </div>
      <div class="row password-container">
          <input type="password" name="password" id="password" placeholder="Password" required>
          <span class="password-toggle fa fa-fw fa-eye field-icon toggle-password" toggle="#password"></span>
      </div>
      <input type="submit" name="submit" value="Submit" class="form-btn">
   </form>
</div>

<!-- JavaScript to toggle password visibility -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordToggle = document.querySelector('.toggle-password');
    passwordToggle.addEventListener('click', function () {
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
});

function updateTime() {
    const dateElement = document.getElementById('date');
    const timeElement = document.getElementById('time');
    const now = new Date();
    const date = now.toLocaleString('en-US', { weekday: 'short', month: 'long', day: '2-digit', year: 'numeric' });
    const time = now.toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' });
    dateElement.textContent = date;
    timeElement.textContent = time;
}

// Update time initially
updateTime();

// Update time every second
setInterval(updateTime, 1000);
</script>

</body>
</html>
