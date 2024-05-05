<?php
include '../src/config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/contact/Exception.php';
require '../src/contact/PHPMailer.php';
require '../src/contact/SMTP.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateToken()
{
    return bin2hex(random_bytes(32));
}

date_default_timezone_set('Asia/Manila');

function generateExpiration()
{
    return date('Y-m-d H:i:s', strtotime('+1 hour'));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT * FROM reservationusers WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $token = generateToken();
        $expiration = generateExpiration();

        $sql = "UPDATE reservationusers SET reset_token='$token', reset_token_expiration='$expiration' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'enchantedescapescontact@gmail.com';
                $mail->Password = 'mqgqeokllxumgpzu';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('enchantedescapescontact@gmail.com', 'Enchanted Escapes Hotel');
                $mail->addAddress($email);
                $mail->isHTML(true);

                $mail->Subject = 'Password Reset Link';
                $mail->Body = 'Click <a href="http://localhost/eeh-reservation/auth/reset.php?token=' . $token . '">here</a> to reset your password. This link is valid for 1 hour.';

                $mail->send();

                $message = "success";
            } catch (Exception $e) {
                $message = "Error sending email: " . $mail->ErrorInfo;
            }
        } else {
            $message = "Error updating record: " . $conn->error;
        }
    } else {
        $message = "Email not found.";
    }
}
$conn->close();
?>

<!DOCTYPE html>


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | Forgot Password</title>

    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/entrance.css" rel="stylesheet" />
    <link href="../styles/scrollbar.css" rel="stylesheet" />
</head>

<body>

    <div class="row entrance">
        <div class="col-8">
        </div>

        <div class="col-4 bg-white">
            <div class="d-flex align-items-center px-4 w-100" style="height: 100vh !important" align="center">
                <div class="d-block w-100">
                    <img src="../assets/logo.png" width="50%" />
                    <br /><br />
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


                        <div class="border border-primary border rounded w-100 pt-4 pb-2 px-4">
                            <h5><label for="username" class="form-label text-uppercase">Email</label></h5>
                            <input type="email" id="email" class="form-control rounded bg-secondary mt-2" name="email"
                                required />
                            <br />
                            <button type="submit"
                                class="btn btn-outline-primary w-100 d-block text-uppercase rounded">Send Reset
                                Link</button>
                    </form>
                    <?php
                    if (!empty($message)) {
                        echo "<script>
        Swal.fire({
            title: '" . ($message === "success" ? "Email sent" : "Error") . "',
            text: '" . ($message === "success" ? "Password reset link sent to your email." : $message) . "',
            icon: '" . ($message === "success" ? "success" : "error") . "',
            confirmButtonText: 'OK'
        });
    </script>";
                    }
                    ?>
                    <hr />
                    <a href="login.php"
                        class="btn btn-danger w-100 d-block text-uppercase rounded border-danger mt-4 mb-2 border-3">Cancel</a>
                </div>
            </div>

        </div>
    </div>
    </div>
    <script src="scripts/jquery.min.js">
    </script>
    <script src="scripts/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
            Swal.fire({
                title: 'Reset Link Sent Successfully',
                text: 'You have successfully sent the reset link to your email.',
                icon: 'success',
                confirmButtonText: 'OK',
               
            });
        </script>";
        } else {
            echo "<script>
            Swal.fire({
                title: 'Error',
                text: '" . $message . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
        }
    }
    ?>
</body>

</html>