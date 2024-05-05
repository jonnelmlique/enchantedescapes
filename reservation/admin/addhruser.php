<?php
include '../src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Print the received data
    echo "Received data: ";
    print_r($_POST);

    $stmt = $conn->prepare("INSERT INTO hrusers (name, userrole, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $userrole, $status);

    $name = $_POST['name'];
    $userrole = $_POST['user_role'];
    $status = $_POST['status'];

    if ($stmt->execute()) {
        $message = "success";
    } else {
        $message = "error";
    }
    $stmt->close();
    $conn->close();
} else {
    $message = "error";
}
?>