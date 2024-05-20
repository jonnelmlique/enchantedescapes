<?php
include ('db_connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['employeeID'])) {
    $employeeID = $_POST['employeeID'];

    $sql = "SELECT * FROM payrolltbl WHERE employeeid = $employeeID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $response = array(
            'month' => $row['month'],
            'employee_name' => $row['employee_name'],
            'hours' => $row['hours'],
            'days' => $row['dayspresent'],
            'overtime_hours' => $row['overtimehours'],
            'leave_days' => $row['leavedays'],
            'salary' => $row['salary'],
            'overtime' => $row['overtime'],
            'taxrate' => $row['taxrate'],
            'totalsalary' => $row['totalsalary']
        );

        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'No payroll information found for the employee.'));
    }
}
?>