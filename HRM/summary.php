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
    <title>Summary</title>

    <!-- CSS -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">
</head>

<body>

    <body>

        <div class="main p-3">
            <div class="text-center">
                <div class="container">

                    <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080; color:white;">
                        Summary
                        Reports</nav>

                    <form class="d-flex ms-3" method="GET" action="">
                        <button class="btn btn-primary me-4" id="print-table-btn"><i
                                class="fa-solid fa-print fs-5"></i></button>
                        <select class="form-select" name="selectedMonth">
                            <option value="" disabled>Select Month</option>
                            <?php 
              // Get the current month
              $currentMonth = date('m');

              // Create options for each month
              for ($i = 1; $i <= 12; $i++) {
                $month = str_pad($i, 2, '0', STR_PAD_LEFT); // Zero padding for single digit months
                $monthName = date('F', mktime(0, 0, 0, $i, 1)); // Get month name
                $selected = ($currentMonth == $month) ? 'selected' : ''; // Mark current month as selected
                echo "<option value='$month' $selected>$monthName</option>";
              }
            ?>
                        </select>

                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                            name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                        <button class="btn btn-outline-success me-4" type="submit">Search</button>
                    </form>
                    <br>

                    <?php
        $sql = "SELECT e.first_name, e.middle_name, e.last_name, e.Employee_ID, 
            COUNT(DISTINCT p.id) AS Days, 
            COUNT(DISTINCT p.id) * 8 AS Hours,
            COALESCE(SUM(DATEDIFF(l.todate, l.fromdate)), 0) AS leave_days,
            COALESCE(SUM(o.No_of_hours), 0) AS overtime_hours
            FROM employee_info e 
            JOIN pending_attendance p ON e.Employee_ID = p.employee_ID 
            LEFT JOIN leaves l ON e.Employee_ID = l.eid
            LEFT JOIN overtime_tbl o ON e.Employee_ID = o.Employee_ID";

        if (!empty($search_query) || isset($_GET['selectedMonth'])) {
          $sql .= " WHERE ";
          if (!empty($search_query)) {
            $sql .= " e.Employee_ID LIKE '%$search_query%'";
          }
          if (isset($_GET['selectedMonth'])) {
            $selectedMonth = $_GET['selectedMonth'];
            if (!empty($search_query)) {
              $sql .= " AND ";
            }
            $sql .= "MONTH(p.Date) = " . $selectedMonth;
          }
        }
        $sql .= " GROUP BY e.Employee_ID, e.first_name, e.middle_name, e.last_name";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
          die('Error: ' . mysqli_error($conn));
        }
        ?>

                    <table class="table table-hover text-center" id="print-table">
                        <thead class="table-dark">
                            <tr>
                                <th colspan="6">
                                    <?php
                // Get the name of the selected month
                $selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : date('m');
                // Get the name of the selected month
                $selectedMonthName = date('F', mktime(0, 0, 0, $selectedMonth, 1));
                $currentMonthWithWeek = $selectedMonthName . ' ' . date('Y');
                echo htmlspecialchars($currentMonthWithWeek);
                ?>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col">ID No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">No. of Hours</th>
                                <th scope="col">No. of Days</th>
                                <th scope="col">Overtime</th>
                                <th scope="col">Leave Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Employee_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['Hours']); ?></td>
                                <td><?php echo htmlspecialchars($row['Days']); ?></td>
                                <td><?php echo htmlspecialchars($row['overtime_hours']); ?></td>
                                <td><?php echo htmlspecialchars($row['leave_days']); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>


                    <!-- Bootstrap JS -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
                        crossorigin="anonymous"></script>
                    <!-- Custom Script -->
                    <script>
                    document.getElementById('print-table-btn').addEventListener('click', function() {
                        var printContents = document.getElementById('print-table').outerHTML;
                        var originalContents = document.body.innerHTML;
                        document.body.innerHTML = printContents;
                        window.print();
                        document.body.innerHTML = originalContents;
                    });
                    </script>
                </div>
            </div>
        </div>
    </body>

</html>