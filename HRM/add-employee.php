<?php
include "db_conn.php";
//include "sidebar.php";

// Assuming $departments is fetched from your database
$sql = "SELECT * FROM department";
$result = mysqli_query($conn, $sql);

$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['department_name'];
    
}

if (isset($_POST["submit"])) {
    // Generate unique employee_id
    $employee_id = generateEmployeeID(); 

    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $mname = $_POST['middle_name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $bday = $_POST['Emp_bday'];
    $age = $_POST['Age'];
    $gender = $_POST['Gender'];
    $phone = $_POST['Phone'];
    $img = $_FILES['img']['name'];
    $address = $_POST['Address'];
    $position = $_POST['position'];
    $start_date = $_POST['StartDate'];
    $status = $_POST['Status'];

    // Generate unique password
    $password = generateUniquePassword();

    // Prepare and bind SQL statement (excluding employee_ID)
   // Prepare and bind SQL statement (excluding employee_ID)
$stmt = $conn->prepare("INSERT INTO employee_info (Employee_ID, first_name, last_name, middle_name,email, department, Emp_bday, age, Gender, phone, img, address, position, startDate, status, password) VALUES (?, ?, ?,?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Error: " . $conn->error); // Check for errors in preparing the statement
}

// Bind parameters
$success = $stmt->bind_param("isssssssssssssss", $employee_id, $fname, $lname, $mname, $email, $department, $bday, $age, $gender, $phone, $img, $address, $position, $start_date, $status, $password);

if (!$success) {
    die("Error: " . $stmt->error); // Check for errors in binding parameters
}

    // Execute the statement
    $success = $stmt->execute();

    if ($success) {
        // File upload
        $target_dir = "./uploads/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        
        // Ensure directory exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            header("Location: employeeinfo.php?msg=New record created successfully");
            exit(); // Add exit after header to prevent further execution
        } else {
            header("Location: employeeinfo.php?msg=New record created successfully");
        }
    } else {
        echo "Failed: " . $stmt->error; // Display error if execution fails
    }

    // Close statement
    $stmt->close();
}

// Function to generate unique employee_id


// Function to generate unique 6-digit password
function generateUniquePassword() {
    global $conn;
    do {
        $password = generatePassword();
        $query = "SELECT * FROM employee_info WHERE password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $password);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);
    return $password;
}

// Function to generate employee_id
function generateEmployeeID() {
    // Generate a random 4-digit number
    return rand(1000, 9999);
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

   <title>Add Employee</title>
</head>

<body>

   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #808080;">
   Add Employee
   </nav>
   <div class="container">
   <div class="row ">
      <div class="col-md-6">
      <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
               <label class="form-label">First Name:</label>
               <input type="text" class="form-control" name="first_name" placeholder=" First Name">
            </div>

            <div class="mb-3">
               <label class="form-label">Middle Name: (Write N/A if none)</label>
               <input type="text" class="form-control" name="middle_name" placeholder="Middle Name">
            </div>
            <div class="mb-3">
               <label class="form-label">Last Name:</label>
               <input type="text" class="form-control" name="last_name" placeholder="Last Name">
            </div>

          
            <div class="mb-3">
               <label class="form-label">Email:</label>
               <input type="email" class="form-control" name="email" placeholder="name@gmail.com">
            </div>

            <div class="mb-3">
               <label class="form-label">Department:</label>
               <select class="form-select" name="department" id="departmentSelect">
                  <option value="" disabled selected>Choose department</option>
                  <?php foreach ($departments as $dept) { ?>
                     <option value="<?php echo $dept; ?>"><?php echo $dept; ?></option>
                  <?php } ?>
               </select>
            </div>

            <div class="mb-3">
    <label class="form-label">Position:</label>
    <select class="form-select" name="position" id="positionSelect">
        <option value="" disabled selected>Select Department first</option>
    </select>
</div>


            <div class="mb-3">
    <label class="form-label">Birthdate:</label>
    <input type="date" class="form-control" id="birthdate" name="Emp_bday" placeholder="BirthDate" onchange="calculateAge()">
</div>

<script>
function calculateAge() {
    var birthdate = new Date(document.getElementById("birthdate").value);
    var today = new Date();
    var age = today.getFullYear() - birthdate.getFullYear();
    var monthDiff = today.getMonth() - birthdate.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    document.getElementById("age").value = age;
    
    if (age <= 17) {
        alert("Age must be 18 or older.");
        document.getElementById("birthdate").value = ""; // Clear the birthdate input
        document.getElementById("age").value = ""; // Clear the age input
    }
}
</script>
<div class="mb-3">
    <label class="form-label">Age:</label>
    <input type="text" class="form-control" id="age" name="Age" placeholder="Age" readonly>
</div>


<div class="mb-3">
               <label class="form-label">Gender:</label>
               <select class="form-select" name="Gender">
                  <option value="" disabled selected>Choose Gender</option>
                  <option value="Female">Female</option>
                  <option value="Male">Male</option>
                  <option value="LGBTQIA+">LGBTQIA+</option>
               </select>
            </div>






</div>
         <div class="col-md-6">

<div class="mb-3">
    <label class="form-label">Phone:</label>
    <input type="tel" class="form-control" id="phoneInput" name="Phone" placeholder="Phone Number" title="Phone number must contain only numbers and be at most 11 digits long" required>
</div>

<script>
document.getElementById("phoneInput").addEventListener("input", function(event) {
    var input = event.target.value;
    // Remove any non-numeric characters
    input = input.replace(/\D/g, "");
    // Truncate input to a maximum of 11 digits
    if (input.length > 11) {
        input = input.slice(0, 11);
    }
    // Update the input value
    event.target.value = input;
});
</script>



           
         <div class="mb-3">
               <label class="form-label">img:</label>
               <input type="file" class="form-control" accept=".jpg,.png,.jpeg" name="img">
            </div>

            <div class="mb-3">
               <label class="form-label">Address:</label>
               <input type="text" class="form-control" name="Address"  placeholder="Address">
            </div>

        

            <div class="mb-3">
               <label class="form-label">Start Date:</label>
               <input type="Date" class="form-control" name="StartDate" placeholder="Date Started">
            </div>

            <div class="mb-3">
               <label class="form-label">Status:</label>
               <select class="form-select" name="Status">
                  <option value="" disabled selected>Choose status</option>
                  <option value="ACTIVE">ACTIVE</option>
                  <option value="IN-LEAVE">IN-LEAVE</option>
                  <option value="RESIGNED">RESIGNED</option>
               </select>
            </div>


            <div>
               <button type="submit" class="btn btn-dark" name="submit">Save</button>
               <a href="employeeinfo.php" class="btn btn-secondary">Cancel</a>
            </div>
         </form>
      </div>
   </div>
</div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</nav>
</body>

<script>
    // Function to fetch positions based on selected department
    function fetchPositions() {
        var department = document.getElementById("departmentSelect").value;

        // Make AJAX request to fetch positions based on selected department
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var responseText = xhr.responseText.trim(); // Trim whitespace
                // Remove leading "[" and trailing "]"
                responseText = responseText.substring(2, responseText.length - 2);
                var positions = responseText.split(','); // Split positions by comma

                    // Clear previous options
                    var positionSelect = document.getElementById("positionSelect");
                    positionSelect.innerHTML = '<option value="" disabled selected>Select Position</option>';

                    // Add new options
                    positions.forEach(function(position) {
                        var option = document.createElement("option");
                        option.value = position.trim(); // Trim whitespace
                        option.text = position.trim(); // Trim whitespace
                        positionSelect.appendChild(option);
                    });
                } else {
                    console.error("Failed to fetch positions.");
                }
            }
        };

        xhr.open("GET", "fetch_positions.php?department=" + department, true);
        xhr.send();
    }

    // Event listener for department select change
    document.getElementById("departmentSelect").addEventListener("change", fetchPositions);

    // Initial fetch of positions based on selected department
    fetchPositions();
</script>

</html>
