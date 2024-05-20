<?php
// Include necessary files
include "db_conn.php";
include "sidebar.php";

// Initialize the search query variable
$search_query = "";

// Check if the search form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
  // Get the search query from the form
  $search_query = $_GET["search"];
}


?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>

  <!-- CSS -->
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="stylee.css">
</head>

<body>

  <div class="main p-3">
    <div class="text-center">
      <div class="container">
        <?php
        if (isset($_GET["msg"])) {
          $msg = $_GET["msg"];
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        ' . $msg . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
        ?>
           <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080; color: white;">Employee Information
        </nav>
        <a href="add-employee.php" class="btn btn-warning mb-3">Add New</a>
        <form class="d-flex ms-3" style="margin-bottom: 10px;" method="GET" action="">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search"
            value="<?php echo $search_query; ?>">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <table class="table table-hover text-center">
          <thead class="table-dark">
            <tr>
              <th scope="col">ID No.</th>
              <th scope="col">Name</th>
          
              <th scope="col">Department</th>
              <th scope="col">Position</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

            <?php
            // Construct the SQL query based on the search query
            $sql = "SELECT * FROM `employee_info`";
            if (!empty($search_query)) {
              $sql .= " WHERE Name LIKE '%$search_query%' OR Department LIKE '%$search_query%' OR position LIKE '%$search_query%'";
            }

            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $department = $row['Department'];
              $position_query = "SELECT position FROM department WHERE department_name = '$department'";
              $position_result = mysqli_query($conn, $position_query);
              $position_row = mysqli_fetch_assoc($position_result);
              $position = isset($position_row['position']) ? $position_row['position'] : '';

              ?>
              <tr>
                <td><?php echo $row['Employee_ID']; ?></td>
                <td><?php echo $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']; ?></td>

             
                <td><?php echo $row['Department']; ?></td>
                <td><?php echo $row['position']; ?></td>
                <td>

                  <a href="show-employeeinfo.php?id=<?php echo $row["Id"]; ?>&table=employee_info&header=employeeinfo.php"
                    class="link-dark"><i class="fa-regular fa-eye fs-5"></i></a>
                  <a href="update-employeeinfo.php?id=<?php echo $row["Id"]; ?>&table=employee_info&header=employeeinfo.php"
                    class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                  <a href="#" class="link-dark" onclick="openDeleteModal(<?php echo $row['Id']; ?>)"><i
                      class="fa-solid fa-trash fs-5"></i></a>

                </td>
              </tr>
            <?php
            }
            ?>

          
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="script.js"></script>

  <script>
    function openDeleteModal(id) {
      // Populate modal with the record details
      var modal = document.getElementById('deleteModal');
      var modalBody = modal.querySelector('.modal-body');
      modalBody.innerHTML = 'Are you sure you want to delete this employee ?';

      // Set the ID to be deleted
      var deleteButton = modal.querySelector('.btn-delete');
      deleteButton.setAttribute('data-id', id);

      // Show the modal
      var bsModal = new bootstrap.Modal(modal);
      bsModal.show();
    }

    function deleteRecord() {
      var id = document.getElementById('deleteButton').getAttribute('data-id');
      // Redirect to the remove.php script with the appropriate parameters
      window.location.href = 'remove.php?id=' + id + '&table=employee_info&header=employeeinfo.php';
    }
  </script>

  <!-- Delete Confirmation Modal -->
  <div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Modal content will be dynamically populated -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger btn-delete" id="deleteButton" onclick="deleteRecord()">Delete</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
