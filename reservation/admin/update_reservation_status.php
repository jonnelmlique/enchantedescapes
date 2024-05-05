<?php
include '../src/config/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/contact/Exception.php';
require '../src/contact/PHPMailer.php';
require '../src/contact/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['status'])) {
        // Sanitize input
        $reservation_id = mysqli_real_escape_string($conn, $_POST['id']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        date_default_timezone_set('Asia/Manila');
        $currentTimestamp = date("Y-m-d H:i:s");

        $sql = "UPDATE reservationprocess SET status = '$status', reservationcompleted = '$currentTimestamp' WHERE recervationprocessid = $reservation_id";
        if ($conn->query($sql) === TRUE) {
            echo "Reservation status updated successfully";

            // Fetch reservation details
            $sql_reservation_details = "SELECT rp.*, r.roomtype, r.roominclusion, r.price, r.reservationprice
                                        FROM reservationprocess rp 
                                        INNER JOIN room r ON rp.roomid = r.roomid 
                                        WHERE rp.recervationprocessid = $reservation_id";
            $result_reservation_details = $conn->query($sql_reservation_details);
            if ($result_reservation_details->num_rows > 0) {
                $row_reservation_details = $result_reservation_details->fetch_assoc();

                $email = $row_reservation_details["emailaddress"];
                $prefix = $row_reservation_details["prefix"];
                $firstname = $row_reservation_details["firstname"];
                $lastname = $row_reservation_details["lastname"];
                $suffix = $row_reservation_details["suffix"];
                $mobilenumber = $row_reservation_details["mobilenumber"];
                $emailaddress = $row_reservation_details["emailaddress"];

                $paymentmethod = $row_reservation_details["paymentmethod"];
                $transactionid = $row_reservation_details["transactionid"];
                $roomtype = $row_reservation_details["roomtype"];
                $roominclusion = $row_reservation_details["roominclusion"];
                $price = $row_reservation_details["price"];
                $totalafterpromo = $row_reservation_details["totalafterpromo"];
                $roomfloor = $row_reservation_details["roomfloor"];
                $roomnumber = $row_reservation_details["roomnumber"];

                // Compose email body
                $subject = "Reservation Status Update - $status";
                $body = "Hello $firstname $lastname, <br><br>";
                $body .= "Your reservation status has been updated to: $status.<br><br>";

                $body .= "Guest Details:<br><br>";
                $body .= "Name: $prefix $firstname $lastname $suffix,<br>";
                $body .= "Contact No: $mobilenumber,<br>";
                $body .= "Email: $emailaddress,<br><br>";

                $body .= "Reservation Details:<br>";
                $body .= "Room Type: $roomtype<br>";
                $body .= "Room Floor: $roomfloor<br>";
                $body .= "Room Number: $roomnumber<br>";
                $body .= "Room Inclusion: $roominclusion<br>";
                $body .= "Reservation Price: ₱" . number_format($totalafterpromo, 2) . "<br>";
                $body .= "Payment Method: $paymentmethod<br>";
                $body .= "Transaction ID: <a href='http://localhost/eeh-reservation/reservationstatusdetails.php?transactionid=$transactionid'>$transactionid</a><br>";

                sendEmail($email, $subject, $body);
            } else {
                echo "Reservation details not found";
            }
        } else {
            echo "Error updating reservation status: " . $conn->error;
        }
    } else {
        echo "Reservation ID and status are required";
    }
} else {
    echo "Invalid request method";
}

$conn->close();

function sendEmail($email, $subject, $body)
{
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'enchantedescapescontact@gmail.com';
        $mail->Password = 'mqgqeokllxumgpzu';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('enchantedescapescontact@gmail.com', 'Enchanted Escapes');
        $mail->addAddress($email);
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>

?>