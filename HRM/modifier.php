<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="eistylee.css">
</head>
<body>
  <?php
    session_start();
    include 'conixion.php';
    $_SESSION["id"]= $_GET['Id'];
    $id = $_SESSION["id"];
    $statement = $con -> prepare("SELECT * FROM employee_info WHERE Id = $id");
    $statement->execute();
    $table = $statement -> fetch();

  ?>
<div class="container w-50">


<form method="POST" action="update.php" enctype="multipart/form-data">
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">img:</label>
                                    <input type="file" class="form-control" id="recipient-name" accept=".jpg,.png,.jpeg" name="img">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Name:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Name" value="<?php echo $table['Name']?>">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Address:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Address" value="<?php echo $table['Address']?>">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Age:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Age" value="<?php echo $table['Age']?>">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Phone:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Phone" value="<?php echo $table['Phone']?>">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Start Date:</label>
                                    <input type="date" class="form-control" id="recipient-name" name="StartDate" value="<?php echo $table['StartDate']?>">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Status:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Status" value="<?php echo $table['Status']?>">
                                  </div>
                                  <div class="modal-footer">
                                <button type="submit" name="submit" class="btn btn-primary">Update employee</button>
                              </div>
                                </form>
</div>
    <script src="scripts.js"></script>
    <script src="bootstrap.bundle.js"></script>
</body>
</html>