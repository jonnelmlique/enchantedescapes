<!DOCTYPE html>
<html>

<head>
    <title>Employee Records</title>
    <link href="CSS/employee.css" rel="stylesheet">
    <script src="../partials/jquery.js"></script>
    <link rel="icon" href="Images/icon.png">
    
</head>

    <body>
    <?php
            include("./partials/nav.php");
        ?>

    <script>
        $( function(){
            $("div.nav ul li").removeClass("active");
            $("div.nav ul li.emp").addClass("active");
        });
        
    </script>


        <div class="container">
                <h1 class="mt-5">Employee Records</h1>
               

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="month">Month:
                            <select id="selectedMonth" name="selectedMonth" onchange="fetchEmployeeDetails()">
                                <option value="" disabled>Select Month</option>
                                <?php
                                $currentMonth = date('m');
                                for ($i = 1; $i <= 12; $i++) {
                                    $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                                    $monthName = date('F', mktime(0, 0, 0, $i, 1));
                                    $selected = ($currentMonth == $month) ? 'selected' : '';
                                    echo "<option value='$month' $selected>$monthName</option>";
                                }
                                ?>
                            </select></label>
                            <div class="table-container">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Hours</th>
                                    <th>Days</th>
                                    <th>Overtime</th>
                                    <th>Leave Days</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include ('db_connection.php');

                                $sql = "SELECT DISTINCT e.Employee_ID, e.first_name, e.last_name, e.middle_name, e.position, e.Department, e.status, r.Hours, r.Days, CONCAT(o.No_of_hours, ':', o.No_of_mins) AS Overtime, r.leave_days
                                        FROM employee_info e
                                        LEFT JOIN employee_record r ON e.Employee_ID = r.Employee_ID
                                        LEFT JOIN overtime_tbl o ON e.Employee_ID = o.Employee_ID";
                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['Employee_ID'] . "</td>";
                                    echo "<td>" . $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] . "</td>";
                                    echo "<td>" . $row['position'] . "</td>";
                                    echo "<td>" . $row['Department'] . "</td>";
                                    echo "<td>" . $row['Hours'] . "</td>";
                                    echo "<td>" . $row['Days'] . "</td>";
                                    echo "<td>" . $row['Overtime'] . "</td>";
                                    echo "<td>" . $row['leave_days'] . "</td>";
                                    echo "<td class='status'>" . $row['status'] . "</td>";
                                    echo "</tr>";
                                }

                                mysqli_close($conn);
                                ?>
                            </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>



</body>

</html>