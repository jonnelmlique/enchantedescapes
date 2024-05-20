<?php
include "db_conn.php";
include "sidebar.php";

$id = $_GET["id"];

if (isset($_POST["submit"])) {
    $department_name = $_POST['department_name'];

    $sql = "UPDATE `Department` SET `department_name`=? WHERE department_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "si", $department_name, $id);
        
        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            // Redirect the user to department.php with a success message
            echo "<script>window.location.href = 'department.php?msg=New record updated successfully';</script>";
            exit(); // Stop further execution
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    }
}

// Fetch department details only if $id is set
if (isset($id)) {
    $sql = "SELECT * FROM `Department` WHERE department_id = $id";
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

</body>

</html>
