<?php
include '../src/config/config.php';

if(isset($_POST['promoid'])) {
    $promoId = $_POST['promoid'];

    $sql = "DELETE FROM eespromo WHERE promoid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $promoId);

    if($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo "Bad Request";
}
?>