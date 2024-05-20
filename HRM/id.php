<?php
include "sidebar.php"
?>
<!doctype html>
<html lang="en">
  <head>
    <!--side bar-->
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    

    <!--Bootstrap 5 icons CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <title> ID Request</title>

    <link rel="stylesheet" href="eistylee.css">
  </head>
  <body>

<?php  

// Connect to the Database 
include('id_db.php');

$insert = false;
$update = false;
$empty = false;
$delete = false;
$already_card = false;



if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `cards` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset( $_POST['snoEdit'])){
      // Update the record
        $sno = $_POST["snoEdit"];
        $name = $_POST["nameEdit"];
        $id_no = $_POST["id_noEdit"];

      // Sql query to be executed
      $sql = "UPDATE `cards` SET `name` = '$name' , `id_no` = '$id_no' WHERE `cards`.`sno` = $sno";
      $result = mysqli_query($conn, $sql);
      if($result){
        $update = true;
    }
    else{
        echo "We could not update the record successfully";
    }
}
else{
    $name = $_POST["name"];
    $id_no = $_POST["id_no"];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $exp_date = $_POST['exp_date'];
    $phone = $_POST['phone'];
    $date = date("Y-m-d");

    if($name == '' || $id_no == ''){
        $empty = true;
    }
    else{
        //Check that Card no. is Already Registerd or not.
        $querry = mysqli_query($conn, "SELECT * FROM cards WHERE id_no= '$id_no' ");
        if(mysqli_num_rows($querry)>0)
        {
             $already_card = true;
        }
        else{


          // image upload 
          $uploaddir = 'uploads';
          $uploadfile = $uploaddir . basename($_FILES['image']['name']);

      
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
              
          } else {
              echo "Possible file upload attack!\n";
          }
  // Sql query to be executed
  $sql = "INSERT INTO `cards`(`name`, `id_no`, `email`, `phone`, `address`, `dob`, `date`, `exp_date`, `image`) VALUES ('$name','$id_no','$email','$phone','$address','$dob', '$date', '$exp_date','$uploadfile')"; 

  // $sql = "INSERT INTO `cards` (`name`, `id_no`) VALUES ('$name', '$id_no')";
  $result = mysqli_query($conn, $sql);



   
  if($result){ 
      $insert = true;
  }
  else{
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
  } 
}
}
}

 }
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="icon" type="image/png" href="images/favicon.png"/>
  <title>Add New Employee | Coding Cush</title>

</head>

<body>
 

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit This Card</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="name">Employee Name</label>
              <label for="name">Employee Name</label>
              <input type="text" class="form-control" id="nameEdit" name="nameEdit">
            </div>
            <div class="form-group">
              <label for="desc">ID Card Number:</label>
              <input class="form-control" id="id_noEdit" name="id_noEdit" rows="3"></input>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<!-- Navigation bar start  -->
<nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080; color: white;">Employee ID Generator</nav>


    </ul>
  
  </div>
</nav>
<!-- Navigation bar end  -->

  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Card has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Card has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Card has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
   <?php
  if($empty){
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
    <strong>Error!</strong> The Fields Cannot Be Empty! Please Give Some Values.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
     <?php
  if($already_card){
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
    <strong>Error!</strong> This Card is Already Added.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
 
  <div class="container my-4">
  <button class="btn btn-outline-warning" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
  <i class="fa fa-plus"></i> Add New Card
  </button>
  <a href="id-card.php" class="btn btn-outline-dark">
  <i class="fa fa-address-card"></i> Generate ID Card
</a>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">

    <form method="POST" enctype="multipart/form-data">
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="inputCity">Employee ID</label>
        <input type="text" id="Employee_ID" name="Employee_ID" class="form-control" id="inputCity">
      </div>
      <div class="form-group col-md-6">
        <label for="inputCity">Employee Name</label>
        <input type="text" id="name" name="name" class="form-control" id="inputCity" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="inputZip">Date Of Birth</label>
        <input type="date" id="dob" name="dob" class="form-control" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputCity">Address</label>
        <input type="text" id="address" name="address" class="form-control" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="inputState">Email Id</label>
        <input type="text" id="email" name="email" class="form-control" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="inputZip">Expire Date</label>
        <input type="date" name="exp_date" class="form-control">
      </div>
    </div>
    
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="id_no">ID Card No.</label>
          <input class="form-control" id="id_no" name="id_no" readonly></input>
        </div>
        <div class="form-group col-md-3">
          <label for="phone">Phone No.</label>
          <input class="form-control" id="phone" name="phone" readonly></input>
        </div>
        <div class="form-group col-md-4">
          <label for="photo">Photo</label>
          <input type="file" id="img" name="image" />
        </div>
      </div>
      <button type="submit" class="btn btn-outline-dark"><i class="fa fa-plus"></i> Add Card</button>
    </form>
  </div>
</div>

  <div class="container my-4">


    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Name</th>
          <th scope="col">ID Card No.</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $sql = "SELECT * FROM `cards` order by 1 DESC";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['name'] . "</td>
            <td>". $row['id_no'] . "</td>
            <td> <button class='edit btn btn-sm btn btn-secondary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn btn-dark' id=d".$row['sno'].">Delete</button>  </td>
          </tr>";
        } 
          ?>


      </tbody>
    </table>
  </div>
 
 
  
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>
  <script>

    document.getElementById('Employee_ID').addEventListener('change', function () {
    var employeeId = this.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Parse the JSON response
                var employeeDetails = JSON.parse(xhr.responseText);
                // Populate the corresponding fields with employee details
                document.getElementById('name').value = employeeDetails.first_name + ' ' + employeeDetails.middle_name+ ' ' + employeeDetails.last_name ;

                document.getElementById('dob').value = employeeDetails.emp_bday;
                document.getElementById('address').value = employeeDetails.Address;
                document.getElementById('email').value = employeeDetails.email;
                document.getElementById('id_no').value = employeeDetails.Employee_ID;
                document.getElementById('phone').value = employeeDetails.Phone;
                document.getElementById('img').value = employeeDetails.img;
            } else {
                console.error('Error fetching employee details');
                // Clear the fields if an error occurs
                document.getElementById('name').value = '';
                document.getElementById('dob').value = '';
                document.getElementById('address').value = '';
                document.getElementById('email').value = '';
                document.getElementById('id_no').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('img').value = '';
            }
        }
    };
    xhr.open('GET', 'get_employee_details.php?Employee_ID=' + employeeId, true);
    xhr.send();
});


    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        name = tr.getElementsByTagName("td")[0].innerText;
        id_no = tr.getElementsByTagName("td")[1].innerText;
        console.log(name, id_no);
        nameEdit.value = name;
        id_noEdit.value = id_no;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `id.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
  </script>
</body>
</html>