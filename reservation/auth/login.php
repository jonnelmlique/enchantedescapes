<?php
include '../src/config/config.php';

session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $message = "Email and password are required.";
    } else {

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $sql = "SELECT * FROM reservationusers WHERE email=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $message = "Error preparing statement: " . $conn->error;
        } else {

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $storedPassword = $row['password'];

                if (password_verify($password, $storedPassword)) {
                    $_SESSION['userid'] = $row['userid'];
                    $_SESSION['usertype'] = $row['usertype'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['username'] = $row['username'];

                    if ($_SESSION['usertype'] == 'admin') {
                        header("Location: ../admin/dashboard.php");
                    } else {
                        header("Location: ../index.php");
                    }
                    exit();
                } else {
                    $message = "Incorrect password or email.";
                }
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | Log-in</title>

    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/entrance.css" rel="stylesheet" />
    <link href="../styles/scrollbar.css" rel="stylesheet" />
</head>

<body>

    <div class="row entrance">
        <div class="col-8">
        </div>

        <div class="col-4 bg-dirty-white position-fixed" style="height: 100vh; top: 0; right: 0;">
            <div class="d-flex align-items-center px-4 w-100" style="height: 100vh !important" align="center">
                <div class="d-block w-100">
                    <img src="../assets/logo.png" width="50%" />
                    <br /><br />
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" <div
                        class="border border-primary border rounded w-100 pt-4 pb-2 px-4">
                        <h5><label for="email" class="form-label text-uppercase">Email</label></h5>
                        <input type="email" class="form-control rounded bg-secondary mt-2" name="email" />
                        <br />

                        <h5><label for="password" class="form-label text-uppercase">Password</label></h5>
                        <input type="password" class="form-control rounded bg-secondary mt-2" name="password" />
                        <br />
                        <button type="submit"
                            class="btn btn-outline-primary w-100 d-block text-uppercase rounded">Login</button>



                    </form>
                    <!--
                            <a href="dashboard.php"
                            class="btn btn-outline-primary w-100 d-block text-uppercase rounded">Login</a> -->
                    <hr />
                    <!-- <a href="register.php"
                        class="btn btn-primary w-100 d-block text-uppercase rounded border-primary mt-4 border-3">Create
                        Account</a> -->
                    <!-- <a href="forgot.php"
                        class="btn btn-danger w-100 d-block text-uppercase rounded border-danger mt-4 mb-2 border-3">Forget
                        Password</a> -->
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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