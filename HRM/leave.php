<?php
include "db_conn.php";
include "sidebar.php";

$search_query = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
  $search_query = $_GET["search"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leave Management</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
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
        ?>       <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080; color: white;">Leave Management</nav>
        <a href="add-leave.php" class="btn btn-warning mb-3">Add New</a>
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
              <th scope="col">Leave Application</th>
              <th scope="col">From Date - To Date</th>
              <th scope="col">Days</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM `leaves`";
            if (!empty($search_query)) {
              $sql .= " WHERE ename LIKE '%$search_query%' OR eid LIKE '%$search_query%'";
            }
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $datetime1 = new DateTime($row['fromdate']);
              $datetime2 = new DateTime($row['todate']);
              $interval = $datetime1->diff($datetime2);
              ?>
              <tr>
                <td><?php echo $row['eid']; ?></td>
                <td><?php echo $row['ename']; ?></td>
                <td><?php echo $row['descr']; ?></td>
                <td><?php echo $datetime1->format('Y/m/d') . ' - ' . $datetime2->format('Y/m/d'); ?></td>
                <td><?php echo $interval->format('%a Day/s'); ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                  <a href="show-leave.php?id=<?php echo $row["id"]; ?>" class="link-dark"><i
                      class="fa-regular fa-eye fs-5"></i></a>
                  <?php
                  if ($row['status'] === "Pending") {
                  ?>
                  <a href="update-leave.php?id=<?php echo $row["id"]; ?>" class="link-dark"><i
                      class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                  <?php
                  } 
                  ?>
                  <a href="remove.php?id=<?php echo $row["id"]; ?>&table=leaves&header=leave.php" class="link-dark"><i
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>