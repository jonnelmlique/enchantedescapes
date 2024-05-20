<?php
include "db_conn.php";
include "sidebar.php";
if (isset($_POST["submit"])) {
    $department = $_POST['department'];
    $positions = $_POST['position']; // Retrieve positions array
    
    // Convert positions array to a comma-separated string
    $positions_string = implode(', ', $positions);
    
    // Check if the department already exists
    $check_sql = "SELECT * FROM `department` WHERE `department_name` = '$department'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        // Department already exists, display an error message
        echo "<script>alert('Department already exists!');</script>";
    } else {
        // Generate a random department ID
        $department_id = generateRandomID();

        // Insert the department into the database along with positions
        $sql = "INSERT INTO `department`(`department_id`, `department_name`, `position`) VALUES ('$department_id', '$department', '$positions_string')";
        
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            // Redirect the user to department.php with a success message
            echo "<script>window.location.href = 'department.php?msg=New Department created successfully';</script>";
            exit(); // Stop further execution
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    }
}

// Function to generate a random numeric department ID
function generateRandomID() {
    // Generate a random number between 1000 and 9999
    $random_number = mt_rand(1000, 9999);
    return $random_number;
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

    <title>Add Department</title>
</head>

<body>

    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #808080;">
        Add Department
    </nav>

    <div class="container">
        <div class="text-center mb-4">
       
        </div>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control" name="department" placeholder="Department Name">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Positions:</label>
                        <div id="positionsContainer">
                            <input type="text" class="form-control" name="position[]" placeholder="Position">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="addPosition()">Add Another Position</button>
                
                <br>
                <br>
                <div>
                    <button type="submit" class="btn btn-dark" name="submit">Save</button>
                    <a href="department.php" class="btn btn-secondary">Cancel</a>
                </div>
                
            </form>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        function addPosition() {
            // Create a new input element
            var newPositionInput = document.createElement("input");
            newPositionInput.type = "text";
            newPositionInput.className = "form-control";
            newPositionInput.name = "position[]";
            newPositionInput.placeholder = "";

            // Append the new input element to the positions container
            document.getElementById("positionsContainer").appendChild(newPositionInput);
        }
    </script>

</body>

</html>
