<?php
include ('db_connection.php');

if (isset($_GET['employee']) && isset($_GET['month'])) {
    $selectedEmployee = $_GET['employee'];
    $selectedMonth = $_GET['month'];

    $sql = "SELECT e.Employee_ID, 
            SUM(CASE WHEN MONTH(p.date) = '$selectedMonth' THEN 1 ELSE 0 END) AS Days,
            SUM(CASE WHEN MONTH(p.date) = '$selectedMonth' THEN 8 ELSE 0 END) AS Hours,
            COALESCE(SUM(CASE WHEN MONTH(l.fromdate) = '$selectedMonth' THEN DATEDIFF(l.todate, l.fromdate) ELSE 0 END), 0) AS leave_days,
            COALESCE(SUM(CASE WHEN MONTH(o.date) = '$selectedMonth' THEN o.No_of_hours ELSE 0 END), 0) AS overtime_hours
            FROM employee_info e 
            LEFT JOIN pending_attendance p ON e.Employee_ID = p.employee_ID 
            LEFT JOIN leaves l ON e.Employee_ID = l.eid
            LEFT JOIN overtime_tbl o ON e.Employee_ID = o.Employee_ID
            WHERE e.first_name = '$selectedEmployee'"; 

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        echo json_encode($row);
    } else {
        echo json_encode(array("error" => "Failed to fetch employee details"));
    }
} else {
    echo json_encode(array("error" => "No employee parameter provided"));
}
?>