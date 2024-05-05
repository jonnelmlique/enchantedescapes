<?php
include '../src/config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/contact/Exception.php';
require '../src/contact/PHPMailer.php';
require '../src/contact/SMTP.php';

$defaultUserType = 'admin';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    $confirmPassword = trim(mysqli_real_escape_string($conn, $_POST['confirmPassword']));

    if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        $message = "All fields are required.";
    } else {

        $checkEmailQuery = "SELECT * FROM reservationusers WHERE email=?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $emailResult = $stmt->get_result();

        if ($emailResult->num_rows > 0) {
            $message = "Email already exists.";
        } else {

            $checkUsernameQuery = "SELECT * FROM reservationusers WHERE username=?";
            $stmt = $conn->prepare($checkUsernameQuery);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $usernameResult = $stmt->get_result();

            if ($usernameResult->num_rows > 0) {
                $message = "Username already exists.";
            } else {

                if ($password !== $confirmPassword) {
                    $message = "Password and Confirm Password do not match.";
                } else {

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $insertUserQuery = "INSERT INTO reservationusers ( email, username, password, usertype) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($insertUserQuery);
                    $stmt->bind_param("ssss", $email, $username, $hashedPassword, $defaultUserType);
                    if ($stmt->execute()) {
                        $message = "success";

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

                            $mail->Subject = 'Account Created Successfully';
                            $mail->Body = 'Welcome to Enchanted Escapes. Your account has been successfully created.';

                            $mail->send();
                        } catch (Exception $e) {

                            $message = "Error sending email: " . $mail->ErrorInfo;
                        }


                    } else {
                        $message = "Error: " . $stmt->error;
                    }
                }
            }
        }
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | Register</title>

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
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                        class="needs-validation">
                        <div class="border border-primary border rounded w-100 pt-4 pb-2 px-4">
                            <h5><label for="email" class="form-label text-uppercase">Email</label></h5>
                            <input type="email" class="form-control rounded bg-secondary mt-2" name="email" required />
                            <br />

                            <h5><label for="username" class="form-label text-uppercase">Username</label></h5>
                            <input type="text" class="form-control rounded bg-secondary mt-2" name="username"
                                required />
                            <br />

                            <h5><label for="password" class="form-label text-uppercase">Password</label></h5>
                            <input type="password" class="form-control rounded bg-secondary mt-2" name="password"
                                required />
                            <br />

                            <h5><label for="confirm-password" class="form-label text-uppercase">Confirm Password</label>
                            </h5>
                            <input type="password" class="form-control rounded bg-secondary mt-2" name="confirmPassword"
                                required />

                            <br />
                            <button type="submit"
                                class="btn btn-outline-primary w-100 d-block text-uppercase rounded">Register</button>
                    </form>
                    <!-- <a href="#" class="btn btn-outline-primary w-100 d-block text-uppercase rounded">Create
                            Account</a> -->
                    <a href="login.php"
                        class="btn btn-danger w-100 d-block text-uppercase rounded border-danger mt-4 mb-2 border-3">Cancel</a>
                </div>
            </div>
        </div>

        <br /><br />
    </div>
    </div>

    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if (!empty($message)) {
        if ($message === "success") {
            echo "<script>
        Swal.fire({
            title: 'Registration successful',
            text: 'You have successfully registered.',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Login'
        }).then((result) => {
            if (result.isConfirmed) {
                // Do something if user clicks OK
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = '../auth/login.php';
            }
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