<?php
session_start();

include './src/config/config.php';
if (!isset($_SESSION['data_inserted'])) {
    $sql = "INSERT INTO guestusers () VALUES ()";
    if ($conn->query($sql) === TRUE) {
        $sql_select = "SELECT guestuserid FROM guestusers ORDER BY timestamp_column DESC LIMIT 1";
        $result = $conn->query($sql_select);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $guestuserid = $row['guestuserid'];
            $_SESSION['guestuserid'] = $guestuserid;
            $_SESSION['data_inserted'] = true;
        } else {
        }
    } else {
    }
}

?>
<?php

if (isset($_SESSION['guestuserid'])) {
    $guestuserid = $_SESSION['guestuserid'];

    $sql_check_cart = "SELECT * FROM reservationsummary WHERE guestuserid = '$guestuserid'";
    $result_check_cart = $conn->query($sql_check_cart);

    if ($result_check_cart->num_rows == 0) {
        header("Location: book-now.php");
        exit();
    }
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Book Review</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="styles/booking.css" rel="stylesheet" />
    <link href="styles/bootstrap.min.css" rel="stylesheet" />
    <link href="styles/dashboard.css" rel="stylesheet" />
    <link href="styles/guest-details.css" rel="stylesheet" />
    <link href="styles/scrollbar.css" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<div><?php include ("componentshome/navbar.php"); ?>

    <div class="bg-white">
        <br /><br />
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h3 class="fw-bold">Almost Done! Review Your Stay</h3>
                    <img src="assets/step-3.png" width="100%" />
                    <br /><br />

                    <div class="border border-primary w-100 p-2 px-3" style="border-radius: 12px">
                        <br />
                        <?php
                        if (isset($_SESSION['guestuserid'])) {
                            $guestuserid = $_SESSION['guestuserid'];

                            $sql = "SELECT bc.*, r.roomtype 
                FROM reservationsummary bc 
                INNER JOIN room r ON bc.roomid = r.roomid 
                WHERE bc.guestuserid = '$guestuserid'";
                            $result = $conn->query($sql);
                            $totalReservationPrice = 0;

                            echo "<h4 class='fw-bold text-uppercase'>Room Details</h4><br/>";

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $checkinDate = $row['checkindate'];
                                    $checkinTime = date("h:i A", strtotime($row['checkintime']));
                                    $checkoutDate = $row['checkoutdate'];
                                    $checkoutTime = date("h:i A", strtotime($row['checkouttime']));
                                    $roomtype = $row['roomtype'];
                                    $roomId = $row['roomid'];
                                    $reservationPrice = $row['reservationprice'];
                                    $totalReservationPrice += $reservationPrice;

                                    echo "<p><strong>Room Type:</strong> $roomtype</p>";
                                    echo "<p><strong>Check-in:</strong> $checkinDate $checkinTime</p>";
                                    echo "<p><strong>Check-out:</strong> $checkoutDate $checkoutTime</p>";
                                    echo "<hr>";
                                }

                                echo "<p><strong>Total Reservation Price:</strong> ₱" . number_format($totalReservationPrice, 2) . "</p>";
                            } else {
                                echo "<p>No bookings found.</p>";
                            }
                        } else {
                            echo "<p>Guest user ID not found in session.</p>";
                        }
                        ?>

                        <br />
                        <div style="border-width: 1px; border-color: black; border-style: dashed"></div>

                        <br /><br />
                        <?php
                        if (isset($_SESSION['guestuserid'])) {
                            $guestuserid = $_SESSION['guestuserid'];

                            $sql = "SELECT * FROM guestdetails WHERE guestuserid = '$guestuserid' ORDER BY guestid DESC LIMIT 1";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<h4 class='fw-bold text-uppercase'>Guest Information</h4><br/>";
                                echo "<table class='table'>";
                                echo "<thead><tr><th></th><th></th></tr></thead>";
                                echo "<tbody>";
                                $row = $result->fetch_assoc(); // Fetch only one row
                                $namePrefix = $row['prefix'] . ' ' . $row['firstname'] . ' ' . $row['lastname'] . ' ' . $row['suffix'];
                                echo "<tr><td>Name:</td><td>" . $namePrefix . "</td></tr>";
                                echo "<tr><td>Mobile Number</td><td>" . $row['mobilenumber'] . "</td></tr>";
                                echo "<tr><td>Email Address</td><td>" . $row['emailaddress'] . "</td></tr>";
                                echo "<tr><td>Country</td><td>" . $row['country'] . "</td></tr>";
                                echo "<tr><td>Address</td><td>" . $row['address'] . "</td></tr>";
                                echo "<tr><td>City</td><td>" . $row['city'] . "</td></tr>";
                                echo "<tr><td>Zip Code</td><td>" . $row['zipcode'] . "</td></tr>";
                                echo "</tbody>";
                                echo "</table>";
                            } else {
                                echo "<p>No guest information found.</p>";
                            }
                        } else {
                            echo "<p>Guest user ID not found in session.</p>";
                        }


                        ?>

                        <br />
                        <div style="border-width: 1px; border-color: black; border-style: dashed"></div>

                        <br /><br />
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
                                            <li>When making a booking, guests are required to provide the following
                                                information to the Hotel:
                                                <ol type="a">
                                                    <li>Full name and contact details</li>
                                                    <li>Requested dates of stay and estimated time of arrival</li>
                                                    <li>Accommodation fees based on the Hotel's published rates</li>
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
                                        <div class="collapse show" id="termsCollapse">
                                            <p><strong>Charges, Deposit, and Payment</strong></p>
                                            <ol>
                                                <li>Prices quoted by Enchanted Escapes Hotel include VAT. Price lists
                                                    for additional items, such as room
                                                    service and restaurant meals, can be obtained upon request or are
                                                    displayed at relevant locations within
                                                    the hotel.</li>
                                                <li>All charges incurred during a guest's stay can be settled
                                                    immediately or charged to the guest's room
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

                                        <p><strong>Cancellations and Non-Arrivals</strong></p>
                                        <p>Cancellations are required to be submitted in writing. Guests are
                                            responsible for the payment of a cancellation fee, which will be
                                            determined by Enchanted Escapes Hotel at the time of booking
                                            confirmation. Please note that changes to rooms, including switching
                                            rooms, are not permitted. Should you have any inquiries or requests
                                            related to cancellations and refunds, we kindly ask that you reach out
                                            to us through the provided contact information. </p>
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
                            </div>
                        </div>
                    </div>
                    <br />



                    <div class="p-2 w-100 border border-primary" style="border-radius: 8px">
                        <?php
                        if (isset($_SESSION['guestuserid'])) {
                            $guestuserid = $_SESSION['guestuserid'];

                            $sql = "SELECT bc.*, r.roomtype 
                        FROM reservationsummary bc 
                        INNER JOIN room r ON bc.roomid = r.roomid 
                        WHERE bc.guestuserid = '$guestuserid'";
                            $result = $conn->query($sql);
                            $totalReservationPrice = 0;
                            $totalReservationPriceWithoutPromo = 0;
                            $promoApplied = false;

                            echo "<h4 class='fw-bold text-uppercase mt-2' align='center'>Your Booking Summary</h4>";

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $checkinDate = $row['checkindate'];
                                    $checkinTime = date("h:i A", strtotime($row['checkintime']));
                                    $checkinDay = date("l", strtotime($checkinDate));
                                    $checkoutDate = $row['checkoutdate'];
                                    $checkoutTime = date("h:i A", strtotime($row['checkouttime']));
                                    $checkoutDay = date("l", strtotime($checkoutDate));
                                    $roomtype = $row['roomtype'];
                                    $roomfloor = $row['roomfloor'];
                                    $roomnumber = $row['roomnumber'];
                                    $reservationPrice = $row['reservationprice'];
                                    $totalReservationPrice += $reservationPrice;
                                    $totalReservationPriceWithoutPromo += $reservationPrice;

                                    echo "<div class='row mx-2 pt-2'>
                                <div class='col-6' align='center'>
                                    <b class='text-uppercase'>Check-in</b><br />
                                    <small>$checkinDay, $checkinDate $checkinTime</small>
                                </div>
                                <div class='col-6' align='center'>
                                    <b class='text-uppercase'>Check-out</b><br />
                                    <small>$checkoutDay, $checkoutDate $checkoutTime</small>
                                </div>
                            </div>
                            <div class='row pt-4' align='center'>
                            <div class='col-6'>
                            <label>Room Floor:</label>
                                <small class='text-primary'>$roomfloor</small>
                            </div>
                            <div class='col-6'>
                            <label>Room Number:</label>
                            <small class='text-primary'>$roomnumber</small>
                            </div>
                        </div>  
                            <div class='row pt-4' align='center'>
                                <div class='col-6'>
                                    <small class='text-primary'>$roomtype</small>
                                </div>
                                <div class='col-6'>
                                    <small>₱" . number_format($reservationPrice, 2) . "</small>
                                </div>
                            </div>
                            <div align='center'>
                                <div class='row w-75 pt-4'>
                                </div>
                                <hr class='mt-2 mx-3' />";
                                }
                                if (isset($_POST['add-promo'])) {
                                    $promoName = $_POST['add-promo'];
                                    $promoQuery = "SELECT * FROM eespromo WHERE promoname = '$promoName'";
                                    $promoResult = $conn->query($promoQuery);

                                    if ($promoResult->num_rows > 0) {
                                        $promoRow = $promoResult->fetch_assoc();
                                        $promoPercentage = $promoRow['percentage'];
                                        $discountAmount = $totalReservationPrice * ($promoPercentage / 100);
                                        $totalReservationPrice -= $discountAmount;
                                        $promoId = $promoRow['promoid'];

                                        if ($promoRow['available'] > 0) {

                                            $updatePromoQuery = "UPDATE eespromo SET available = available - 1 WHERE promoid = $promoId";
                                            mysqli_query($conn, $updatePromoQuery);
                                            ;


                                            $promoApplied = true;


                                            echo "<div class='row mx-2 pt-2'>
                        <div class='col-12' align='center'>
                            <b class='text-uppercase'>Promotion Applied:</b><br />
                            <small>$promoName ($promoPercentage% Discount)</small>
                        </div>
                    </div>";
                                        } else {
                                            echo "<div class='row mx-2 pt-2'>
                            <div class='col-12' align='center'>
                                <b class='text-uppercase text-danger'>Promotion Not Available!</b><br />
                                <small>The entered promotion code is currently not available or already fully used.</small>
                                </div>
                        </div>";
                                        }
                                    } else {
                                        echo "<div class='row mx-2 pt-2'>
                        <div class='col-12' align='center'>
                            <b class='text-uppercase text-danger'>Promotion Not Found!</b><br />
                            <small>The entered promotion code does not exist.</small>
                        </div>
                    </div>";
                                    }
                                }
                                echo "<div class='row mx-2 pt-2'>
                                <div class='col-6'><b>Total</b></div>
                                <div id='total-after-promo' class='col-6' align='right'>₱" . number_format($totalReservationPriceWithoutPromo, 2) . "</div>
                              </div>";

                                if ($promoApplied) {
                                    echo "<div class='row mx-2 pt-2'>
                                    <div class='col-6'><b>Total with Promo</b></div>
                                    <div id='total-after-promo' class='col-6' align='right'>₱" . number_format($totalReservationPrice, 2) . "</div>
                                  </div>";

                                }
                            } else {
                                echo "<div align='center'>No bookings found.</div>";
                            }
                        } else {
                            echo "Guest user ID not found in session.";
                        }
                        ?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <p class="mt-2">Add Promo:</p>
                        </div>
                        <div class="col-12">
                            <form method="POST" action="">
                                <input type="text" class="form-control" name="add-promo" style="border-radius: 8px"
                                    placeholder="Promo name" required />
                                <button type="submit" class="btn btn-primary mt-2"
                                    style="width: 840px; transition: background-color 0.3s;">Apply
                                    Promo</button>
                            </form>
                        </div>
                    </div>

                </div>
                <br />

                <select class="form-control" id="paymentMethod" name="paymentMethod">
                    <option value="PayPal">PayPal</option>
                    <option value="gcashqr">GCash QR</option>
                </select>

                <div class="btnpaypal" id="paypal-button-container" style="max-width: 50%; margin: 20px auto 0 220px;">
                </div>

                <br />
                <button id="proceedButton" class="btn btn-primary mt-2"
                    style="border-radius: 8px; width: 860px; transition: background-color 0.3s;">Continue</button>

            </div>

        </div>

        <div class=" col-4">
        </div>
    </div>
</div>
</div>
</div>
<br /><br />
</div>
<div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog modal-xl"> -->
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content" style="background-color: #FAEBD7">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">GCASH QR</h5>
            </div>
            <div class="modal-body">
                <div class="roomdetails" id="roomDetails">
                    <img src="./assets/myQRgcash.png" width="200px" height="300px" style="margin-left: 125px;">
                </div>
                <form class="needs-validation">
                    <div class="row">
                        <div class="col-4" align="right">
                            <p class="mt-2">Gcash Number:</p>
                        </div>
                        <div class="col-8">
                            <input type="text" Id="add-gcashnum" class="form-control" name="add-gcashnum"
                                style="border-radius: 8px" placeholder="Gcahs Number"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)" maxlength="11"
                                required />

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-4" align="right">
                            <p class="mt-2">Reference No:</p>
                        </div>
                        <div class="col-8"><input type="text" class="form-control" name="add-referenceno"
                                style="border-radius: 8px" placeholder="Reference No"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)" maxlength="13"
                                required /></div>
                    </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="gcash-proceed">Continue</button>
            </div>
            </form>

        </div>
    </div>
</div>
</div>

<script
    src="https://www.paypal.com/sdk/js?client-id=AS4sEArJLWv67KwtFroZxWfiRZvI_X2Tuc899WJvoHsL96xjHUFdw5m-TGP02kafr5y37nXZGVQfbNGI&currency=PHP&disable-funding=card"
    data-sdk-integration-source="button-factory"></script>

<script src="scripts/jquery.min.js"></script>
<script src="scripts/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include ("components/footer.php"); ?>


<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("proceedButton").addEventListener("click", function() {
        console.log("Clicked Proceed to Checkout button");

        var paymentMethod = document.getElementById("paymentMethod").value;

        if (paymentMethod === "PayPal") {
            // PayPal payment method
            var container = document.getElementById("paypal-button-container");
            container.innerHTML = "";

            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                currency_code: 'PHP',
                                value: '<?php echo $totalReservationPrice; ?>'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        var transactionID = details.id;

                        console.log("Transaction ID:", transactionID);

                        var xhrBookingCart = new XMLHttpRequest();
                        xhrBookingCart.open("GET", "get_roomid.php", true);
                        xhrBookingCart.onreadystatechange = function() {
                            if (xhrBookingCart.readyState === 4 &&
                                xhrBookingCart.status === 200) {
                                var bookingCartData = JSON.parse(
                                    xhrBookingCart
                                    .responseText);
                                var roomids = [];
                                var roomfloor = [];
                                var roomnumber = [];
                                var adults = [];
                                var children = [];
                                var checkindates = [];
                                var checkintimes = [];
                                var checkoutdates = [];
                                var checkouttimes = [];
                                var prices = [];
                                var reservationprices = [];

                                for (var i = 0; i < bookingCartData
                                    .length; i++) {
                                    roomids.push(bookingCartData[i].roomid);
                                    roomfloor.push(bookingCartData[i]
                                        .roomfloor);
                                    roomnumber.push(bookingCartData[i]
                                        .roomnumber);
                                    adults.push(bookingCartData[i].adults);
                                    children.push(bookingCartData[i]
                                        .children);
                                    checkindates.push(bookingCartData[i]
                                        .checkindate);
                                    checkintimes.push(bookingCartData[i]
                                        .checkintime);
                                    checkoutdates.push(bookingCartData[i]
                                        .checkoutdate);
                                    checkouttimes.push(bookingCartData[i]
                                        .checkouttime);
                                    prices.push(bookingCartData[i].price);
                                    reservationprices.push(bookingCartData[
                                            i]
                                        .reservationprice);
                                }

                                var guestuserid =
                                    '<?php echo $_SESSION['guestuserid']; ?>';

                                var xhrBooking = new XMLHttpRequest();
                                xhrBooking.open("POST",
                                    "insert_booking.php",
                                    true);
                                xhrBooking.setRequestHeader("Content-Type",
                                    "application/x-www-form-urlencoded");
                                xhrBooking.onreadystatechange = function() {
                                    if (xhrBooking.readyState === 4 &&
                                        xhrBooking.status === 200) {
                                        console.log(xhrBooking
                                            .responseText);
                                    }
                                };
                                var bookingData =
                                    "transactionID=" + transactionID +
                                    "&roomids=" + roomids.join(',') +
                                    "&roomfloor=" + roomfloor.join(',') +
                                    "&roomnumber=" + roomnumber.join(',') +
                                    "&adults=" + adults.join(',') +
                                    "&children=" + children.join(',') +
                                    "&checkindates=" + checkindates.join(
                                        ',') +
                                    "&checkintimes=" + checkintimes.join(
                                        ',') +
                                    "&checkoutdates=" + checkoutdates.join(
                                        ',') +
                                    "&checkouttimes=" + checkouttimes.join(
                                        ',') +
                                    "&prices=" + prices.join(',') +
                                    "&reservationprices=" +
                                    reservationprices
                                    .join(',') +
                                    "&totalreservationprice=" +
                                    '<?php echo $totalReservationPriceWithoutPromo; ?>' +
                                    "&paymentMethod=" + paymentMethod +
                                    "&guestuserid=" + guestuserid +
                                    "&totalafterpromo=" +
                                    '<?php echo $totalReservationPrice; ?>';
                                console.log("Booking Data:", bookingData);
                                xhrBooking.send(bookingData);

                            }
                        };
                        xhrBookingCart.send();
                        window.location.href =
                            "book-confirm.php?transactionID=" +
                            transactionID;

                    });
                }
            }).render('#paypal-button-container');
        } else if (paymentMethod === "gcashqr") {
            // GCash QR payment method
            $('#reserveModal').modal('show');

            document.getElementById("gcash-proceed").addEventListener("click", function() {
                var gcashNumberInputs = document.querySelectorAll(
                    "input[name='add-gcashnum']");
                var referenceNoInputs = document.querySelectorAll(
                    "input[name='add-referenceno']");

                var gcashNumber = [];
                var referenceNo = [];

                gcashNumberInputs.forEach(function(input) {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        return;
                    }
                    gcashNumber.push(input.value);
                });

                referenceNoInputs.forEach(function(input) {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        return;
                    }
                    referenceNo.push(input.value);
                });

                if (gcashNumber.length === 0 || referenceNo.length === 0) {
                    return;
                }

                console.log("Reference Number:", referenceNo);

                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var yyyy = today.getFullYear();
                var hours = String(today.getHours()).padStart(2, '0');
                var minutes = String(today.getMinutes()).padStart(2, '0');
                var seconds = String(today.getSeconds()).padStart(2, '0');
                var randomSuffix = Math.floor(Math.random() * 10000);
                var transactionID = randomSuffix + mm + seconds + dd + hours + minutes +
                    yyyy;

                var xhrBookingCart = new XMLHttpRequest();
                xhrBookingCart.open("GET", "get_roomid.php", true);
                xhrBookingCart.onreadystatechange = function() {
                    if (xhrBookingCart.readyState === 4 && xhrBookingCart.status ===
                        200) {
                        var bookingCartData = JSON.parse(xhrBookingCart.responseText);
                        var roomids = [];
                        var roomfloor = [];
                        var roomnumber = [];
                        var adults = [];
                        var children = [];
                        var checkindates = [];
                        var checkintimes = [];
                        var checkoutdates = [];
                        var checkouttimes = [];
                        var prices = [];
                        var reservationprices = [];

                        for (var i = 0; i < bookingCartData.length; i++) {
                            roomids.push(bookingCartData[i].roomid);
                            roomfloor.push(bookingCartData[i].roomfloor);
                            roomnumber.push(bookingCartData[i].roomnumber);
                            adults.push(bookingCartData[i].adults);
                            children.push(bookingCartData[i].children);
                            checkindates.push(bookingCartData[i].checkindate);
                            checkintimes.push(bookingCartData[i].checkintime);
                            checkoutdates.push(bookingCartData[i].checkoutdate);
                            checkouttimes.push(bookingCartData[i].checkouttime);
                            prices.push(bookingCartData[i].price);
                            reservationprices.push(bookingCartData[i].reservationprice);
                        }

                        var guestuserid = '<?php echo $_SESSION['guestuserid']; ?>';

                        var xhrBooking = new XMLHttpRequest();
                        xhrBooking.open("POST", "insert_booking.php", true);
                        xhrBooking.setRequestHeader("Content-Type",
                            "application/x-www-form-urlencoded");
                        xhrBooking.onreadystatechange = function() {
                            if (xhrBooking.readyState === 4 && xhrBooking.status ===
                                200) {
                                console.log(xhrBooking.responseText);
                            }
                        };
                        var bookingData =
                            "transactionID=" + transactionID +
                            "&roomids=" + roomids.join(',') +
                            "&roomfloor=" + roomfloor.join(',') +
                            "&roomnumber=" + roomnumber.join(',') +
                            "&adults=" + adults.join(',') +
                            "&children=" + children.join(',') +
                            "&checkindates=" + checkindates.join(',') +
                            "&checkintimes=" + checkintimes.join(',') +
                            "&checkoutdates=" + checkoutdates.join(',') +
                            "&checkouttimes=" + checkouttimes.join(',') +
                            "&prices=" + prices.join(',') +
                            "&reservationprices=" + reservationprices.join(',') +
                            "&totalreservationprice=" +
                            '<?php echo $totalReservationPriceWithoutPromo; ?>' +
                            "&paymentMethod=" + paymentMethod +
                            "&gcashNumber=" + gcashNumber +
                            "&referenceNo=" + referenceNo +
                            "&guestuserid=" + guestuserid +
                            "&totalafterpromo=" +
                            '<?php echo $totalReservationPrice; ?>';
                        console.log("Booking Data:", bookingData);
                        xhrBooking.send(bookingData);

                    }
                };
                xhrBookingCart.send();
                window.location.href = "book-confirm.php?transactionID=" + transactionID;

            });
        } else {
            alert("Proceeding with other payment method.");
        }
    });
});
</script>

</body>

</html>