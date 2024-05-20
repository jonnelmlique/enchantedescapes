<?php
include "sche_conn.php";


if (isset($_POST["submit"])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $position = $_POST['position'];
  $shiftstart = $_POST['shiftstart'];
  $shiftend = $_POST['shiftend'];

  $sql = "UPDATE `shift` SET `name`='$name',`email`='$email',`position`='$position',`shiftstart`='$shiftstart',`shiftend`='$shiftend' WHERE id =id";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("Location: schedule.php?msg=Data updated successfully");
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>PHP CRUD Application</title>
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
    Schedule
  </nav>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Edit User Information</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>

    <?php
    $sql = "SELECT * FROM `shift` WHERE id = id";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    ?>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <div class="col">
            <label class="name">Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo $row['name'] ?>">
          </div>
          <div class="col">
            <label class="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>">
          </div>
          <div class="row mb-3">
            <div class="col">
              <label class="position">Position:</label>
              <input type="text" class="form-control" name="position" value="<?php echo $row['position'] ?>">
            </div>
          </div>

          <div class="col">
            <label class="shiftstart">ShiftStart:</label>
            <input type="datetime-local" class="form-control" name="shiftstart"
              value="<?php echo $row['shiftstart'] ?>">
          </div>
          <div class="col">
            <label class="shiftend">ShiftEnd:</label>
            <input type="datetime-local" class="form-control" name="shiftend" value="<?php echo $row['shiftend'] ?>">
          </div>
        </div>


        <div>
          <button type="submit" class="btn btn-success" name="submit">Update</button>
          <a href="schedule.php" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>

</body>

</html>