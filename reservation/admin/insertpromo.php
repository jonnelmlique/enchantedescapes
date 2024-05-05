<?php
include '../src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $promoName = $_POST['promo-name'];
    $percentage = $_POST['percentage'];
    $available = $_POST['available'];

    $sql = "INSERT INTO eespromo (promoname, percentage, available) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sdi", $promoName, $percentage, $available);
    if ($stmt->execute()) {
        $message = "success";
    } else {
        $message = "error";
    }
    $stmt->close();
    $conn->close();

    echo json_encode(["message" => $message]);
}
?>