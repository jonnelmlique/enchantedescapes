<?php
ob_start();
include('db_connection.php'); // Include the file where the database connection is established

// Initialize variables
$roomNo = $guestName = $checkInDate = $checkOutDate = $paymentMethod = $roomType = $days = $roomprice = $roomtotalprice = "";
$productName = $orderQuantity = $price = $totalAmount = $totalAmountPaid = 0;

// Check if the necessary $_GET variables are set
if(isset($_GET['pid'])) {
    // Assign the $_GET variable to a local variable
    $checkedid = $_GET['pid'];

    // Fetch data from the database
    $sql = "SELECT 
    c.checkedid,
    c.guestname,
    c.contactno,
    c.roomnumber,
    c.price, 
    c.room_total_price, 
    c.checkindate, 
    c.checkintime, 
    c.checkoutdate, 
    c.checkouttime, 
    c.days,
    c.payment_method,
    c.adult,
    c.roomtype,
    c.children,
    c.status,
    c.reservationfee,
    o.ProductName,
    o.OrderQuantity,
    o.Price,
    p.overallamount,
    p.ordtotalamount,
    p.paidamount,
    rp.transactionid,
    rp.emailaddress,
    rp.country,
    rp.address,
    rp.city,
    rp.zipcode,
    rp.firstname,
    rp.lastname,
    rp.prefix,
    rp.suffix
    FROM 
    checked c
    INNER JOIN 
    reservationprocess rp ON c.guestname = rp.firstname
    INNER JOIN
    orders o ON o.checkedid = c.CheckedID
    INNER JOIN
    payments p ON p.checkedids = c.checkedid 
    WHERE 
    c.status = 2";

    $re = mysqli_query($conn,$sql);

    // Check if the query executed successfully
    if($re === false) {
        echo "Error: " . mysqli_error($conn);
    } else {
        // Check if there are any rows returned
        if(mysqli_num_rows($re) > 0) {
            while($row = mysqli_fetch_array($re)) {
                // Assign retrieved data to variables
                $checkedid = $row['checkedid'];
                $roomNo = $row['roomnumber'];
                $guestName = $row['guestname'];
                $checkInDate = $row['checkindate'];
                $checkOutDate = $row['checkoutdate'];   
                $paymentMethod = $row['payment_method'];
                $roomType = $row['roomtype'];
                $days = $row['days'];
                $roomprice = $row['price'];
                $roomtotalprice = $row['room_total_price'];
                $productName = $row['ProductName'];
                $orderQuantity = $row['OrderQuantity'];
                $price = $row['Price'];
                $totalAmount = $row['ordtotalamount'];
                $totalAmountPaid = $row['paidamount'];
            }
        } else {
            echo "No rows found";
        }
    }
} else {
    echo "Missing required GET parameters";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px; /* Reduced width for a traditional receipt look */
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #DAA520;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px; /* Reduced padding for a compact layout */
            border-bottom: 1px solid #ccc;
            text-align: left;
            vertical-align: top; /* Align content at the top */
        }

        th {
            background-color: #DAA520;
            color: #000;
        }

        .receipt-details {
            margin-bottom: 20px; /* Reduced margin for a compact layout */
        }

        .receipt-details p {
            margin-bottom: 5px;
        }

        .total-amount {
            text-align: center;
            margin-top: 20px; /* Reduced margin-top */
            border-top: 2px solid #DAA520;
            padding-top: 10px;
        }

        .total-amount p {
            margin-bottom: 5px;
            font-size: 18px; /* Reduced font-size for a compact layout */
            font-weight: bold;
            color: #DAA520;
        }

        .highlight {
            font-weight: bold;
        }

        .footer {
            margin-top: 20px; /* Reduced margin-top */
            text-align: center;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Receipt</h1>
    <div class="receipt-details">
        <h2>Payment Details</h2>
        <table>
            <tr>
                <td><span class="highlight">Room No:</span></td>
                <td><?php echo $roomNo; ?></td>
            </tr>
            <tr>
                <td><span class="highlight">Guest Name:</span></td>
                <td><?php echo $guestName; ?></td>
            </tr>
            <tr>
                <td><span class="highlight">Check-in Date:</span></td>
                <td><?php echo $checkInDate; ?></td>
            </tr>
            <tr>
                <td><span class="highlight">Check-out Date:</span></td>
                <td><?php echo $checkOutDate; ?></td>
            </tr>
            <tr>
                <td><span class="highlight">Payment Method:</span></td>
                <td><?php echo $paymentMethod; ?></td>
            </tr>
        </table>
    </div>
    <div class="receipt-details">
        <h2>Room Details</h2>
        <table>
            <tr>
                <th>Room Type</th>
                <th>Days</th>
                <th>Room Price</th>
                <th>Total Room Price</th>
            </tr>
            <tr>
                <td><?php echo $roomType; ?></td>
                <td><?php echo $days; ?></td> 
                <td>₱<?php echo $roomprice; ?></td>
                <td>₱<?php echo $roomtotalprice; ?></td>
            </tr>
        </table>
    </div>
    <div class="receipt-details">
        <h2>Order Details</h2>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td><?php echo $productName; ?></td>
                <td><?php echo $orderQuantity; ?></td>
                <td>₱<?php echo $price; ?></td>
                <td>₱<?php echo $totalAmount; ?></td>
            </tr>
        </table>
    </div>
    <div class="total-amount">
        <h2>Total Amount</h2>
        <p>₱<?php echo $totalAmountPaid; ?></p>
    </div>
    <div class="footer">
        Thank you for choosing our service. Have a pleasant day!
    </div>
</div>
</body>
</html>


