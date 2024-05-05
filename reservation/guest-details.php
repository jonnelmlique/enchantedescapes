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
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $prefix = $_POST['prefix'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $suffix = $_POST['suffix'];
    $mobileNumber = $_POST['mobile_number'];
    $emailAddress = $_POST['email_address'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];

    $sql = "INSERT INTO guestdetails (guestuserid, prefix, firstname, lastname, suffix, mobilenumber, emailaddress, country, address, city, zipcode) 
            VALUES ('" . $_SESSION['guestuserid'] . "', '$prefix', '$firstName', '$lastName', '$suffix', '$mobileNumber', '$emailAddress', '$country', '$address', '$city', '$zip')";

    if ($conn->query($sql) === TRUE) {
        header("Location: book-review.php");
        exit();
    } else {
        $message = "Error: " . $conn->error;
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

    <title>Hotel Reservation System | Guest Details</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="styles/booking.css" rel="stylesheet" />
    <link href="styles/bootstrap.min.css" rel="stylesheet" />
    <link href="styles/dashboard.css" rel="stylesheet" />
    <link href="styles/guest-details.css" rel="stylesheet" />
    <link href="styles/scrollbar.css" rel="stylesheet" />
</head>

<div> <?php include ("componentshome/navbar.php"); ?>

    <div class="bg-white">
        <br /><br />
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h3 class="fw-bold">Guest Details</h3>
                    <img src="assets/step-2.png" width="100%" />
                    <br /><br />

                    <div class="border border-primary w-100 p-2 px-3" style="border-radius: 12px">
                        <br />
                        <h4 class="fw-bold">Contact Info</h4>
                        <form method="post" class="needsvalidation">
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control" name="prefix" placeholder="Prefix"
                                        value="<?php echo isset($_SESSION['guest_details']['prefix']) ? $_SESSION['guest_details']['prefix'] : ''; ?>"
                                        oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')" />

                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name"
                                        value="<?php echo isset($_SESSION['guest_details']['firstname']) ? $_SESSION['guest_details']['firstname'] : ''; ?>"
                                        oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')" required />


                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                        value="<?php echo isset($_SESSION['guest_details']['lastname']) ? $_SESSION['guest_details']['lastname'] : ''; ?>"
                                        oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')" required />


                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="suffix" placeholder="Suffix"
                                        value="<?php echo isset($_SESSION['guest_details']['suffix']) ? $_SESSION['guest_details']['suffix'] : ''; ?>"
                                        oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')" />

                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control" name="mobile_number"
                                        placeholder="Mobile Number"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                                        maxlength="11"
                                        value="<?php echo isset($_SESSION['guest_details']['mobilenumber']) ? $_SESSION['guest_details']['mobilenumber'] : ''; ?>"
                                        required />



                                </div>
                                <div class="col-6">
                                    <input type="email" class="form-control" name="email_address"
                                        placeholder="Email Address"
                                        value="<?php echo isset($_SESSION['guest_details']['emailaddress']) ? $_SESSION['guest_details']['emailaddress'] : ''; ?>"
                                        required />


                                </div>
                            </div>
                            <br /><br />

                            <h4 class="fw-bold">Address</h4>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control" name="country" placeholder="Country"
                                        value="<?php echo isset($_SESSION['guest_details']['country']) ? $_SESSION['guest_details']['country'] : ''; ?>"
                                        oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')" required />


                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="address" placeholder="Address"
                                        value="<?php echo isset($_SESSION['guest_details']['address']) ? $_SESSION['guest_details']['address'] : ''; ?>"
                                        required />


                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" class="form-control" name="city" placeholder="City"
                                        value="<?php echo isset($_SESSION['guest_details']['city']) ? $_SESSION['guest_details']['city'] : ''; ?>"
                                        oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required />

                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="zip" placeholder="Zip Postal Code"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        value="<?php echo isset($_SESSION['guest_details']['zipcode']) ? $_SESSION['guest_details']['zipcode'] : ''; ?>"
                                        required />


                                </div>
                            </div>

                    </div>
                    <button type="submit" class="btn continue-btn w-100 text-uppercase"
                        style="border-radius: 8px; margin-top: 15px; background-color: #D4AF37; color: #fff; border-color: #D4AF37; transition: background-color 0.3s;"
                        onmouseover="this.style.backgroundColor='#6e5b1d'; this.style.borderColor='#6e5b1d';"
                        onmouseout="this.style.backgroundColor='#D4AF37'; this.style.borderColor='#D4AF37';">Continue to
                        Book</button>

                    </form>
                </div>


                <?php
                if (isset($_SESSION['guestuserid'])) {
                    $guestuserid = $_SESSION['guestuserid'];

                    $sql = "SELECT bc.*, r.roomtype 
            FROM reservationsummary bc 
            INNER JOIN room r ON bc.roomid = r.roomid 
            WHERE bc.guestuserid = '$guestuserid'";
                    $result = $conn->query($sql);
                    $totalReservationPrice = 0;

                    echo "<div class='col-4'>
            <div class='p-2 w-100 border border-primary border-2' style='border-radius: 8px'>
                <h4 class='fw-bold text-uppercase mt-2' align='center'>Your Booking Summary</h4>
                <hr class='mt-2 mx-3' />";

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
               
                <hr class='mt-2 mx-3' />";
                        }
                        echo "<div class='row mx-2 pt-2'>
                        <div class='col-6'><b>Total</b></div>
                        <div class='col-6' align='right'>₱" . number_format($totalReservationPrice, 2) . "</div>
                      </div>";

                        echo "</div></div>";


                        echo "</div>";
                    } else {
                        echo "<div align='center'>No bookings found.</div>";
                    }


                } else {
                    echo "Guest user ID not found in session.";
                }
                ?>

            </div>
        </div>
    </div>
    <br /><br />
</div>


<script src="scripts/jquery.min.js"></script>
<script src="scripts/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include ("components/footer.php"); ?>
<?php
if (!empty($message)) {
    echo "<script>
            Swal.fire({
                title: 'Error',
                text: '" . $message . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
}
?>
</body>

</html>