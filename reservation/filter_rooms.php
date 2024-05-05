<?php
include './src/config/config.php'; 

$selectedRoomType = isset($_POST['room']) ? $_POST['room'] : '';
$sortByPrice = isset($_POST['price']) ? $_POST['price'] : '';

$sql = "SELECT * FROM room";
if (!empty($selectedRoomType)) {
    $sql .= " WHERE roomtype = '$selectedRoomType'";
}

if (!empty($sortByPrice)) {
    if ($sortByPrice == 'lowest') {
        $sql .= " ORDER BY price ASC";
    } elseif ($sortByPrice == 'highest') {
        $sql .= " ORDER BY price DESC";
    }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="border border-primary w-100 p-2" style="border-radius: 12px; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor=\'#f0f0f0\';" onmouseout="this.style.backgroundColor=\'\';">';
        echo '<div class="row">';
        echo '<div class="col-5">';
        echo '<img src="./rooms/' . $row["image"] . '" alt="Rooms Image" class="w-100" style="border-radius: 8px" />';
        echo '</div>';
        echo '<div class="col-4">';
        echo '<h4 class="fw-bold mt-2">' . $row['roomtype'] . '</h4>';
        echo '<p>';
        echo '<i class="lni lni-home"></i> Beds: ' . $row['bedsavailable'] . '<br />';
        echo '<i class="lni lni-layers"></i> Included: ' . $row['roominclusion'] . '<br />';
        echo '<i class="lni lni-user"></i> Ocuppancy: ' . $row['maxoccupancy'];
        echo '</p>';
        echo '</div>';
        echo '<div class="col-3">';
        echo '<h4 class="fw-bold mt-2">₱' . number_format($row['price'], 2, '.', ',') . '</h4>';
        echo '<small>Per Night</small><br /><br />';
        echo '<h4 class="fw-bold mt-2">₱' . number_format($row['reservationprice'], 2, '.', ',') . '</h4>';
        echo 'Reservation<br /><br />';
        echo '<button class="btn btn-primary w-100 reserve-btn" style="border-radius: 8px" data-roomid="' . $row['roomid'] . '" data-roomtype="' . $row['roomtype'] . '" data-maxoccupancy="' . $row['maxoccupancy'] . '" data-price="' . $row['price'] . '" data-reservationprice="' . $row['reservationprice'] . '" data-bs-toggle="modal" data-bs-target="#reserveModal">Reserve Now</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<br />';
    }
} else {
    echo "No rooms available.";
}

$conn->close();
?>