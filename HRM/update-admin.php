<?php

include "db_conn.php";
// include "sidebar.php";

$row = [];
$departments = [];

// Fetch department names
$sql = "SELECT * FROM department";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['department_name'];
}

// Fetch admin details if ID is provided
if (isset($_GET['id'])) {
    $row_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM admin_tbl WHERE adminID = ?");
    $stmt->bind_param("i", $row_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Admin not found.";
        exit();
    }
}

// Update admin details
if (isset($_POST['submit'])) {
    $adminName = $_POST['adminName'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $department = $_POST['Department'];
    $id = $row_id;

    // Prepare the SQL statement using prepared statements
    $sql = "UPDATE admin_tbl SET adminName=?, email=?, Department=?, password=? WHERE adminID = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters to the statement
        $stmt->bind_param("ssssi", $adminName, $email, $department, $password, $id);
        
        // Execute the statement
        $result = $stmt->execute();
        
        if ($result) {
            // Redirect to admin-list.php with success message
            header("Location: admin-list.php?msg=Data updated successfully");
            exit(); 
            
            // Always exit after redirecting to prevent further execution
        } else {
            // Display error message if update fails
            echo "Failed: " . $stmt->error;
        }
    } else {
        // Display error message if preparation fails
        echo "Failed to prepare the statement";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080;"> Update Admin</nav>
<div class="container">
    <div class="container d-flex justify-content-center">
        <form action="" method="post" style="width:50vw; min-width:300px;">
            <div class="mb-3">
                <label class="form-label">Admin Name:</label>
                <input type="text" class="form-control" name="adminName" value="<?php echo isset($row['adminName']) ? $row['adminName'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Password:</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="text" class="form-control" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Department:</label>
                <select class="form-select" name="Department">
                    <option value="" disabled>Choose department</option>
                    <?php
                    foreach ($departments as $dept) {
                        // Check if department matches the one retrieved from the database
                        $selected = ($dept == $row['Department']) ? 'selected' : '';
                        echo "<option value='$dept' $selected>$dept</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-success" name="submit">Update</button>
                <a href="admin-list.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

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
</body>
</html>
