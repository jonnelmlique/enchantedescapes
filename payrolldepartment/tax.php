<?php
include ('db_connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getMonthName($month)
{
    return date('F', mktime(0, 0, 0, $month, 1));
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedMonth = $_POST['selectedMonth'];
    $percentage = $_POST['percentage'];
    $action = $_POST['action'];

    if (!is_numeric($percentage) || $percentage < 0 || $percentage > 100) {
        $message = "Error: Percentage must be a number between 0 and 100.";
    } else {
        if ($action == 'add') {
            $check_sql = "SELECT * FROM tax_table WHERE month = '$selectedMonth'";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows > 0) {
                $message = "Error: Tax entry already exists for " . getMonthName($selectedMonth);
            } else {
                $insert_sql = "INSERT INTO tax_table (month, percentage) VALUES ('$selectedMonth', '$percentage')";
                if ($conn->query($insert_sql) === TRUE) {
                    $message = "New record created successfully";
                } else {
                    $message = "Error: " . $insert_sql . "<br>" . $conn->error;
                }
            }
        } elseif ($action == 'update') {
            $update_sql = "UPDATE tax_table SET percentage='$percentage' WHERE month='$selectedMonth'";
            if ($conn->query($update_sql) === TRUE) {
                $message = "Record updated successfully";
            } else {
                $message = "Error updating record: " . $conn->error;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Tax</title>
    <link href="CSS/tax.css" rel="stylesheet">
    <script src="../partials/jquery.js"></script>
    <link rel="icon" href="Images/icon.png">
</head>

<body>

    <?php include ("./partials/nav.php"); ?>

    <script>
    $(function() {
        $("div.nav ul li").removeClass("active");
        $("div.nav ul li.tax").addClass("active");
    });
    </script>

    <div class="container">
        <?php if ($message): ?>
        <div class="alert <?php echo (strpos($message, 'successfully') !== false) ? 'success' : ''; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <button id="addTaxBtn">Add Tax</button>

        <div id="taxModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="tax_form" method="POST" action="">
                    <h2 id="modalTitle">Add Tax</h2>
                    <div class="form-group">
                        <label for="month">Effective Month:</label>
                        <select id="selectedMonth" name="selectedMonth">
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

                    <div class="form-group">
                        <label for="percentage">Percentage:</label>
                        <input type="number" id="percentage" name="percentage" placeholder="Enter Percentage" required>
                    </div>

                    <div class="form-group-full">
                        <input type="hidden" id="action" name="action" value="add">
                        <input type="submit" value="Add">
                    </div>
                </form>
            </div>
        </div>

        <table id="tax_table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Percentage</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tax_table";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . getMonthName($row['month']) . "</td>";
                        echo "<td>{$row['percentage']}%</td>";
                        echo "<td><button class='updateBtn' data-month='{$row['month']}' data-percentage='{$row['percentage']}'>Update</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php $conn->close(); ?>

    <script>
    var modal = document.getElementById("taxModal");
    var btn = document.getElementById("addTaxBtn");
    var span = document.getElementsByClassName("close")[0];
    var actionInput = document.getElementById("action");
    var modalTitle = document.getElementById("modalTitle");
    var submitBtn = document.querySelector('#taxModal [type="submit"]');

    btn.onclick = function() {
        actionInput.value = "add";
        modalTitle.innerText = "Add Tax";
        submitBtn.value = "Add";
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

    var updateBtns = document.querySelectorAll('.updateBtn');
    updateBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var monthNumber = this.getAttribute('data-month');
            var monthName = getMonthName(monthNumber);
            var percentage = this.getAttribute('data-percentage');
            document.getElementById("selectedMonth").innerHTML = "<option value='" + monthNumber +
                "'>" + monthName + "</option>";
            document.getElementById("percentage").value = percentage;
            actionInput.value = "update";
            modalTitle.innerText = "Update Tax";
            submitBtn.value = "Update";
            modal.style.display = "block";
        });
    });

    function getMonthName(monthNumber) {
        var months = [
            "January", "February", "March", "April", "May", "June", "July",
            "August", "September", "October", "November", "December"
        ];
        return months[monthNumber - 1];
    }
    </script>

</body>

</html>