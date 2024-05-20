<?php
include ('db_connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_salary'])) {
        $salaryID = $_POST['salary_id'];
        $dailyRate = $_POST['daily_salary'];
        $overtimeRate = $_POST['overtime_pay'];

        $stmt_update = $conn->prepare("UPDATE salary SET dailyrate = ?, overtimerate = ? WHERE salaryid = ?");
        $stmt_update->bind_param("ddi", $dailyRate, $overtimeRate, $salaryID);

        if ($stmt_update->execute()) {
            $message = "Salary record updated successfully.";
        } else {
            $message = "Error updating salary record: " . $stmt_update->error;
        }

        $stmt_update->close();
    } else {
        $employeeID = $_POST['employee_name'];
        $dailyRate = $_POST['daily_salary'];
        $overtimeRate = $_POST['overtime_pay'];

        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM salary WHERE employeeid = ?");
        $check_stmt->bind_param("i", $employeeID);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $message = "Employee already has a salary.";
        } else {
            $stmt_all = $conn->prepare("INSERT INTO salary (employeeid, dailyrate, overtimerate) VALUES (?, ?, ?)");
            $stmt_all->bind_param("idd", $employeeID, $dailyRate, $overtimeRate);

            if ($stmt_all->execute()) {
                $message = "Salary record added successfully.";
            } else {
                $message = "Error adding salary record: " . $stmt_all->error;
            }

            $stmt_all->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Salary</title>
    <link href="CSS/salary.css" rel="stylesheet">
    <script src="../partials/jquery.js"></script>
    <link rel="icon" href="Images/icon.png">
</head>

<body>
    <?php include ("./partials/nav.php"); ?>

    <script>
    $(function() {
        $("div.nav ul li").removeClass("active");
        $("div.nav ul li.salary").addClass("active");
    });
    </script>

    <div class="container">
        <?php if ($message): ?>
        <div class="alert <?php echo (strpos($message, 'successfully') !== false) ? 'success' : ''; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <button id="addSalaryBtn">Add Salary</button>

        <div id="addSalaryModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="addSalaryForm" method="POST" action="">
                    <h2>Add Salary</h2>
                    <div class="form-group">
                        <label for="employee_name">Employee:</label>
                        <select id="employee_name" name="employee_name" required>
                            <?php
                            echo "<option value='' disabled selected>Select Employee</option>";
                            $sql = "SELECT Employee_ID, CONCAT(Employee_ID, ' - ', last_name, ', ', first_name, ' ', middle_name) AS EmployeeName FROM employee_info ORDER BY last_name, first_name, middle_name";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["Employee_ID"] . "'>" . $row["EmployeeName"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No employees found</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="daily_salary">Daily Rate:</label>
                        <input type="number" id="daily_salary" name="daily_salary" placeholder="Enter Daily Salary"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="overtime_pay">Overtime:</label>
                        <input type="number" id="overtime_pay" name="overtime_pay" placeholder="Enter Overtime Pay"
                            required>
                    </div>
                    <div class="form-group-full">
                        <input type="submit" value="Add">
                    </div>
                </form>
            </div>
        </div>

        <div id="updateSalaryModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="updateSalaryForm" method="POST" action="">
                    <h2>Edit Salary</h2>
                    <input type="hidden" id="update_salary_id" name="salary_id">
                    <div class="form-group">
                        <label for="update_daily_salary">Daily Rate:</label>
                        <input type="number" id="update_daily_salary" name="daily_salary"
                            placeholder="Enter Daily Salary" required>
                    </div>

                    <div class="form-group">
                        <label for="update_overtime_pay">Overtime:</label>
                        <input type="number" id="update_overtime_pay" name="overtime_pay"
                            placeholder="Enter Overtime Pay" required>
                    </div>
                    <div class="form-group-full">
                        <input type="submit" name="update_salary" value="Update">
                    </div>
                </form>
            </div>
        </div>


        <table id="salary_table">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Daily Rate</th>
                    <th>Overtime Rate</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT s.salaryid, s.employeeid, CONCAT(e.last_name, ', ', e.first_name, ' ', e.middle_name) AS EmployeeName, s.dailyrate, s.overtimerate
                        FROM salary s
                        JOIN employee_info e ON s.employeeid = e.Employee_ID";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['employeeid']}</td>";
                        echo "<td>{$row['EmployeeName']}</td>";
                        echo "<td>{$row['dailyrate']}</td>";
                        echo "<td>{$row['overtimerate']}</td>";
                        echo "<td>
                                <button class='edit-btn' data-id='{$row['salaryid']}' data-daily='{$row['dailyrate']}' data-overtime='{$row['overtimerate']}'>Edit</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No salary records available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php $conn->close(); ?>
    <script src="./partials/jquery.js"></script>

    <script>
    var addModal = document.getElementById("addSalaryModal");
    var updateModal = document.getElementById("updateSalaryModal");

    var addBtn = document.getElementById("addSalaryBtn");

    var spans = document.getElementsByClassName("close");
    for (var i = 0; i < spans.length; i++) {
        spans[i].onclick = function() {
            addModal.style.display = "none";
            updateModal.style.display = "none";
        }
    }
    addBtn.onclick = function() {
        addModal.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    $(document).on("click", ".edit-btn", function() {
        var salaryID = $(this).data("id");
        var dailyRate = $(this).data("daily");
        var overtimeRate = $(this).data("overtime");
        $("#update_salary_id").val(salaryID);
        $("#update_daily_salary").val(dailyRate);
        $("#update_overtime_pay").val(overtimeRate);

        updateModal.style.display = "block";
    });
    </script>

</body>

</html>