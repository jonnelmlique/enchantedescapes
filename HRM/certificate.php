<?php
include "db_conn.php";
include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Certificate</title>

  <!-- CSS -->
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="stylee.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

  <?php
  if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>
  <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080; color: white;">Employee Certificate</nav>
  <a href="add-certificate.php" class="btn btn-warning mb-3">Add New</a>

  <table class="table table-hover text-center">
    <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Release Date</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM `certificate`";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
          <td><?php echo $row["Employee_ID"] ?></td>
          <td><?php echo $row["Name"] ?></td>
          <td><?php echo $row["Release Date"] ?></td>
          <td>
            <a href="show-certificate.php?Name=<?php echo $row["Name"] ?>&table=certificate&header=certificate.php" 
              class="link-dark"><i class="fa-regular fa-eye fs-5"></i></a>
            <a href="#" class="link-dark" onclick="openDeleteModal(<?php echo $row['id']; ?>)"><i
              class="fa-solid fa-trash fs-5"></i></a>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>

  <!-- Delete Confirmation Modal -->
  <div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this certificate?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="#" id="deleteButton" class="btn btn-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
 <script>
    function openDeleteModal(id) {
      console.log('Delete button clicked for ID: ' + id);
      var deleteButton = document.getElementById('deleteButton');
      var deleteUrl = 'remove.php?id=' + id + '&table=certificate&header=certificate.php';
      console.log('Delete URL: ' + deleteUrl);
      deleteButton.setAttribute('href', deleteUrl);
      var bsModal = new bootstrap.Modal(document.getElementById('deleteModal'));
      bsModal.show();
    }
  </script></body>

</html>
