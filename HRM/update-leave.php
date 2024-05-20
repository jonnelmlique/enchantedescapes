<?php
include "db_conn.php";

// Check if department_id is set in the URL
if (isset($_GET["id"])) {
  // Get the department_id from the URL
  $row_id = $_GET["id"];

  // Check if the user has confirmed deletion
  // if (isset($_GET["confirm"]) && $_GET["confirm"] === "true") {
  //   // Use prepared statement to prevent SQL injection
  //   $sql = "DELETE FROM `department` WHERE department_id = ?";

  //   // Prepare the statement
  //   $stmt = mysqli_prepare($conn, $sql);

  //   // Bind the parameter
  //   mysqli_stmt_bind_param($stmt, "i", $department_id);

  //   // Execute the statement
  //   if (mysqli_stmt_execute($stmt)) {
  //     // Redirect to department.php with success message
  //     header("Location: department.php?msg=Data deleted successfully");
  //     exit(); // Exit to prevent further execution
  //   } else {
  //     // Display error message if deletion fails
  //     echo "Failed: " . mysqli_error($conn);
  //   }
  // }
  // If the user has not confirmed deletion, show confirmation modal
}


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["status"])) {
  $status = $_POST["status"];
  $id = $_POST["id"];
  $sql = "UPDATE leaves SET status = ? WHERE id = ?;";
  $stmt = mysqli_prepare($conn, $sql);
  $stmt->bind_param("si", $status, $id);

  if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
      mysqli_stmt_close($stmt);
      header('Location: leave.php');
      exit;
    } else {
      echo "No changes were made.";
    }
  } else {
    echo "There is a problem updating status...";
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Update Leave</title>
  <style>
    .modal {
      display: block;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 40%;
      text-align: center;
    }
  </style>
</head>

<body>
  <form action="update-leave.php" method="POST">
    <div id="confirmationModal" class="modal">
      <div class="modal-content">
        <!-- <p>Are you sure you want to delete this data?</p> -->
        <!-- <button type="submit" name="accept" id="confirmDelete" class="btn btn-danger">Accept</button> -->
        <input type="hidden" name="id" value="<?php echo $row_id ?>">
        <button type="submit" name="status" value="Accepted" class="btn btn-danger">Accept</button>
        <br>
        <button type="submit" name="status" value="Rejected" class="btn btn-secondary">Reject</button>
        <br>
        <a href="leave.php" class="btn btn-primary">Back</a>
      </div>
    </div>
  </form>
  <script>
    // // Get the confirmation modal
    // var modal = document.getElementById("confirmationModal");

    // // Get the confirm button
    // var confirmButton = document.getElementById("confirmDelete");

    // // Event listener for confirm button click
    // confirmButton.onclick = function () {
    //   // Redirect to delete-department.php with confirmation
    //   window.location.href = "delete-department.php?id='.$department_id.'&confirm=true";
    // }
  </script>
</body>

</html>