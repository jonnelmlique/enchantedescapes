<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="../styles/admin/print.css">

</head>

<body>
    <div id="printSection" class="receipt">
        <img src="../assets/enhanted.png" alt="EEH Logo" class="logo">

        <h1>Monthly Reports</h1>
        <div class="details">

            <table class="table" id="printtable">
                <thead>
                    <tr>
                        <td class="bg-dark text-white">#</td>
                        <td class="bg-dark text-white">Guest Details</td>
                        <td class="bg-dark text-white">Room Details</td>
                        <td class="bg-dark text-white">Booking Details</td>
                        <td class="bg-dark text-white">Payment Details</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../src/config/config.php';

                    $firstDayOfMonth = date("Y-m-01");
                    $lastDayOfMonth = date("Y-m-t");

                    $sql = "SELECT rp.*, r.roomtype, rp.roomnumber AS roomno, rp.roomfloor 
        FROM reservationprocess rp 
        INNER JOIN room r ON rp.roomid = r.roomid
        WHERE rp.status = 'Accepted' or rp.status = 'Check-In' or rp.status = 'Check-Out' 
        AND DATE(rp.reservationcompleted) BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
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



                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No reservations found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
            <button id="printButton" style="display: none;">Print Low Stock Products</button>
        </div>
    </div>

    <script>
    function printReceipt() {
        var printContents = document.getElementById("printSection").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    document.getElementById('printButton').addEventListener('click', printReceipt);

    window.onload = function() {
        printReceipt(); // Automatically trigger print on page load
    };
    </script>
</body>

</html>