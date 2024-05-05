<?php
include '../src/config/config.php';

$searchText = isset($_POST['search']) ? $_POST['search'] : '';

$sql = "SELECT * FROM eespromo";
if (!empty($searchText)) {
    $sql .= " WHERE promoname LIKE '%$searchText%'";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["promoname"] . "</td>";
        echo "<td>" . $row["percentage"] . "</td>";
        echo "<td>" . $row["available"] . "</td>";
        echo "<td>";
        echo "<button class='btn btn-success w-100' style='border-radius: 8px' onclick='populateModal(\"" . $row["promoname"] . "\", " . $row["percentage"] . ", " . $row["available"] . ", " . $row["promoid"] . ")' data-bs-toggle='modal' data-bs-target='#updateModal'>Edit</button><br />";
        echo "<button class='btn btn-danger w-100 mt-2' style='border-radius: 8px' onclick='confirmDelete(" . $row["promoid"] . ")'>Delete</button>";

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr>
                                    <td colspan='4'>No promos found.</td>
                                </tr>";
}
?>