<?php
include '../src/config/config.php';

if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $sql = "SELECT rp.*, r.roomtype, rp.roomnumber AS roomno, rp.roomfloor 
            FROM reservationprocess rp 
            INNER JOIN room r ON rp.roomid = r.roomid
            WHERE rp.status = 'Accepted' or rp.status = 'Check-In' or rp.status = 'Check-Out' 
            AND DATE(rp.reservationcompleted) BETWEEN '$startDate' AND '$endDate'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo "" . $row["recervationprocessid"] . "<br />";
            echo "</td>";
            echo "<td>";
            echo "<b>Name</b>: " . $row["firstname"] . " " . $row["lastname"] . "<br />";
            echo "<b>Phone No</b>: " . $row["mobilenumber"] . "<br />";

            echo "</td>";
            echo "<td>";
            echo "<b>Room Type</b>: " . $row["roomtype"] . "<br />";
            echo "<b>Room No</b>: " . $row["roomno"] . "<br />";
            echo "<b>Room Floor</b>: " . $row["roomfloor"] . "<br />";
            echo "</td>";
            echo "<td>";
            echo "<b>Check-In</b>: " . $row["checkindate"] . " " . date("h:i A", strtotime($row["checkintime"])) . "<br />";
            echo "<b>Check-Out</b>: " . $row["checkoutdate"] . " " . date("h:i A", strtotime($row["checkouttime"])) . "<br />";
            echo "<b>Adults</b>: " . $row["adults"] . "<br />";
            echo "<b>Children</b>: " . $row["children"] . "<br />";
            echo "</td>";
            echo "<td>";
            echo "<b>Payment</b>: " . $row["paymentmethod"] . "<br />";
            echo "<b>Transaction id</b>: " . $row["transactionid"] . "<br />";
            echo "<b>Completed</b>: " . date("Y-m-d", strtotime($row["reservationcompleted"])) . "<br />";
            echo "<b>Paid</b>: ₱" . number_format($row["totalafterpromo"], 2) . "<br />";


            echo "</td>";

            echo "<td>";
            switch ($row["status"]) {
                case "Pending":
                    echo "<button class='btn btn-info w-100' style='border-radius: 8px'>Pending</button>";
                    break;
                case "Accepted":
                    echo "<button class='btn btn-success w-100' style='border-radius: 8px'>Accepted</button>";
                    break;
                case "Check-In":
                    echo "<button class='btn btn-success w-100' style='border-radius: 8px'>Check-In</button>";
                    break;
                case "Check-Out":
                    echo "<button class='btn btn-success w-100' style='border-radius: 8px'>Check-Out</button>";
                    break;
                case "Cancelled":
                    echo "<button class='btn btn-danger w-100' style='border-radius: 8px'>Cancelled</button>";
                    break;
                case "Payment Failed":
                    echo "<button class='btn btn-warning w-100' style='border-radius: 8px'>Payment Failed</button>";
                    break;
                default:
                    echo "<button class='btn btn-secondary w-100' style='border-radius: 8px'>Unknown</button>";
                    break;
            }
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No reservations found for selected date range</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>Invalid request</td></tr>";
}

$conn->close();
?>