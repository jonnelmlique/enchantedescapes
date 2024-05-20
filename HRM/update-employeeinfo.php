<?php
include "db_conn.php";

// Initialize $row variable to avoid undefined variable warning
$row = [];
$sql = "SELECT * FROM department";
$result = mysqli_query($conn, $sql);

$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
  $departments[] = $row['department_name'];
}

// Fetch positions from the database
// $sql = "SELECT DISTINCT position FROM employee_info";
// $result = mysqli_query($conn, $sql);

// $positions = [];
// while ($row = mysqli_fetch_assoc($result)) {
//   $positions[] = $row['position'];
// }

if (isset($_GET['id'])) {
  $employee_id = $_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM employee_info WHERE Id = ?");
  $stmt->bind_param("i", $employee_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $dept = $row['Department'];
    $stmt2 = $conn->prepare("SELECT position FROM department WHERE department_name = ?");
    $stmt2->bind_param("s", $dept);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $positions = [];
    while ($row2 = mysqli_fetch_assoc($result2)) {
      $positions = explode(",", $row2['position']);
    }

  } else {
    echo "Employee not found.";
    exit();
  }
}

if (isset($_POST["submit"])) {

  $employee_id = $_POST['EMPLOYEE_ID'];
  $imageUpdated = false;
  if (!empty($_FILES['img']['name'])) {
    $image = $_FILES['img']['name'];
    $imageUpdated = true;
  } else {
    // * No new image uploaded, retain the existing image
    $image = $row['img'];
  }
  $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $mname = $_POST['middle_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $address = $_POST['Address'];
  $bday = $_POST['Emp_bday'];
  $gender = $_POST['Gender'];
  $age = $_POST['AGE'];
  $phone = $_POST['Phone'];
  $position = $_POST['position'];
  $startDate = $_POST['StartDate'];
  $endDate = $_POST['EndDate'];
  $department = $_POST['Department'];
  $status = $_POST['Status'];

  $sql = "UPDATE employee_info SET img = ?, first_name = ?, last_name = ?, middle_name = ?, email = ?, password = ?, Address = ?, emp_bday = ?, 
   Age = ?, Gender = ?, Phone = ?, StartDate = ?, EndDate = ?, position = ?, 
   Department = ?, Status = ? WHERE Employee_ID = ?;";
  $stmt = mysqli_prepare($conn, $sql);
  $stmt->bind_param("sssssssssssssssss", $image, $fname,$lname,$mname, $email, $password, $address, $bday, $age, $gender, $phone, $startDate, $endDate, $position, $department, $status, $employee_id);

  if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {

      if ($imageUpdated) {
        // File upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        // Ensure directory exists
        if (!file_exists($target_dir)) {
          mkdir($target_dir, 0777, true);
        }
        if (!move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
          echo "Failed to upload file.";
        }
      }

      header("Location: employeeinfo.php?msg=Data Successfully updated");
      exit(); 
    } else {
      echo "No changes were made.";
    }
  } else {
    echo "There is a problem updating this information...";
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

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


          <div class="mb-3">
            <label class="form-label">Image:</label>
            <input type="file" class="form-control" accept=".jpg,.png,.jpeg" name="img" <?php echo (isset($row['img']) && !empty($row['img'])) ? 'value="' . $row['img'] . '"' : ''; ?>>
          </div>

          <div class="mb-3">
            <div class="mb-3">
              <label class="form-label">Employee ID:</label>
              <input type="text" class="form-control" name="Employee_ID" placeholder="Employee ID" disabled
                value="<?php echo isset($row['Employee_ID']) ? $row['Employee_ID'] : ''; ?>">
              <input type="hidden" name="EMPLOYEE_ID"
                value="<?php echo isset($row['Employee_ID']) ? $row['Employee_ID'] : ''; ?>">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password:</label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" placeholder="Password"
                value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>">
              <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>




          <div class="mb-3">
            <div class="mb-3">
              <label class="form-label">First name:</label>
              <input type="text" class="form-control" name="first_name" placeholder="Name"
                value="<?php echo isset($row['first_name']) ? $row['first_name'] : ''; ?>">
            </div>
          </div>

          <div class="mb-3">
            <div class="mb-3">
              <label class="form-label">Middle name:</label>
              <input type="text" class="form-control" name="middle_name" placeholder="Name"
                value="<?php echo isset($row['middle_name']) ? $row['middle_name'] : ''; ?>">
            </div>
          </div>

          <div class="mb-3">
            <div class="mb-3">
              <label class="form-label">Last name:</label>
              <input type="text" class="form-control" name="last_name" placeholder="Name"
                value="<?php echo isset($row['last_name']) ? $row['last_name'] : ''; ?>">
            </div>
          </div>

       

          <div class="mb-3">
            <div class="mb-3">
              <label class="form-label">Email:</label>
              <input type="email" class="form-control" name="email" placeholder="name@gmail.com"
                value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
            </div>
          </div>

          <!-- Department dropdown -->
          <!-- Department dropdown -->
          <div class="mb-3">
            <label class="form-label">Department:</label>
            <select class="form-select" id="departmentSelect" name="Department">
              <option value="" disabled selected>Choose department</option>
              <?php
              foreach ($departments as $dept) {
                $selected = ($dept == $row['Department']) ? 'selected' : '';
                echo "<option value='$dept' $selected>$dept</option>";
              }
              ?>
            </select>
          </div>



          <!-- Position dropdown -->



          <div class="mb-3">
            <label class="form-label">Position:</label>
            <select class="form-select" id="positionSelect" name="position">

              <option value="" disabled>Select Position</option>
              <?php
              // Loop through positions array
              foreach ($positions as $pos) {
                // Check if position matches the one retrieved from the database
                $selected = ($pos == $row['position']) ? 'selected' : '';
                echo "<option value='$pos' $selected>$pos</option>";
              }
              ?>
            </select>
          </div>




      </div>

      <div class="col-md-6">


        <div class="mb-3">
          <div class="mb-3">
            <label class="form-label">Address:</label>
            <input type="text" class="form-control" name="Address" placeholder="Address"
              value="<?php echo isset($row['Address']) ? $row['Address'] : ''; ?>">
          </div>
        </div>


        <div class="mb-3">
          <div class="mb-3">
            <label class="form-label">Birth Date:</label>
            <input type="Date" class="form-control" name="Emp_bday" placeholder="Birthdate"
              value="<?php echo isset($row['emp_bday']) ? $row['emp_bday'] : ''; ?>">
          </div>
        </div>


        <div class="mb-3">
          <div class="mb-3">
            <label class="form-label">Age:</label>
            <input type="text" class="form-control" name="Age" placeholder="Age"
              value="<?php echo isset($row['Age']) ? $row['Age'] : ''; ?>" disabled>
            <!-- * this is a holder for the actual value of the input -->
            <!-- * because disabled inputs dont carry values when the form is submitted -->
            <input type="hidden" name="AGE" value="<?php echo isset($row['Age']) ? $row['Age'] : ''; ?>">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Gender:</label>
          <select class="form-select" name="Gender">
            <option value="" disabled selected>Choose Gender</option>
            <?php
            // Define genders array
            $genders = ['Female', 'Male', 'LGBTQIA+'];

            // Loop through genders array
            foreach ($genders as $gen) {
              // Check if gender matches the one retrieved from the database
              $selected = ($gen == $row['Gender']) ? 'selected' : '';
              echo "<option value='$gen' $selected>$gen</option>";
            }
            ?>
          </select>
        </div>


        <div class="mb-3">
          <div class="mb-3">
            <label class="form-label">Phone:</label>
            <input type="text" class="form-control" name="Phone" placeholder="Phone Number"
              value="<?php echo isset($row['Phone']) ? $row['Phone'] : ''; ?>">
          </div>
        </div>



        <div class="mb-3">
          <div class="mb-3">
            <label class="form-label">Start Date:</label>
            <input type="Date" class="form-control" name="StartDate" placeholder="Date Started"
              value="<?php echo isset($row['StartDate']) ? $row['StartDate'] : ''; ?>">
          </div>
        </div>

        <div class="mb-3">
          <div class="mb-3">
            <label class="form-label">End Date:</label>
            <input type="Date" class="form-control" name="EndDate" placeholder="Date Ended"
              value="<?php echo isset($row['EndDate']) ? $row['EndDate'] : ''; ?>">
          </div>
        </div>





        <div class="mb-3">
          <label class="form-label">Status:</label>
          <select class="form-select" name="Status">
            <option value="" disabled selected>Choose status</option>
            <option value="ACTIVE" <?php if (isset($row['Status']) && $row['Status'] == 'ACTIVE')
              echo 'selected'; ?>>
              ACTIVE</option>
            <option value="IN-LEAVE" <?php if (isset($row['Status']) && $row['Status'] == 'IN-LEAVE')
              echo 'selected'; ?>>
              IN-LEAVE</option>
            <option value="RESIGNED" <?php if (isset($row['Status']) && $row['Status'] == 'RESIGNED')
              echo 'selected'; ?>>
              RESIGNED</option>
          </select>
        </div>

      </div>

    </div>

    <div>
      <button type="submit" class="btn btn-dark" name="submit">Submit</button>

      <a href="employeeinfo.php" class="btn btn-secondary">Cancel</a>
    </div>
  </div>
  </form>


  </div>
  </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>


  <style>
    .form-control {
      padding: 4px;
    }
  </style>
</body>

<script>
  document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.querySelector("input[name='password']");
    if (passwordInput.getAttribute("type") === "password") {
      passwordInput.setAttribute("type", "text");
    } else {
      passwordInput.setAttribute("type", "password");
    }
  });
</script>
<script>
  function fetchPositions() {
    var department = document.getElementById("departmentSelect").value;

    // Make AJAX request to fetch positions based on selected department
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
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
          positions.forEach(function (position) {
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
  // fetchPositions();

</script>


</html>