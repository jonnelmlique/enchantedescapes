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

?>

<!DOCTYPE html>
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
       <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080; color: white;">Overtime</nav>
        
        <form class="d-flex ms-3" style="margin-bottom: 10px;" method="GET" action="">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search"
            value="<?php echo $search_query; ?>">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <table class="table table-hover text-center">
          <thead class="table-dark">
            <tr>
              <th scope="col">ID No.</th>
              <th scope="col">Last Name</th>
              <th scope="col">Date</th>
              <th scope="col">No. of Hours</th>
              <th scope="col">No. of Mins</th>
            
            </tr>
          </thead>
          <tbody>
            <?php
            // Construct the SQL query based on the search query
            // $sql = "SELECT * FROM `overtime_tbl`";
            $sql = "SELECT * FROM `overtime_tbl` WHERE Date = CURDATE()";
            if (!empty($search_query)) {
              $sql = "SELECT * FROM `overtime_tbl` WHERE Name LIKE '%$search_query%' OR Employee_ID LIKE '%$search_query%'";
            }

            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              ?>
              <tr>
                <td><?php echo $row['Employee_ID']; ?></td>
                <td><?php echo $row['Name']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['No_of_hours']; ?></td>
                <td><?php echo $row['No_of_mins']; ?></td>
               
                
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
</body>

</html>