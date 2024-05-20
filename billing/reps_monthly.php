<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="https://www.opensource.org/licenses/mit-license/">
    <style>
        /* reset */
        * {
            border: 0;
            box-sizing: content-box;
            color: inherit;
            font-family: inherit;
            font-size: inherit;
            font-style: inherit;
            font-weight: inherit;
            line-height: inherit;
            list-style: none;
            margin: 0;
            padding: 0;
            text-decoration: none;
            vertical-align: top;
        }
        
        /* content editable */
        *[contenteditable] {
            border-radius: 0.25em;
            min-width: 1em;
            outline: 0;
        }
        *[contenteditable] {
            cursor: pointer;
        }
        *[contenteditable]:hover,
        *[contenteditable]:focus,
        td:hover *[contenteditable],
        td:focus *[contenteditable],
        img.hover {
            background: #DEF;
            box-shadow: 0 0 1em 0.5em #DEF;
        }
        span[contenteditable] {
            display: inline-block;
        }
        
        /* heading */
        h1 {
            font: bold 100% sans-serif;
            letter-spacing: 0.5em;
            text-align: center;
            text-transform: uppercase;
        }
        
        /* table */
        table {
            font-size: 75%;
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
        }
        th,
        td {
            border: 1px solid #DDD;
            padding: 0.5em;
            position: relative;
            text-align: left;
        }
        th {
            background: #EEE;
        }
        td {
            border-color: #DDD;
        }
        
        /* page */
        html {
            font: 16px/1 'Open Sans', sans-serif;
            overflow: auto;
            padding: 0.5in;
            background: #999;
            cursor: default;
        }
        body {
            box-sizing: border-box;
            height: 11in;
            margin: 0 auto;
            overflow: hidden;
            padding: 0.5in;
            width: 8.5in;
            background: #FFF;
            border-radius: 1px;
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        }
        
        /* header */
        header {
            margin: 0 0 3em;
            overflow: hidden;
        }
        header h1 {
            background: #d3d308;
            border-radius: 0.25em;
            color: #FFF;
            margin: 0 0 1em;
            padding: 0.5em 0;
            text-align: center;
        }
        header address {
            float: left;
            font-size: 75%;
            font-style: normal;
            line-height: 1.25;
            margin: 0 1em 1em 0;
        }
        header address p {
            margin: 0 0 0.25em;
        }
        header span,
        header img {
            display: block;
            float: right;
            max-height: 25%;
            max-width: 60%;
            margin: 0 1em 1em 0;
            position: relative;
        }
        header img {
            max-height: 100%;
            max-width: 100%;
        }
        header input {
            cursor: pointer;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            height: 100%;
            left: 0;
            opacity: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }
        
        /* article */
        article,
        article address,
        table.meta,
        table.inventory {
            margin: 0 0 3em;
            overflow: hidden;
        }
        article h1 {
            clip: rect(0 0 0 0);
            position: absolute;
        }
        article address {
            float: left;
            font-size: 125%;
            font-weight: bold;
        }
        table.meta,
        table.balance {
            float: right;
            width: 36%;
        }
        table.meta:after,
        table.balance:after {
            clear: both;
            content: "";
            display: table;
        }
        
        /* table meta */
        table.meta th {
            width: 40%;
        }
        table.meta td {
            width: 60%;
        }
        
        /* table items */
        table.inventory {
            clear: both;
            width: 100%;
        }
        table.inventory th {
            font-weight: bold;
            text-align: center;
        }
        table.inventory td {
            text-align: center;
        }
        table.inventory td:nth-child(1) {
            width: 26%;
        }
        table.inventory td:nth-child(2) {
            width: 38%;
        }
        table.inventory td:nth-child(3),
        table.inventory td:nth-child(4),
        table.inventory td:nth-child(5) {
            width: 12%;
        }
        
        /* table balance */
        table.balance th,
        table.balance td {
            width: 50%;
            text-align: right;
        }
        
        /* aside */
        aside h1 {
            border: none;
            border-width: 0 0 1px;
            margin: 0 0 1em;
            border-color: #999;
            border-bottom-style: solid;
        }
        
        /* javascript */
        .add,
        .cut {
            border-width: 1px;
            display: block;
            font-size: 0.8rem;
            padding: 0.25em 0.5em;
            float: left;
            text-align: center;
            width: 0.6em;
            background: #9AF;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            border-radius: 0.5em;
            border-color: #0076A3;
            color: #FFF;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 0 -1px 2px rgba(0, 0, 0, 0.333);
            margin: -2.5em 0 0;
        }
        .add:hover {
            background: #00ADEE;
        }
        .cut {
            opacity: 0;
            position: absolute;
            top: 0;
            left: -1.5em;
            -webkit-transition: opacity 100ms ease-in;
        }
        tr:hover .cut {
            opacity: 1;
        }
        
        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }
            html {
                background: none;
                padding: 0;
            }
            body {
                box-shadow: none;
                margin: 0;
            }
            span:empty {
                display: none;
            }
            .add,
            .cut {
                display: none;
            }
        }
        
        @page {
            margin: 0;
        }
    </style>
</head>
<body>
<?php
include 'db_connection.php'; 

// Get the current month and year
$currentMonth = date("m");
$currentYear = date("Y");

// Construct the start and end dates of the current month
$startDate = "$currentYear-$currentMonth-01";
$endDate = date("Y-m-t", strtotime($startDate)); // Last day of the current month

$sql = "SELECT * FROM monthly_sales_report";

$stmt = $conn->prepare($sql);

// Check if the preparation was successful
if (!$stmt) {
    die("Error: " . $conn->error); // Handle the error
}

// Execute the prepared statement
$result = $stmt->execute();

if (!$result) {
    die("Error executing query: " . $stmt->error); // Handle the error
}

// Get the result set
$result = $stmt->get_result();

// Initialize totalSales to 0
$totalSales = 0;
?>


<!-- HTML code for the sales report -->
<header>
    <h1 style="color: black">Sales Report<br>
    <p>(<?php echo date("F Y"); ?>)</p></h1>
    <address>
        <p>ENCHANTED HOTEL,</p>
        <p>Antipolo, Quezon City, Philippines.</p>
        <p>(+63) 9949179123 </p>
    </address>
</header>

<article>
    <h1>Recipient</h1>
    <table class="inventory">
        <thead>
            <tr>
                    <th>Check-in ID</th>
                    <th>Room No</th>
                    <th>Name</th>
                    <th>Room Type</th>
                    <th>Check-in Date</th>
                    <th>Check-in Time</th>
                    <th>Check-out Date</th>
                    <th>Check-out Time</th>
                    <th>Days</th>
                    <th>Payment Method</th>
                    <th>Room Total Price</th>
                    <th>Orders Total Price</th>
                    <th>Total Amount</th>

            </tr>
        </thead>
        <tbody>
        <?php
            // Display payment records in the table
            while ($row = $result->fetch_assoc()) {
                // Calculate total amount including tax
              
                // Add paid amount to total sales
                $totalSales +=$row['overallamount'];

                echo "<tr>";
                echo "<td>" . $row["checkedid"] . "</td>";
                echo "<td>" . $row["roomnumber"] . "</td>";
                echo "<td>" . $row["guestname"] . "</td>";
                echo "<td>" . $row["roomtype"] . "</td>";
                echo "<td>" . $row["checkindate"] . "</td>";
                echo "<td>" . $row["checkintime"] . "</td>";
                echo "<td>" . $row["checkoutdate"] . "</td>";
                echo "<td>" . $row["checkouttime"] . "</td>";
                echo "<td>" . $row["days"] . "</td>";
                echo "<td>" . $row["payment_method"] . "</td>";
                echo "<td>₱ {$row['room_total_price']}</td>";
                echo "<td>₱ {$row['ordtotalamount']}</td>";
                echo "<td>₱ {$row['overallamount']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="12">Total Sales (<?php echo date("F Y"); ?>):</th>
                <th>₱ <?php echo $totalSales; ?></th>
            </tr>
        </tfoot>
    </table>
</article>

<aside>
    <h1>Contact us</h1>
    <div>
        <p>Email: info@enchanted.com</p>
        <p>Web: www.hotel.com</p>
        <p>Phone: +94 919578153</p>
    </div>
</aside>

</body>
</html>