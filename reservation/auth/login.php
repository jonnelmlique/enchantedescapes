<?php
include '../src/config/config.php';

session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['login']) || empty($_POST['password'])) {
        $message = "Login and password are required.";
    } else {

        $login = trim($_POST['login']);
        $password = trim($_POST['password']);

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM admin_tbl WHERE email=?";
        } else {
            $sql = "SELECT * FROM admin_tbl WHERE adminID=?";
        }

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $message = "Error preparing statement: " . $conn->error;
        } else {

            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                if ($password === $row['password']) {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['adminID'] = $row['adminID'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['Department'] = $row['Department'];

                    if ($row['Department'] == 'Reservation Department') {
                        header("Location: ../admin/dashboard.php");
                        exit();
                    } else {
                        $message = "User is not from Reservation Department.";
                    }
                } else {
                    $message = "Incorrect password.";
                }
            } else {
                $message = "User with this login does not exist.";
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
                        <h5><label for="email" class="form-label text-uppercase">Email / ID</label></h5>
                        <input type="text" id="login" class="form-control rounded bg-secondary mt-2" name="login" />
                        <br />

                        <h5><label for="password" class="form-label text-uppercase">Password</label></h5>
                        <input type="password" id="password" class="form-control rounded bg-secondary mt-2"
                            name="password" />
                        <br />
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="showPasswordCheckbox">
                            <label class="form-check-label" for="showPasswordCheckbox">Show Password</label>
                        </div>
                        <button type="submit"
                            class="btn btn-outline-primary w-100 d-block text-uppercase rounded">Login</button>

                        <a href="/access/employee.php"
                            class="btn btn-danger w-100 d-block text-uppercase rounded border-danger mt-4 mb-2 border-3">Back</a>

                    </form>
                    <hr />
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
    <script>
    $(document).ready(function() {
        $('#showPasswordCheckbox').change(function() {
            var passwordInput = $('#password');
            var isChecked = $(this).is(':checked');
            if (isChecked) {
                passwordInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password');
            }
        });
    });
    </script>
</body>

</html>