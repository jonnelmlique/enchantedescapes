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
$conn->close();
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Contact</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./styles/dashboard.css" rel="stylesheet" />
    <link href="./styles/scrollbar.css" rel="stylesheet" />
    <link href="./styles/contact.css" rel="stylesheet" />

</head>


<div> <?php include ("componentshome/navbar.php"); ?>

    <div class="container contact-form">
        <h2>Contact Us</h2>


        <?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'src/contact/Exception.php';
        require 'src/contact/PHPMailer.php';
        require 'src/contact/SMTP.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $mail = new PHPMailer(true);

            try {

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'enchantedescapescontact@gmail.com';
                $mail->Password = 'mqgqeokllxumgpzu';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('enchantedescapescontact@gmail.com', 'Enchanted Escapes Hotel - Contact');
                $mail->addAddress('enchantedescapescontact@gmail.com');
                $mail->addReplyTo($email);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $message = "<p><strong>Sender Email:</strong> $email</p><br>" . $message;
                $mail->Body = $message;

                $mail->send();
                echo '<div class="alert alert-success" role="alert">Message has been sent</div>';
            } catch (Exception $e) {
                echo '<div class="alert alert-danger" role="alert">Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</div>';
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Send</button>
        </form>
    </div>

    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>

    <?php include ("components/footer.php"); ?>
    </body>

    </html>