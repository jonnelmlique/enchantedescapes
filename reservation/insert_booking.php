<?php

include './src/config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './src/contact/Exception.php';
require './src/contact/PHPMailer.php';
require './src/contact/SMTP.php';

if (
    isset($_POST['transactionID']) && isset($_POST['roomids']) && isset($_POST['guestuserid']) && isset($_POST['roomfloor']) && isset($_POST['roomnumber']) &&
    isset($_POST['adults']) && isset($_POST['children']) && isset($_POST['checkindates']) &&
    isset($_POST['checkintimes']) && isset($_POST['checkoutdates']) && isset($_POST['checkouttimes']) &&
    isset($_POST['prices']) && isset($_POST['reservationprices']) && isset($_POST['totalreservationprice']) &&
    isset($_POST['paymentMethod']) && isset($_POST['totalafterpromo'])
) {

    $transactionID = mysqli_real_escape_string($conn, $_POST['transactionID']);
    $roomids = mysqli_real_escape_string($conn, $_POST['roomids']);
    $guestuserid = mysqli_real_escape_string($conn, $_POST['guestuserid']);
    $roomfloor = mysqli_real_escape_string($conn, $_POST['roomfloor']);
    $roomnumber = mysqli_real_escape_string($conn, $_POST['roomnumber']);


    $adults = mysqli_real_escape_string($conn, $_POST['adults']);
    $children = mysqli_real_escape_string($conn, $_POST['children']);
    $checkindates = mysqli_real_escape_string($conn, $_POST['checkindates']);
    $checkintimes = mysqli_real_escape_string($conn, $_POST['checkintimes']);
    $checkoutdates = mysqli_real_escape_string($conn, $_POST['checkoutdates']);
    $checkouttimes = mysqli_real_escape_string($conn, $_POST['checkouttimes']);
    $prices = mysqli_real_escape_string($conn, $_POST['prices']);
    $reservationprices = mysqli_real_escape_string($conn, $_POST['reservationprices']);
    $totalreservationprice = mysqli_real_escape_string($conn, $_POST['totalreservationprice']);
    $paymentMethod = mysqli_real_escape_string($conn, $_POST['paymentMethod']);
    $totalafterpromo = mysqli_real_escape_string($conn, $_POST['totalafterpromo']);

    $gcashNumber = '';
    $referenceNo = '';

    if ($paymentMethod === "gcashqr") {
        if (isset($_POST['gcashNumber'])) {
            $gcashNumber = mysqli_real_escape_string($conn, $_POST['gcashNumber']);
        }
        if (isset($_POST['referenceNo'])) {
            $referenceNo = mysqli_real_escape_string($conn, $_POST['referenceNo']);
        }

    }



    $sql_guest = "SELECT prefix, firstname, lastname, suffix, mobilenumber, emailaddress, country, address, city, zipcode FROM guestdetails WHERE guestuserid = '$guestuserid'";
    $result_guest = mysqli_query($conn, $sql_guest);
    $row_guest = mysqli_fetch_assoc($result_guest);
    $prefix = $row_guest['prefix'];
    $firstname = $row_guest['firstname'];
    $lastname = $row_guest['lastname'];
    $suffix = $row_guest['suffix'];
    $mobilenumber = $row_guest['mobilenumber'];
    $emailaddress = $row_guest['emailaddress'];
    $country = $row_guest['country'];
    $address = $row_guest['address'];
    $city = $row_guest['city'];
    $zipcode = $row_guest['zipcode'];

    $roomidsArray = explode(',', $roomids);
    $roomfloorArray = explode(',', $roomfloor);
    $roomnumberArray = explode(',', $roomnumber);


    $adultsArray = explode(',', $adults);
    $childrenArray = explode(',', $children);
    $checkindatesArray = explode(',', $checkindates);
    $checkintimesArray = explode(',', $checkintimes);
    $checkoutdatesArray = explode(',', $checkoutdates);
    $checkouttimesArray = explode(',', $checkouttimes);
    $pricesArray = explode(',', $prices);
    $reservationpricesArray = explode(',', $reservationprices);

    $sql = "INSERT INTO reservationprocess (transactionid, roomid, guestuserid, roomfloor, roomnumber, adults, children, checkindate, checkintime, checkoutdate, checkouttime, price, reservationprice, totalreservationprice, prefix, firstname, lastname, suffix, mobilenumber, emailaddress, country, address, city, zipcode, status, paymentmethod, gcashNumber, referenceNo, totalafterpromo) VALUES ";

    for ($i = 0; $i < count($roomidsArray); $i++) {
        $roomid = isset($roomidsArray[$i]) ? mysqli_real_escape_string($conn, $roomidsArray[$i]) : '';
        $roomfloor = isset($roomfloorArray[$i]) ? mysqli_real_escape_string($conn, $roomfloorArray[$i]) : '';
        $roomnumber = isset($roomnumberArray[$i]) ? mysqli_real_escape_string($conn, $roomnumberArray[$i]) : '';

        $adult = isset($adultsArray[$i]) ? mysqli_real_escape_string($conn, $adultsArray[$i]) : '';
        $child = isset($childrenArray[$i]) ? mysqli_real_escape_string($conn, $childrenArray[$i]) : '';
        $checkindate = isset($checkindatesArray[$i]) ? mysqli_real_escape_string($conn, $checkindatesArray[$i]) : '';
        $checkintime = isset($checkintimesArray[$i]) ? mysqli_real_escape_string($conn, $checkintimesArray[$i]) : '';
        $checkoutdate = isset($checkoutdatesArray[$i]) ? mysqli_real_escape_string($conn, $checkoutdatesArray[$i]) : '';
        $checkouttime = isset($checkouttimesArray[$i]) ? mysqli_real_escape_string($conn, $checkouttimesArray[$i]) : '';
        $price = isset($pricesArray[$i]) ? mysqli_real_escape_string($conn, $pricesArray[$i]) : '';
        $reservationprice = isset($reservationpricesArray[$i]) ? mysqli_real_escape_string($conn, $reservationpricesArray[$i]) : '';


        $sql .= "('$transactionID', '$roomid', '$guestuserid', '$roomfloor', '$roomnumber', '$adult', '$child', '$checkindate', '$checkintime', '$checkoutdate', '$checkouttime', '$price', '$reservationprice', '$totalreservationprice', '$prefix', '$firstname', '$lastname', '$suffix', '$mobilenumber', '$emailaddress', '$country', '$address', '$city', '$zipcode', 'Pending', '$paymentMethod',  '$gcashNumber', '$referenceNo', '$totalafterpromo'),";
    }

    $sql = rtrim($sql, ',');

    if (mysqli_query($conn, $sql)) {

        for ($i = 0; $i < count($roomnumberArray); $i++) {
            $roomnumber = mysqli_real_escape_string($conn, $roomnumberArray[$i]);

            $sql_update_room_status = "UPDATE roominfo SET status = 'Unavailable' WHERE roomnumber = '$roomnumber'";
            mysqli_query($conn, $sql_update_room_status);
        }

        $sql_delete_guest = "DELETE FROM guestdetails WHERE guestuserid = '$guestuserid'";
        $sql_delete_bookingcart = "DELETE FROM reservationsummary WHERE guestuserid = '$guestuserid'";

        mysqli_query($conn, $sql_delete_guest);
        mysqli_query($conn, $sql_delete_bookingcart);

        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'enchantedescapeshotel@gmail.com';
            $mail->Password = 'htdsewgfjopecqxp';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('enchantedescapeshotel@gmail.com', 'Enchanted Escapes');
            $mail->addAddress($emailaddress);
            $mail->isHTML(true);

            $sql_status = "SELECT status FROM reservationprocess WHERE transactionid = '$transactionID'";
            $result_status = mysqli_query($conn, $sql_status);
            $row_status = mysqli_fetch_assoc($result_status);
            $status = $row_status['status'];
            $formattedTotal = '₱' . number_format($totalafterpromo, 2);

            $mail->Subject = 'Reservation Confirmation';
            $mail->Body = '
           
                <div class="container">
                    <p>Hello ' . $firstname . ' ' . $lastname . ',</p>
                    <p>Your booking has been confirmed. Thank you for choosing our service.</p>
                    <p>Here are your reservation details:</p>
                    <ul>
                        <li>Room Floor: ' . $roomfloor . '</li>
                        <li>Room Number: ' . $roomnumber . '</li>
                        <li>Adults: ' . $adults . '</li>
                        <li>Children: ' . $children . '</li>
                        <li>Check-in Date: ' . $checkindates . '</li>
                        <li>Check-in Time: ' . $checkintimes . '</li>
                        <li>Checkout Date: ' . $checkoutdates . '</li>
                        <li>Checkout Time: ' . $checkouttimes . '</li>
                        <li>Total Reservation Price: ' . $formattedTotal . '</li><br>
                        <li>Name: ' . $prefix . ' ' . $firstname . ' ' . $lastname . ' ' . $suffix . '</li>
                        <li>Mobile Number: ' . $mobilenumber . '</li>
                        <li>Email Address: ' . $emailaddress . '</li>
                        <li>Country: ' . $country . '</li>
                        <li>Address: ' . $address . '</li>
                        <li>City: ' . $city . '</li>
                        <li>Zipcode: ' . $zipcode . '</li><br>
                        
                        <li>Transaction ID: <a href="http://localhost/eeh-reservation/reservationstatusdetails.php?transactionid=' . $transactionID . '">' . $transactionID . '</a></li>
                        <li>Payment Method: ' . $paymentMethod . '</li>
                        <li>Status: ' . $status . '</li>';
            if ($paymentMethod === "gcashqr") {
                $mail->Body .= '<li>GCash Number: ' . $gcashNumber . '</li>';
                $mail->Body .= '<li>Reference No: ' . $referenceNo . '</li>';
            }
            $termsAndConditions = '
<div class="container">
    <div>
        <h4 class="fw-bold text-uppercase" data-toggle="collapse" href="#termsCollapse"
            role="button" aria-expanded="false" aria-controls="termsCollapse">ENCHANTED ESCAPES
            HOTEL | TERMS AND CONDITIONS</h4>
        <div class="container">
            <p><strong>Condition of Stay</strong></p>
            <p>The following terms and conditions will apply to all bookings at the Enchanted
                Escapes Hotel. Guests
                are asked to read these terms and conditions carefully before making a booking,
                paying particular
                attention to the deposit and cancellation policies, as well as any other terms
                and conditions marked
                in bold. In these terms and conditions: "Agreement" means the booking
                confirmation read together
                with these Terms & Conditions. "Guest" means the person who will be accommodated
                at the Hotel.
                "Hotel" means the Enchanted Escapes Hotel. "Terms & Conditions" means the terms
                and conditions of
                stay. These terms and conditions apply to all bookings made at the Enchanted
                Escapes Hotel.</p>
        </div>
        <div>
            <h4 class="fw-bold text-uppercase" data-toggle="collapse" href="#bookingCollapse"
                role="button" aria-expanded="false" aria-controls="bookingCollapse">Booking
                Procedure </h4>
            <div class="container collapse" id="bookingCollapse">
                <ol>
                    <li>Upon securing the booking, guests will receive a written confirmation
                        through one of the following
                        methods:
                        <ol type="a">
                            <li>Payment of a deposit</li>
                            <li>Presentation of a billing voucher (for bookings made through a
                                travel agent or tour operator)</li>
                        </ol>
                    </li>
                    <li>When making abooking, guests are required to provide the following
                        information to the Hotel:
                        <ol type="a">
                            <li>Full name and contact details</li>
                            <li>Requested dates of stay and estimated time of arrival</li>
                            <li>Accommodation fees based on the Hotel\'s published rates</li>
                            <li>Any additional information deemed necessary by the Hotel</li>
                        </ol>
                    </li>
                    <li>If a guest wishes to extend their stay, a new accommodation agreement
                        will be established upon the
                        submission of the request.</li>
                    <li>The accommodation agreement is considered valid once the Hotel accepts
                        the booking unless the Hotel can
                        prove otherwise.</li>
                    <li>Once the accommodation agreement is established, the guest must make a
                        deposit payment by the specified
                        deadline set by the Hotel. This deposit will be applied towards the
                        total charges payable by the
                        guest.</li>
                    <li>Failure to pay the required deposit by the specified deadline, unless
                        the Hotel has provided an alternative
                        notification, will result in the termination of the accommodation
                        agreement.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="collapse show" id="termsCollapse">
        <p><strong>Charges, Deposit, and Payment</strong></p>
        <ol>
            <li>Prices quoted by Enchanted Escapes Hotel include VAT. Price lists
                for additional items, such as room
                service and restaurant meals, can be obtained upon request or are
                displayed at relevant locations within
                the hotel.</li>
            <li>All charges incurred during a guest\'s stay can be settled
                immediately or charged to the guest\'s room
                account. If charges are debited to the room account, the full
                balance must be settled upon check-out when
                presenting the invoice.</li>
            <li>Bookings must be secured using one of the following methods:
                <ol type="a">
                    <li>Payment of a percentage of the total accommodation costs
                    </li>
                </ol>
            </li>
            <li>Payment can be made through the following methods:
                <ol type="a">
                    <li>Electronic funds transfer into the bank account specified on
                        the proforma invoice</li>
                </ol>
            </li>
            <li>Failure to pay the required deposit or present a billing voucher by
                the due date may result in the hotel
                treating the booking as canceled without further notice.</li>
            <li>The hotel reserves the right to accept payment only in the
                currencies it has specified to guests. Prior
                notice may be given if the hotel does not accept certain currencies.
            </li>
        </ol>
    </div>
</div>
<div class="container">
    <div class="collapse show" id="termsCollapse">
        <p><strong>Cancellations and Non-Arrivals</strong></p>
        <p>Cancellations are required to be submitted in writing. Guests are
            responsible for the payment of a cancellation fee, which will be
            determined by Enchanted Escapes Hotel at the time of booking
            confirmation. Please note that changes to rooms, including switching
            rooms, are not permitted. Should you have any inquiries or requests
            related to cancellations and refunds, we kindly ask that you reach out
            to us through the provided contact information. </p>
    </div>
</div>
<div class="container">
    <div class="collapse show" id="termsCollapse">
        <p><strong>Changes to Bookings </strong></p>
        <ol>
            <li>Changes to any bookings must be made in writing. </li>
            <li>No amendments are guaranteed until written confirmation is provided by
                Enchanted Escapes Hotel. </li>
            <li>Rate variations may apply, depending on the nature of the change
                requested</li>

        </ol>
    </div>
</div>
';

            $mail->Body .= $termsAndConditions;


            $mail->send();
        } catch (Exception $e) {
            echo "Error sending email: " . $e->getMessage();
        }


        echo "Booking information inserted successfully.";

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {

    echo "Error: Some required fields are not set. <br>";
    echo "Missing fields:<br>";
    $required_fields = array(
        'transactionID',
        'roomids',
        'guestuserid',
        'roomfloor',
        'roomnumber',
        'adults',
        'children',
        'checkindates',
        'checkintimes',
        'checkoutdates',
        'checkouttimes',
        'prices',
        'reservationprices',
        'totalreservationprice',
        'paymentMethod',
        'gcashNumber',
        'referenceNo',
        'totalafterpromo'
    );
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            echo "$field is missing <br>";
        }
    }
}


?>