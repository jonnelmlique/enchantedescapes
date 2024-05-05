<?php
include "../src/config/config.php";

$sql = "SELECT DISTINCT roomtype FROM roominfo";
$result = $conn->query($sql);

$options = "<option value=''>Select Room Type</option>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['roomtype'] . "'>" . $row['roomtype'] . "</option>";
    }
}
echo $options;
?>