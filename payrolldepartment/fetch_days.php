<?php
include ('db_connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['selectedMonth']) && isset($_POST['employeeID'])) {
    $selectedMonth = $_POST['selectedMonth'];
    $employeeID = $_POST['employeeID'];

    $salary_sql = "SELECT dailyrate, overtimerate FROM salary WHERE employeeid = $employeeID";
    $salary_result = $conn->query($salary_sql);
    $salary_row = $salary_result->fetch_assoc();
    $dailyRate = $salary_row['dailyrate'];
    $overtimeRate = $salary_row['overtimerate'];
    $sql = "SELECT COUNT(DISTINCT p.id) AS Days,
    COUNT(DISTINCT p.id) * 8 AS Hours,
    COALESCE(SUM(o.No_of_hours), 0) AS OvertimeHours,
    COALESCE(SUM(DATEDIFF(l.todate, l.fromdate)), 0) AS LeaveDays
FROM pending_attendance p
LEFT JOIN overtime_tbl o ON p.employee_ID = o.Employee_ID
LEFT JOIN leaves l ON p.employee_ID = l.eid
WHERE MONTH(p.date) = $selectedMonth 
AND p.employee_ID = $employeeID";

    $result = $conn->query($sql);
    $response = array();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['Days'] = $row['Days'];
        $response['Hours'] = $row['Hours'];
        $response['OvertimeHours'] = $row['OvertimeHours'];
        $response['LeaveDays'] = $row['LeaveDays'];

        $salary = ($dailyRate * $row['Days']);
        $overtimePay = ($overtimeRate * $row['OvertimeHours']);
        $response['Salary'] = $salary;
        $response['OvertimePay'] = $overtimePay;


        $tax_sql = "SELECT percentage FROM tax_table WHERE month = '$selectedMonth'";
        $tax_result = $conn->query($tax_sql);
        if ($tax_result->num_rows > 0) {
            $tax_row = $tax_result->fetch_assoc();
            $taxPercentage = $tax_row['percentage'];
            $response['TaxPercentage'] = $taxPercentage;
        } else {
            $response['TaxPercentage'] = 0;
        }

    }
    echo json_encode($response);
}
?>