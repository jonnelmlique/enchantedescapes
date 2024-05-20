<?php
include "db_conn.php";

// Check if department_id is set in the URL
if (isset($_GET["id"])) {
    // Get the department_id from the URL
    $department_id = $_GET["id"];
    
    // Check if the user has confirmed deletion
    if (isset($_GET["confirm"]) && $_GET["confirm"] === "true") {
        // Use prepared statement to prevent SQL injection
        $sql = "DELETE FROM department WHERE department_id = ?";
        
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt === false) {
            // Handle preparation error
            die("Error: " . mysqli_error($conn));
        }
        
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "i", $department_id);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to department.php with success message
            header("Location: department.php?msg=Data deleted successfully");
            exit(); // Exit to prevent further execution
        } else {
            // Display error message if deletion fails
            die("Failed: " . mysqli_error($conn));
        }
    } else {
        // If the user has not confirmed deletion, show confirmation modal
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
           <meta charset="UTF-8">
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
           <title>Delete Department</title>
           <style>
              .modal {
                 display: block;
                 position: fixed;
                 z-index: 1;
                 left: 0;
                 top: 0;
                 width: 100%;
                 height: 100%;
                 background-color: rgba(0,0,0,0.5);
              }
              
              .modal-content {
                 background-color: #fefefe;
                 margin: 15% auto;
                 padding: 20px;
                 border: 1px solid #888;
                 width: 80%;
                 text-align: center;
              }
           </style>
        </head>
        <body>
           <div id="confirmationModal_'.$department_id.'" class="modal">
              <div class="modal-content">
                 <p>Are you sure you want to delete this data?</p>
                 <button id="confirmDelete_'.$department_id.'" class="btn btn-danger">Yes</button>
                 <a href="department.php" class="btn btn-secondary">No</a>
              </div>
           </div>
           <script>
              // Get the confirm button
              var confirmButton_'.$department_id.' = document.getElementById("confirmDelete_'.$department_id.'");

              // Event listener for confirm button click
              confirmButton_'.$department_id.'.onclick = function() {
                 // Redirect to delete-department.php with confirmation
                 window.location.href = "delete-department.php?id='.$department_id.'&confirm=true";
              }
           </script>
        </body>
        </html>';
    }
} else {
    // If department_id is not set in the URL, display an error message
    echo "Error: Department ID not provided.";
}
?>
