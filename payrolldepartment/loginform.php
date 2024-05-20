<?php
include 'db_connection.php';

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

                    if ($row['Department'] == 'Payroll Department') {
                        header("Location: employee.php");
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
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PMS | Log-in</title>
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="icon" href="Images/icon.png">
</head>

<body>
    <div class="container">
        
        <div class="heading">
            <h2>PMS | Log in</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-container">
            <label for="login">Email / ID</label>
            <input type="text" id="login" name="login" placeholder="Enter your email or ID">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">

            <div class="form-check">
                <input type="checkbox" id="showPasswordCheckbox" class="form-check-input"
                <label for="showPasswordCheckbox" class="form-check-label">Show Password</label>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>
        <hr>
        <?php
        if (!empty($message)) {
            echo "<p class='error-message'>$message</p>";
        }
        ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('showPasswordCheckbox').addEventListener('change', function() {
                var passwordInput = document.getElementById('password');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            });
        });
    </script>
</body>

</html>


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