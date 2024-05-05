<?php
include "../src/config/config.php"; 

if (isset($_POST['roomType'])) {
    $roomType = $_POST['roomType'];
    $sql = "SELECT DISTINCT roomfloor FROM roominfo WHERE roomtype = '$roomType'";
    $result = $conn->query($sql);

    $options = "<option value=''>Select Floor</option>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['roomfloor'] . "'>" . $row['roomfloor'] . "</option>";
        }
    }
    echo $options;
} else {
    echo "<option value=''>No floors found</option>";
}
?>