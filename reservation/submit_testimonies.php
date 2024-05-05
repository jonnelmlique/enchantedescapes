<?php
include './src/config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nameornickname'];
    $message = $_POST['testimonies'];

    $transactionSuccessful = true;

    if ($transactionSuccessful) {
        $guestuserid = isset($_SESSION['guestuserid']) ? $_SESSION['guestuserid'] : null;
        if ($guestuserid) {
            $stmt = $conn->prepare("INSERT INTO testimonies (guestuserid, name, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $guestuserid, $name, $message);
            $stmt->execute();
            $stmt->close();
            echo "Testimonies inserted successfully.";
        } else {
            echo "Error: Guest user ID not found.";
        }
    } else {
        echo "Error: Transaction not successful.";
    }
}
?>