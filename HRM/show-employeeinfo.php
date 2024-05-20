<?php
include "db_conn.php";
// include "sidebar.php";

// Assuming $departments is fetched from your database
$sql = "SELECT * FROM department";
$result = mysqli_query($conn, $sql);

$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['department_name'];
}

// Check if the ID is set in the URL
if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM employee_info WHERE Id = ?");
    $stmt->bind_param("i", $employee_id);
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

if (isset($_POST["submit"])) {
    // Existing code for adding new employee
}

// Function to generate employee_id
function generateEmployeeID() {
    // Generate a random 4-digit number
    return rand(1000, 9999);
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

   <title>Employee Details</title>
</head>

<body>

   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #808080;">
   Employee Details
   </nav>
   <div class="container">
   <div class="row ">
      <div class="col-md-6">
      <form action="" method="post" enctype="multipart/form-data">

      <div class="mb-3 d-flex justify-content-center">
    <?php if(isset($row['img']) && !empty($row['img'])): ?>
        <img src="uploads/<?php echo $row['img']; ?>" class="img-fluid" alt="Employee Image" style="width: 6rem; height: 6rem;">
    <?php else: ?>
        <p>No image available</p>
    <?php endif; ?>
</div>

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Employee ID:</label>
                   <input type="text" class="form-control" name="employee_id" placeholder="Employee ID" value="<?php echo isset($row['Employee_ID']) ? $row['Employee_ID'] : ''; ?>" disabled>
               </div>
            </div>

            <div class="mb-3">
            <label class="form-label">Password:</label>
    <div class="input-group">
        <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>" disabled>
        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="fas fa-eye"></i>
        </button>
    </div>
</div>

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">First name:</label>
                   <input type="text" class="form-control" name="first_name" placeholder="Name" value="<?php echo isset($row['first_name']) ? $row['first_name'] : ''; ?>" disabled>
               </div>
            </div>

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Middle name:</label>
                   <input type="text" class="form-control" name="middle_name" placeholder="Name" value="<?php echo isset($row['middle_name']) ? $row['middle_name'] : ''; ?>" disabled>
               </div>
            </div>
            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Last name:</label>
                   <input type="text" class="form-control" name="last_name" placeholder="Name" value="<?php echo isset($row['last_name']) ? $row['last_name'] : ''; ?>" disabled>
               </div>
            </div>
           

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Email:</label>
                   <input type="email" class="form-control" name="email" placeholder="name@gmail.com" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" disabled>
               </div>
            </div>

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Department:</label>
                   <input type="text" class="form-control" name="department" placeholder="Department" value="<?php echo isset($row['Department']) ? $row['Department'] : ''; ?>" disabled>
               </div>
            </div>

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Position:</label>
                   <input type="text" class="form-control" name="position" placeholder="Current Position" value="<?php echo isset($row['position']) ? $row['position'] : ''; ?>" disabled>
               </div>
            </div>

  
            </div>

<div class="col-md-6">   
            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Address:</label>
                   <input type="text" class="form-control" name="Address"  placeholder="Address" value="<?php echo isset($row['Address']) ? $row['Address'] : ''; ?>" disabled>
               </div>
            </div>


          
            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Birth Date:</label>
                   <input type="Date" class="form-control" name="BirthDate" placeholder="Birthdate" value="<?php echo isset($row['emp_bday']) ? $row['emp_bday'] : ''; ?>" disabled>
               </div>
            </div>


            <div class="mb-3">

     

               <div class="mb-3">
                   <label class="form-label">Age:</label>
                   <input type="text" class="form-control" name="Age" placeholder="Age" value="<?php echo isset($row['Age']) ? $row['Age'] : ''; ?>" disabled>
               </div>
            </div>


            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Gender:</label>
                   <input type="text" class="form-control" name="" placeholder="Gender" value="<?php echo isset($row['Gender']) ? $row['Gender'] : ''; ?>" disabled>
               </div>
            </div>


            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Phone:</label>
                   <input type="text" class="form-control" name="Phone" placeholder="Phone Number" value="<?php echo isset($row['Phone']) ? $row['Phone'] : ''; ?>" disabled>
               </div>
            </div>

         

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Start Date:</label>
                   <input type="Date" class="form-control" name="StartDate" placeholder="Date Started" value="<?php echo isset($row['StartDate']) ? $row['StartDate'] : ''; ?>" disabled>
               </div>
            </div>

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">End Date:</label>
                   <input type="Date" class="form-control" name="EndDate" placeholder="Date Ended" value="<?php echo isset($row['EndDate']) ? $row['EndDate'] : ''; ?>" disabled>
               </div>
            </div>

        

            <div class="mb-3">
               <div class="mb-3">
                   <label class="form-label">Status:</label>
                   <input type="text" class="form-control" name="Status" placeholder="Status" value="<?php echo isset($row['Status']) ? $row['Status'] : ''; ?>" disabled>
               </div>
            </div>

            <div>
               <a href="employeeinfo.php" class="btn btn-secondary">Done</a>
            </div>
         </div>
         </form>

         
      </div>
   </div>
</div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


   <style>
    .form-control{
        padding: 4px;
    }
    </style>
</body>

<script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordInput = document.querySelector("input[name='password']");
        if (passwordInput.getAttribute("type") === "password") {
            passwordInput.setAttribute("type", "text");
        } else {
            passwordInput.setAttribute("type", "password");
        }
    });
</script>

</html>
