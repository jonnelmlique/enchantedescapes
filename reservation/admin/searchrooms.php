<?php
include '../src/config/config.php';
$searchText = isset($_POST['search']) ? $_POST['search'] : '';

$query = "SELECT * FROM room";
if (!empty($searchText)) {
    $query .= " WHERE roomtype LIKE '%$searchText%'";
}
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['roomtype'] . "</td>";
        echo "<td><img src='../rooms/" . $row['image'] . "' class='w-100' /></td>";

        $room_inclusions = explode(',', $row['roominclusion']);
        echo "<td>";
        foreach ($room_inclusions as $inclusion) {
            $inclusion = trim($inclusion);
            echo "<div class='cloud'>" . $inclusion . "</div>";
        }
        echo "</td>";
        echo "<td>";
        $beds_available = $row['bedsavailable'];
        echo "<div class='cloud'>" . $beds_available . "</div>";
        echo "</td>";

        echo "<td>" . $row['maxoccupancy'] . "</td>";
        echo "<td>₱" . number_format($row['reservationprice'], 2, '.', ',') . "</td>";
        echo "<td><p class='text-" . ($row['status'] == 'Booked' ? 'danger' : 'success') . " '>" . $row['status'] . "</p></td>";
        echo "<td><a href='./editroom.php?id=" . $row["roomid"] . "' class='btn btn-success w-100 px-2 edit-room-btn'>Edit</td>";

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No rooms found</td></tr>";
}
?>