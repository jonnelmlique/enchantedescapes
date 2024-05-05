<?php
include './src/config/config.php';

if (isset($_POST['query'])) {
    $searchText = $_POST['query'];

    $query = "SELECT * FROM reservationprocess WHERE transactionid LIKE '%$searchText%'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="reservationstatusdetails.php?transactionid=' . $row['transactionid'] . '">' . $row['transactionid'] . '</a><br>';
        }
    } else {
        echo 'No results found.';
    }
}
?>