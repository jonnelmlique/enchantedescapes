<?php
include "../src/config/config.php"; 
if (isset($_POST['roomType']) && isset($_POST['floor'])) {
    $roomType = $_POST['roomType'];
    $floor = $_POST['floor'];
    $sql = "SELECT roomnumber FROM roominfo WHERE roomtype = '$roomType' AND roomfloor = $floor";
    $result = $conn->query($sql);

    $options = "<option value=''>Select Room Number</option>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['roomnumber'] . "'>" . $row['roomnumber'] . "</option>";
        }
    }
    echo $options;
} else {
    echo "<option value=''>No room numbers found</option>";
}
?>