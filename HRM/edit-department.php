<?php
include "db_conn.php";
include "sidebar.php";

$id = $_GET["id"];

if (isset($_POST["submit"])) {

    if($_POST["submit"] === "delete"){
        
        $positions = $_POST['position'];
        $positionToDelete = $_POST['position-to-delete'];
        $key = array_search($positionToDelete, $positions);
        if ($key !== false) {
            unset($positions[$key]);
        }

        $department_name = $_POST['department_name'];
    
        // Convert positions array to a comma-separated string
        $positions_string = implode(', ', $positions);

        $sql = "UPDATE `department` SET `department_name`=?, `position`=? WHERE department_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            // Bind parameters to the statement
            mysqli_stmt_bind_param($stmt, "ssi", $department_name, $positions_string, $id);
            
            // Execute the statement
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                // Redirect the user to department.php with a success message
              echo "<script>window.location.href = 'department.php?msg=Deleted a position successfully';</script>";
              exit(); // Stop further execution
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        }
    } else {
      $department_name = $_POST['department_name'];
      $positions = $_POST['position']; // Retrieve positions array
      

      // * Remove empty or whitespace-only items
      $positions = array_filter($positions, function($value) {
          return !empty(trim($value));
      });
      $positions = array_values($positions);

      // Convert positions array to a comma-separated string
      $positions_string = implode(', ', $positions);

      $sql = "UPDATE `department` SET `department_name`=?, `position`=? WHERE department_id = ?";
      $stmt = mysqli_prepare($conn, $sql);
      
      if ($stmt) {
          // Bind parameters to the statement
          mysqli_stmt_bind_param($stmt, "ssi", $department_name, $positions_string, $id);
          
          // Execute the statement
          $result = mysqli_stmt_execute($stmt);
          
          if ($result) {
              // Redirect the user to department.php with a success message
              echo "<script>window.location.href = 'department.php?msg=Record updated successfully';</script>";
              exit(); // Stop further execution
          } else {
              echo "Failed: " . mysqli_error($conn);
          }
      }
    }
}

// Fetch department details only if $id is set
if (isset($id)) {
    $sql = "SELECT * FROM `department` WHERE department_id = $id";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful before fetching data
    if ($result) {
        $row = mysqli_fetch_assoc($result);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous">

    <title>Update Department</title>
</head>

<body>
    <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080;"> Update Department</nav>
    <div class="container">
        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;">
                <br>
                <br>
                <br>
                <div class="mb-3">
                    <label class="form-label">Department Name:</label>
                    <input type="text" class="form-control" name="department_name"
                        value="<?php echo isset($row['department_name']) ? $row['department_name'] : ''; ?>">
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Positions:</label>
                        <div id="positionsContainer">
                            <?php
                            // Check if $row['position'] is set and explode it into an array
                            $positions = isset($row['position']) ? explode(', ', $row['position']) : [];
                            foreach ($positions as $position) {
                                // echo '<input type="text" class="form-control" name="position[]" value="' . $position . '" placeholder="Position">';
                                echo '<div class="col mb-3"><input type="text" class="form-control" name="position[]" value="' . $position . '" placeholder="Position">
                                <button type="submit" name="submit" class="btn btn-dark" value="delete">Delete</button>
                                <input type="hidden" id="hidden" name="position-to-delete" value="' . $position . '">
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="addPosition()">Add Another Position</button>
                <br>
                <br>
                <div>
                    <button type="submit" class="btn btn-success" name="submit">Update</button>
                    <a href="department.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script>
        function addPosition() {
            // Create a new input element
            var newPositionInput = document.createElement("input");
            newPositionInput.type = "text";
            newPositionInput.className = "form-control";
            newPositionInput.name = "position[]";
            newPositionInput.placeholder = "";

            var deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.className = "btn btn-dark delete-button";
            deleteButton.textContent = "Delete";
            deleteButton.addEventListener("click", function() {
              document.getElementById("positionsContainer").removeChild(this.parentNode);
            });

            var divCont = document.createElement("div");
            divCont.className = "col mb-3";

            divCont.appendChild(newPositionInput);
            divCont.appendChild(deleteButton);

            // Append the new input element to the positions container
            document.getElementById("positionsContainer").appendChild(divCont);
        }
    </script>
</body>

</html>
