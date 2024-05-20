<?php
$servername = "localhost";
$username = "sbit3i";
$password = "!SIA102Escapes";
$dbname = "enchantedescapes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
