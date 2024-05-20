<?php
include ('db_connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Generation</title>
    <link href="CSS/payroll.css" rel="stylesheet">
    <script src="../partials/jquery.js"></script>
    <link rel="icon" href="Images/icon.png">
    
</head>

<body>
    <?php
    
        include("./partials/nav.php");

        // Display status messages
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo "<p class='success-message'>Payroll updated successfully.</p>";
            } elseif ($_GET['status'] == 'error' && isset($_GET['message'])) {
                echo "<p class='error-message'>Error updating payroll: " . htmlspecialchars($_GET['message']) . "</p>";
            }
        }
    
    ?>

    <script>
        $( function(){
            $("div.nav ul li").removeClass("active");
            $("div.nav ul li.pay").addClass("active");
        });
    </script>

    <div class="container">
        <div id="myModal" class="modal">

            <form id="payroll_form" method="POST" action="generate_payroll.php">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <h2>Payroll Generation</h2>
                    <div class="">
                        <label for="month">Month:</label>
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
                        </select>
                    </div>

                    <div class="">
                        <label for="employee_name">Employee:</label>
                        <select id="employee_name" name="employee_name" required onchange="fetchEmployeeDetails()">
                            <?php
                            echo "<option value='' disabled selected>Select Employee</option>";
                            $sql = "SELECT Employee_ID, CONCAT(Employee_ID, ' - ', last_name, ', ', first_name, ' ', middle_name) AS EmployeeName FROM employee_info ORDER BY last_name, first_name, middle_name";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["Employee_ID"] . "'>" . $row["EmployeeName"] . "</option>";
                                }
                            } else {
                                echo "0 results";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hours">Hours:</label>
                        <input type="text" id="hours" name="hours" placeholder="Hours" readonly>
                    </div>

                    <div class="form-group">
                        <label for="days">Days Present:</label>
                        <input type="text" id="days" name="days" placeholder="Days" readonly>
                    </div>

                    <div class="form-group">
                        <label for="overtime_hours">Overtime Hours:</label>
                        <input type="text" id="overtime_hours" name="overtime_hours" placeholder="Overtime Hours" readonly>
                    </div>

                    <div class="form-group">
                        <label for="leave_days">Leave Days:</label>
                        <input type="text" id="leave_days" name="leave_days" placeholder="Leave Days" readonly>
                    </div>

                    <div class="form-group">
                        <label for="daily_salary">Salary:</label>
                        <input type="text" id="salary" name="daily_salary" placeholder="Daily Salary" readonly>
                    </div>

                    <div class="form-group">
                        <label for="overtime_pay">Overtime:</label>
                        <input type="text" id="overtime_pay" name="overtime_pay" placeholder="Overtime Pay" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tax_rate">Tax Rate (%):</label>
                        <input type="text" id="tax_rate" name="tax_rate" placeholder="Tax Rate" readonly>
                    </div>

                    <div class="form-group">
                        <label for="totalsalary">Total Salary:</label>
                        <input type="text" id="total_salary" name="totalsalary" placeholder="Total Salary" readonly>
                    </div>

                    <div class="form-group form-group-full">
                        <input type="submit" value="Generate Payroll">
                    </div>
                </div>
            </form>
        </div>
        
        <div class="button-container">
            <button id="openModalBtn">Generate Payroll</button>
        </div>
        <h1>Payroll List</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Payroll ID</th>
                        <th>Month</th>
                        <th>Employee Name</th>
                        <th>Hours</th>
                        <th>Days Present</th>
                        <th>Overtime Hours</th>
                        <th>Leave Days</th>
                        <th>Salary</th>
                        <th>Overtime Pay</th>
                        <th>Tax Rate (%)</th>
                        <th>Total Salary</th>
                        <th>Actions</th>
                    </tr>

                </thead>
               <!-- In your payroll list table (part of your main file) -->
               <tbody>
                    <?php
                    include('db_connection.php');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM payrolltbl ORDER BY payrollid DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["payrollid"] . "</td>";
                            echo "<td>" . $row["month"] . "</td>";
                            echo "<td>" . $row["employee_name"] . "</td>";
                            echo "<td>" . $row["hours"] . "</td>";
                            echo "<td>" . $row["dayspresent"] . "</td>";
                            echo "<td>" . $row["overtimehours"] . "</td>";
                            echo "<td>" . $row["leavedays"] . "</td>";
                            echo "<td>" . $row["salary"] . "</td>";
                            echo "<td>" . $row["overtime"] . "</td>";
                            echo "<td>" . $row["taxrate"] . "</td>";
                            echo "<td>" . $row["totalsalary"] . "</td>";
                            echo "<td><button class=\"delete-button\" onclick=\"deletePayroll(" . $row["payrollid"] . ")\">Delete</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No payroll records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>

            </table>
        </div>    
    </div>
    
    





    <script>
      
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
          modal.style.display = "block";
        }

        span.onclick = function() {
          modal.style.display = "none";
        }

        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }

        function fetchEmployeeDetails() {
            var selectedMonth = document.getElementById("selectedMonth").value;
            var employeeID = document.getElementById("employee_name").value;

            $.ajax({
            type: 'POST',
            url: 'fetch_days.php',
            data: {
                selectedMonth: selectedMonth,
                employeeID: employeeID
            },
            dataType: 'json',
            success: function(response) {
                document.getElementById("days").value = response.Days;
                document.getElementById("hours").value = response.Hours;
                document.getElementById("overtime_hours").value = response.OvertimeHours;
                document.getElementById("leave_days").value = response.LeaveDays;
                document.getElementById("salary").value = response.Salary;
                document.getElementById("overtime_pay").value = response.OvertimePay;

                document.getElementById("tax_rate").value = response.TaxPercentage;

                var salary = parseFloat(response.Salary);
                var overtimePay = parseFloat(response.OvertimePay);
                var taxRate = parseFloat(response.TaxPercentage);
                var totalSalary = salary + overtimePay - taxRate;

                document.getElementById("total_salary").value = totalSalary;

            }
        });
        
    }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
    $(document).ready(function() {
        $('#payroll_form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'generate_payroll.php',
                data: $(this).serialize(),
                success: function(response) {
                    
                    var data = JSON.parse(response);
                    
                    alert(data.message);
                   
                    var payslipWindow = window.open('payslip.php?payroll_id=' + data.payroll_id, '_blank');
                    payslipWindow.print();
                    
                    $('#myModal').modal('hide');
                },
                error: function() {
                    alert('There was an error generating the payroll. Please try again.');
                }
            });
        });
    });
</script>

<script>
    function deletePayroll(payrollid) {
        if (confirm('Are you sure you want to delete this payroll record?')) {
            window.location.href = 'delete_payroll.php?id=' + payrollid;
        }
    }
</script>



</body>

</html>