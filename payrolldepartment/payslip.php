<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Payslip</title>
    <link rel="icon" href="Images/icon.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            
        }

        .logo img {
            max-width: 100px;
            height: auto;
        }

        .heading {
            text-align: center;
            
        }

        .heading h2 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .payslip {
            border-top: 2px solid #333;
            padding-top: 20px;
            
        }

        .payslip label {
            font-weight: bold;
            display: block;
            
        }

        .payslip input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            background-color: #f9f9f9;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="logo">
            <img src="Images/Logo.png" alt="Logo">
        </div>
        <div class="heading">
            <h2>Payslip</h2>
        </div>
        <div class="payslip">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include ('db_connection.php');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $payrollId = isset($_GET['payroll_id']) ? $_GET['payroll_id'] : '';


    if (!empty($payrollId)) {
        $stmt = $conn->prepare("SELECT * FROM payrolltbl WHERE payrollid = ?");
        $stmt->bind_param("i", $payrollId);
        $stmt->execute();
        $result = $stmt->get_result();
        $payrollData = $result->fetch_assoc();

        if ($payrollData) {
            ?>
            <form id="payroll" class="d-flex ms-3" method="POST" action="">
                <label for="month">Month:</label>
                <input type="text" id="month" name="month" placeholder="Month" readonly
                    value="<?php echo $payrollData['month']; ?>">

                <label for="employee_name">Employee:</label>
                <input type="text" id="employee_name" name="employee_name" placeholder="Employee Name" readonly
                    value="<?php echo $payrollData['employee_name']; ?>">

                <label for="hours">Hours:</label>
                <input type="text" id="hours" name="hours" placeholder="Hours" readonly
                    value="<?php echo $payrollData['hours']; ?>">
                <label for="days">Days Present:</label>
                <input type="text" id="days" name="days" placeholder="Days" readonly
                    value="<?php echo $payrollData['dayspresent']; ?>"><br>
                <label for="overtime_hours">Overtime Hours:</label>
                <input type="text" id="overtime_hours" name="overtime_hours" placeholder="Overtime Hours" readonly
                    value="<?php echo $payrollData['overtimehours']; ?>">
                <label for="leave_days">Leave Days:</label>
                <input type="text" id="leave_days" name="leave_days" placeholder="Leave Days" readonly
                    value="<?php echo $payrollData['leavedays']; ?>"><br>
                <label for="daily_salary">Salary :</label>
                <input type="text" id="salary" name="daily_salary" placeholder="Daily Salary" readonly
                    value="<?php echo $payrollData['salary']; ?>">
                <label for="overtime_pay">Overtime:</label>
                <input type="text" id="overtime_pay" name="overtime_pay" placeholder="Overtime Pay" readonly
                    value="<?php echo $payrollData['overtime']; ?>"><br>
                <label for="tax_rate">Tax Rate (%):</label>
                <input type="text" id="tax_rate" name="tax_rate" placeholder="Tax Rate" readonly
                    value="<?php echo $payrollData['taxrate']; ?>">
                <label for="totalsalary">Total Salary:</label>
                <input type="text" id="total_salary" name="totalsalary" placeholder="Total Salary" readonly
                    value="<?php echo $payrollData['totalsalary']; ?>"><br>
            </form>
            <?php
        } else {
            echo "<p>Error: Payroll data not found.</p>";
        }
    }

    ?>

</div>
        <div class="footer">
            Payroll Employee Management System
        </div>
    </div>

</body>

</html>