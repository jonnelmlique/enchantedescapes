<?php
// Include necessary files
include "../db_conn.php";
include "sidebar.php";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    <title>View Schedules</title>

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
                <nav class="navbar justify-content-center fs-3 mb-3" style="background-color:#808080;">Employee Schedule</nav>
                <!-- <a href="add-schedule.php" class="btn btn-warning mb-3">Add Schedule</a> -->
                <form class="d-flex ms-3" style="margin-bottom: 10px;" method="GET" action="">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo $search_query; ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <?php
                if (!empty($search_query)) {
                    // Construct the SQL query based on the search query
                    $sql = "SELECT * FROM `schedule` WHERE `Employee_ID` LIKE '%$search_query%' OR `Name` LIKE '%$search_query%'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                ?>
                        <table class="table table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Employee ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col"> Start Date</th>
                                    <th scope="col"> End Date</th>
                                    <th scope="col">Time-in</th>
                                    <th scope="col">Time-out</th>
                                    <th scope="col">Schedule days</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['Employee_ID']; ?></td>
                                        <td><?php echo $row['Name']; ?></td>
                                        <td><?php echo date("F d, Y", strtotime($row['start_date'])); ?></td>
                                        <td><?php echo date("F d, Y", strtotime($row['end_date'])); ?></td>
                                        <td><?php echo date("h:iA", strtotime($row['Time_in'])); ?></td>
                                        <td><?php echo date("h:iA", strtotime($row['Time_out'])); ?></td>
                                        <td>
                                            <?php 
                                                // Get the schedule days from the database
                                                $schedule_days = $row['schedule_days'];
                                                
                                                // Split the schedule days string into an array of days
                                                $days_array = explode(',', $schedule_days);
                                                
                                                // Iterate through each day and display its abbreviation
                                                foreach ($days_array as $day) {
                                                    // Check if the day is Thursday or Sunday and output the appropriate abbreviation
                                                    if ($day == "Thursday") {
                                                        echo "TH";
                                                    } elseif ($day == "Sunday") {
                                                        echo "SU";
                                                    } else {
                                                        echo substr($day, 0, 1); // Output the first letter of each day
                                                    }
                                                    
                                                    // Add a comma if it's not the last day
                                                    if ($day !== end($days_array)) {
                                                        echo ',';
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    } else {
                        echo "<p>No schedule found for the given search query.</p>";
                    }
                } else {
                    echo "<p>Please enter your Employee ID or Name to view your schedule.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
