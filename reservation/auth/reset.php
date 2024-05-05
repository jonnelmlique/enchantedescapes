<?php
include '../src/config/config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_GET['token'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $sql = "SELECT * FROM reservationusers WHERE reset_token='$token' AND reset_token_expiration > NOW()";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE reservationusers SET password='$hashed_password', reset_token=NULL, reset_token_expiration=NULL WHERE email='$email'";
            if ($conn->query($update_sql) === TRUE) {
                $message = "success";
            } else {
                $message = "Error updating password: " . $conn->error;
            }
        } else {
            $message = "Invalid or expired token.";
        }
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
                    <form action="#" method="POST" class="needs-validation">


                        <div class="border border-primary border rounded w-100 pt-4 pb-2 px-4">
                            <h5><label for="newpassword" class="form-label text-uppercase">New Password</label></h5>

                            <input type="password" id="password" class="form-control rounded bg-secondary mt-2"
                                name="password" required />
                            <h5><label for="username" class="form-label text-uppercase">Confirm Password</label></h5>

                            <input type="password" id="confirm_password" class="form-control rounded bg-secondary mt-2"
                                name="confirm_password" required />

                            <br /> <button type="submit"
                                class="btn btn-outline-primary w-100 d-block text-uppercase rounded">Submit</button>


                    </form>

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
                title: 'Reset successful',
                text: 'Your password has been successfully reset.',
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