<?php
include "sche_conn.php";
$id = $_GET["id"];
$sql = "DELETE FROM `shift` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: schedule.php?msg=Data deleted successfully");
} else {
  echo "Failed: " . mysqli_error($conn);
}
