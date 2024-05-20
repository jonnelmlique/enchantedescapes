<?php
include "db_conn.php";
include "sidebar.php";

// Assuming $departments is fetched from your database
$sql = "SELECT * FROM department";
$result = mysqli_query($conn, $sql);

$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['department_name'];
}

if (isset($_POST["submit"])) {
    $adminName = $_POST['adminName'];
    $email = $_POST['email'];
    $department = $_POST['Department'];

    // Check if admin with the same name or email already exists
    $check_sql = "SELECT * FROM admin_tbl WHERE adminName = '$adminName' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        // Admin with the same name or email already exists, display an error message
        echo "<script>alert('Admin with the same name or email already exists!');</script>";
    } else {
        // Generate unique employee_id
        $adminId = generateEmployeeID(); 

        // Generate a unique 6-digit password
        $password = generateUniquePassword();

        // Prepare and bind SQL statement (excluding employee_ID)
        $stmt = $conn->prepare("INSERT INTO admin_tbl (adminID, adminName, email, Department, password) VALUES (?, ?, ?, ?, ?)");

        if (!$stmt) {
            die("Error: " . $conn->error); // Check for errors in preparing the statement
        }

        // Bind parameters
        $success = $stmt->bind_param("sssss", $adminId, $adminName, $email, $department, $password);

        if (!$success) {
            die("Error: " . $stmt->error); // Check for errors in binding parameters
        }

        // Execute the statement
        $success = $stmt->execute();

        if ($success) {
         // Redirect to schedule.php
         echo "<script>window.location.href = 'admin-list.php?msg=New Admin created successfully';</script>";
         exit();
     } else {
         echo "Error: " . $stmt->error;
     }

        // Close statement
        $stmt->close();
    }
}

// Function to generate unique employee_id
function generateEmployeeID() {
    // Generate a random 4-digit number
    return rand(1000, 9999);
}

// Function to generate unique 6-digit password
function generateUniquePassword() {
    global $conn;
    do {
        $password = generatePassword();
        $query = "SELECT * FROM admin_tbl WHERE password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $password);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);
    return $password;
}

// Function to generate a 6-digit password
function generatePassword() {
    return rand(100000, 999999);
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

   <title>Add Admin</title>
</head>

<body>

   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #808080;">
      Add Admin
   </nav>

   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-6">
            <form action="" method="post" enctype="multipart/form-data">

               <div class="mb-3">
                  <label class="form-label">Username:</label>
                  <input type="text" class="form-control" name="adminName" placeholder="Username">
               </div>

               <div class="mb-3">
                  <label class="form-label">Email:</label>
                  <input type="email" class="form-control" name="email" placeholder="name@gmail.com">
               </div>

               <div class="mb-3">
                  <label class="form-label">Department:</label>
                  <select class="form-select" name="Department">
                     <option value="" disabled selected>Choose department</option>
                     <?php foreach ($departments as $dept) { ?>
                        <option value="<?php echo $dept; ?>"><?php echo $dept; ?></option>
                     <?php } ?>
                  </select>
               </div>

               <div>
                  <button type="submit" class="btn btn-dark" name="submit">Save</button>
                  <a href="admin-list.php" class="btn btn-secondary">Cancel</a>
               </div>

            </form>
         </div>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
