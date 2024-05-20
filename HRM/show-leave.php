<?php
include "config.php";

// Check if the ID is set in the URL
if(isset($_GET['id'])) {
  
  $row_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM leaves WHERE id = ?");
    $stmt->bind_param("i", $row_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if employee data is found
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit();
    }
}

$reasonErr = $absenceErr = $fromdateErr = $todateErr = "";
$reasonErr = $absenceErr = "";
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
        $eid_query = mysqli_query($conn, "SELECT Employee_ID FROM employee_info WHERE name='$name'");
    
        if ($eid_query) {
            $row = mysqli_fetch_assoc($eid_query);
            if ($row) {
                $eid = $row['Employee_ID'];
    
                // Database query to insert leave application
                $query = "INSERT INTO leaves (eid, ename, descr, fromdate, todate, status) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "isssss", $eid, $name, $absencePlusReason , $fromdate, $todate, $status); // Change $reason
                    $execute = mysqli_stmt_execute($stmt);
                    if (!$execute) {
                        echo "Error: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Employee ID not found";
                // Handle this situation accordingly
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    
}




if(isset($_GET['Employee_ID'])) {
    $employeeId = $_GET['Employee_ID'];
    $query = "SELECT name FROM users WHERE id = $employeeId";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['name'];
    } else {
        echo "Employee not found";
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
      View Leave
   </nav>
   <div class="all">
   <div class="container">
      <div class="row ">
         <div class="col-md-6 center-form">
            <form action="" method="post" enctype="multipart/form-data">

               <br>


               <div class="name-container">
                  <label for="Employee_ID">Employee ID:</b></label>
                  <input type="text" id="Employee_ID" name="eid" value="<?php echo $row["eid"] ?>" readonly><br><br>

                  <label for="Name">Employee Name:</b></label>
                            <input type="text" id="Name" name="ename" value="<?php echo $row["ename"] ?>" readonly><br>
                        </div>


               <br>
               <div class="mb-3 ">
                  <label for="dates"><b>From -</b></label>
                  <input type="date" id="start_date" name="fromdate" value="<?php echo $row["fromdate"] ?>" disabled>

                  <label for="dates"><b>To -</b></label>
                  <input type="date" id="end_date" name="todate" value="<?php echo $row["todate"] ?>" disabled>
               </div>


               <br>

               <label><b>Leave Type :</b></label>
               <!-- error message if type of absence isn't selected -->
               <span class="error"><?php echo "&nbsp;".$absenceErr ?></span><br />
               <div class="form-check">
                  <input class="form-check-input" name="absence[]" type="checkbox" value="<?php echo explode(":", $row["descr"])[0]; ?>" checked id="type" disabled>
                  <label class="form-check-label" for="Sick">
                     <?php echo explode(":", $row["descr"])[0]; ?>
                  </label>
               </div>
               </div>
         <div class="col-md-6">

               <div class="mb-3">

                  <label for="leaveDesc" class="form-label"><b>Reasons for leave days :</b></label>
                  <!-- error message if reason of the leave is not given -->
                  <br>
                  <span class="error"><?php echo "&nbsp;".$reasonErr ?></span>
                  <textarea class="form-control" name="reason" id="leaveDesc" rows="4" placeholder="reasons here..." readonly><?php echo trim(explode(":", $row["descr"])[1]); ?></textarea>
               </div>


               <br>

               <div>
                  <!-- <button type="submit" class="btn btn-dark" name="submit">Save</button> -->
                  <a href="leave.php" class="btn btn-secondary">DONE</a>
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
