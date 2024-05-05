<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../src/config/config.php';

    $name = $_POST['name'];
    $userRole = $_POST['userRole'];
    $status = $_POST['status'];
    echo "User Role: " . $userRole . "<br>";

    $hruserid = $_POST['hruserid'];

    $stmt = $conn->prepare("UPDATE hrusers SET name=?, userrole=?, status=? WHERE hruserid=?");
    $stmt->bind_param("sssi", $name, $userRole, $status, $hruserid);

    if ($stmt->execute()) {
        echo "User information updated successfully.";
    } else {
        echo "Error updating user information: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}


?>