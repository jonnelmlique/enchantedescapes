<?php
include 'db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $month = $_POST['selectedMonth'];
    $employeeId = $_POST['employee_name'];
    $hours = $_POST['hours'];
    $daysPresent = $_POST['days'];
    $overtimeHours = $_POST['overtime_hours'];
    $leaveDays = $_POST['leave_days'];
    $salary = $_POST['daily_salary'];
    $overtimePay = $_POST['overtime_pay'];
    $taxRate = $_POST['tax_rate'];
    $totalSalary = $_POST['totalsalary'];

    $stmt = $conn->prepare("SELECT CONCAT(last_name, ', ', first_name, ' ', middle_name) AS EmployeeName FROM employee_info WHERE Employee_ID = ?");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $employeeName = $row['EmployeeName'];
    $stmt = $conn->prepare("INSERT INTO payrolltbl (month, employee_name, employeeid, hours, dayspresent, overtimehours, leavedays, salary, overtime, taxrate, totalsalary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiiiiiddd", $month, $employeeName, $employeeId, $hours, $daysPresent, $overtimeHours, $leaveDays, $salary, $overtimePay, $taxRate, $totalSalary);
    $stmt->execute();

    $payrollId = $conn->insert_id;

    // Prepare the response as an array
    $response = array(
        'message' => 'Payroll generated successfully!',
        'payroll_id' => $payrollId // Include the payroll ID in the response
    );

    // Encode the response as JSON and echo it
    echo json_encode($response);
//...
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>". $row["payrollid"]. "</td>";
    echo "<td>". $row["month"]. "</td>";
    echo "<td>". $row["employee_name"]. "</td>";
    echo "<td>". $row["hours"]. "</td>";
    echo "<td>". $row["dayspresent"]. "</td>";
    echo "<td>". $row["overtimehours"]. "</td>";
    echo "<td>". $row["leavedays"]. "</td>";
    echo "<td>". $row["salary"]. "</td>";
    echo "<td>". $row["overtime"]. "</td>";
    echo "<td>". $row["taxrate"]. "</td>";
    echo "<td>". $row["totalsalary"]. "</td>";
    echo "<td><button class='update-btn' data-id='". $row["payrollid"]. "'>Update</button></td>";
    echo "</tr>";
}
//...

}
?>
