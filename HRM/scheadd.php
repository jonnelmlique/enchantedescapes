<?php
include "sche_conn.php";

if (isset($_POST["sumbit"])) {
   
       $name = $_POST['name'];
       $email = $_POST['email'];
       $position = $_POST['position'];
       $shiftstart = $_POST['shiftstart'];
       $shiftend = $_POST['shiftend'];
   $sql = "INSERT INTO `shift`(`id`, `name`,`email`,`position`,`shiftstart`, `shiftend`) VALUES (NULL,'$name','$email','$position','$shiftstart','$shiftend')";

   $result = mysqli_query($conn, $sql);

   if ($result) {
      header("Location: schedule.php?msg=New record created successfully");
   } else {
      echo "Failed: " . mysqli_error($conn);
   }

}
?>




<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>Schedule</title>
</head>

<body>

   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color:#808080;">
   Schedule
   </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Add New user</h3>
         <p class="text-muted">Complete the form below to add a new user</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
         <form method="post" action="send-email.php">
            <div class="row mb-3">
               <div class="col">
                  <label class="name">Name:</label>
                  <input type="text" class="form-control" name="name" placeholder="">
               </div>

            <div class="row mb-3">
               <div class="col">
                  <label class="email">email:</label>
                  <input type="email" class="form-control" name="email" placeholder="">
               </div>
               <div class="row mb-3">
               <div class="col">
                  <label class="position">position:</label>
                  <input type="text" class="form-control" name="position" placeholder="">
               </div>
            </div>
               <div class="col">
                  <label class="shiftstart">shiftstart:</label>
                  <input type="datetime-local" class="form-control" name="shiftstart" placeholder="">
               </div>
               
               <div class="col">
                  <label class="shiftend">shiftend:</label>
                  <input type="datetime-local" class="form-control" name="shiftend" placeholder="">
               </div>


            <div>
               <button type="submit" class="btn btn-dark" name="submit">Save</button>
               <a href="schedule.php" class="btn btn-secondary">Cancel</a>
            
            </div>
         </form>
      </div>
   </div>


   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</nav>
</body>

</html>