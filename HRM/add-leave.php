<?php
include "config.php";

if(isset($_GET['Employee_ID'])) {
   // Retrieve the employee ID from the GET request
   $employeeId = $_GET['Employee_ID'];

   // Prepare and execute the query to retrieve the employee name
   $sql = "SELECT CONCAT(first_name, ' ', last_name, ' ', middle_name) AS full_name FROM employee_info WHERE Employee_ID = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("s", $employeeId);
   $stmt->execute();
   $result = $stmt->get_result();

   // Check if any rows are returned
   if ($result->num_rows > 0) {
       // Fetch the row and retrieve the employee name
       $row = $result->fetch_assoc();
       $employeeName = $row['full_name'];
       // Output the employee name
       echo $employeeName;
   } else {
       // If no rows are returned, output an error message or an empty string
       echo "Employee not found";
   }
} 

$reasonErr = $absenceErr = $fromdateErr = $todateErr = "";
$leaveApplicationValidate = true; // Initialize validation variable

if(isset($_POST['submit'])){
    if(empty($_POST['absence'])){
        $absenceErr = "Please select absence type";
        $leaveApplicationValidate = false;
    } else {
        $absence = implode(",", $_POST['absence']);
    }

    if(empty($_POST['fromdate'])){
        $fromdateErr = "Please Enter starting date";
        $leaveApplicationValidate = false;
    } else {
        $fromdate = mysqli_real_escape_string($conn, $_POST['fromdate']);
    }

    if(empty($_POST['todate'])){
        $todateErr = "Please Enter ending date";
        $leaveApplicationValidate = false;
    } else {
        $todate = mysqli_real_escape_string($conn, $_POST['todate']);
    }

    $reason = mysqli_real_escape_string($conn,$_POST['reason']);

    if(empty($reason)){
      $reasonErr = "Please give reason for the leave in detail";
      $leaveApplicationValidate = false;
    }
    else{
      $absencePlusReason = $absence." : ".$reason;
      $leaveApplicationValidate = true;
    }
    
    $status = "Pending";
    
    if($leaveApplicationValidate){
        // Fetch employee ID based on the provided name
        $name = mysqli_real_escape_string($conn, $_POST['ename']);

        // Run the query to retrieve the Employee_ID based on the provided name
        $query = "SELECT employee_info.Employee_ID FROM employee_info WHERE CONCAT(first_name, ' ', last_name, ' ', middle_name) = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

 }
}
?>
<?php

if(isset($_POST['submit'])){
    // Get data from the form
    $employeeId = mysqli_real_escape_string($conn, $_POST['eid']);
    $employeeName = mysqli_real_escape_string($conn, $_POST['ename']);
    $fromdate = mysqli_real_escape_string($conn, $_POST['fromdate']);
    $todate = mysqli_real_escape_string($conn, $_POST['todate']);
    $status = "Pending";

    // Process leave types
    if(isset($_POST['absence'])){
        $reasons = $_POST['absence'];
        $reason = implode(",", $reasons) . " : " . mysqli_real_escape_string($conn, $_POST['reason']);
    } else {
        $reason = "";
    }

    $sql = "INSERT INTO leaves (eid, ename, descr, fromdate, todate, status) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("isssss", $employeeId, $employeeName, $reason, $fromdate, $todate, $status);
    
    if ($stmt->execute()) {
       echo "<script>window.location.href = 'leave.php?msg=Leave successfully created';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $stmt->close();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>Add Leave</title>
   <style>

    .all{
      padding-left;50px;
    }
      .container {
         
        padding-right: 200px;
   margin-left:13pc;
        
      }
   </style>
</head>

<body>

   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #808080;">
      Add Leave
   </nav>
   <div class="all">
   <div class="container">
      <div class="row ">
         <div class="col-md-6 center-form">
            <form action="" method="post" enctype="multipart/form-data">

               <br>


               <div class="name-container">
                  <label for="Employee_ID">Employee ID:</b></label>
                  <input type="text" id="Employee_ID" name="eid" required><br><br>

                  <label for="Name">Employee Name:</b></label>
                            <input type="text" id="Name" name="ename" readonly><br>
                        </div>


               <br>
               <div class="mb-3 ">
                  <label for="dates"><b>From -</b></label>
                  <input type="date" id="start_date" name="fromdate" required>

                  <label for="dates"><b>To -</b></label>
                  <input type="date" id="end_date" name="todate" required>
               </div>


               <br>

               <label><b>Select Leave Type :</b></label>
               <!-- error message if type of absence isn't selected -->
               <span class="error"><?php echo "&nbsp;".$absenceErr ?></span><br />
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="Sick" id="Sick">
                  <label class="form-check-label" for="Sick">
                     Sick
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="Casual" id="Casual">
                  <label class="form-check-label" for="Casual">
                     Casual
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="Vacation" id="Vacation">
                  <label class="form-check-label" for="Vacation">
                     Vacation
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="Bereavement" id="Bereavement">
                  <label class="form-check-label" for="Bereavement">
                     Bereavement
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="Time off without pay" id="Time Off Without Pay">
                  <label class="form-check-label" for="Time Off Without Pay">
                     Time off without pay
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="Maternity / Paternity" id="Maternity/Paternity">
                  <label class="form-check-label" for="Maternity/Paternity">
                     Maternity / Paternity
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="Sabbatical" id="Sabbatical">
                  <label class="form-check-label" for="Sabbatical">
                     Sabbatical
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="Other" id="Other">
                  <label class="form-check-label" for="Other">
                     Others
                  </label>


               </div>




               </div>
         <div class="col-md-6">

               <div class="mb-3">

                  <label for="leaveDesc" class="form-label"><b>Please mention reasons for your leave days :</b></label>
                  <!-- error message if reason of the leave is not given -->
                  <br>
                  <span class="error"><?php echo "&nbsp;".$reasonErr ?></span>
                  <textarea class="form-control" name="reason" id="leaveDesc" rows="4" placeholder="Enter Here..."></textarea>

               </div>


               <br>

               <div>
                  <button type="submit" class="btn btn-dark" name="submit">Save</button>
                  <a href="leave.php" class="btn btn-secondary">Cancel</a>
               </div>
            </form>
         </div>
      </div>
   </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
   </script>

</body>

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
</script>

</html>
