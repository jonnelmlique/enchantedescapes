<?php
include './src/config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nameornickname']) && isset($_POST['testimonies'])) {
    $name = $_POST['nameornickname'];
    $message = $_POST['testimonies'];

    if (empty(trim($name)) || empty(trim($message))) {
        header("Location: index.php");
        exit;
    }

    $guestuserid = isset($_SESSION['guestuserid']) ? $_SESSION['guestuserid'] : null;
    if ($guestuserid) {
        $stmt = $conn->prepare("INSERT INTO testimonies (guestuserid, name, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $guestuserid, $name, $message);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | Confirm Booking</title>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="styles/booking.css" rel="stylesheet" />
    <link href="styles/bootstrap.min.css" rel="stylesheet" />
    <link href="styles/dashboard.css" rel="stylesheet" />
    <link href="styles/guest-details.css" rel="stylesheet" />
    <link href="styles/scrollbar.css" rel="stylesheet" />
    <style>
    .continue-button:hover {
        background-color: #6e5b1d;
        color: #fff;
    }
    </style>
</head>

<body>
    <div>
        <?php include ("componentshome/navbar.php"); ?>

        <div class="bg-white">
            <br /><br />
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <h3 class="fw-bold">Booking Confirm!</h3>
                        <img src="assets/step-4.png" width="100%" />
                        <br /><br />

                        <div class="border border-primary w-100 p-2 px-3" style="border-radius: 12px">
                            <br />
                            <h4 class="fw-bold text-uppercase">Booking confirmation has been sent to your email</h4>
                                                       <br />
                        </div><br />
                        <div class="card p-4 border border-primary" style="border-radius: 12px;">
                            <h5 class="fw-bold text-uppercase">Give your testimonies</h5>
                            <br>
                            <form id="testimoniesForm" method="POST" action="">
                                <div class="mb-3">
                                    <label for="nameornickname" class="form-label">Name or Nickname</label>
                                    <input type="text" class="form-control" id="nameornickname" name="nameornickname"
                                        placeholder="Enter your name or nickname">
                                </div>
                                <div class="mb-3">
                                    <label for="testimonies" class="form-label">Testimonies</label>
                                    <textarea class="form-control" id="testimonies" name="testimonies" rows="7"
                                        placeholder="Enter your Testimonies here"></textarea>

                                </div>
                            </form>
                        </div>

                        <br />

                        <button id="proceedButton" class="btn btn-primary mt-2 continue-button"
                            style="border-radius: 8px; width: 860px; transition: background-color 0.3s;">Continue</button>
                    </div>

                    <div class="col-4">
                    </div>
                </div>
            </div>
            <br /><br />
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("proceedButton").addEventListener("click", function() {
            console.log("Clicked Continue button");
            document.getElementById("testimoniesForm").submit();
        });
    });
    </script>
    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.bundle.min.js"></script>

    <?php include ("components/footer.php"); ?>
</body>

</html>