<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sbit3i');
define('DB_PASSWORD', '!SIA102Escapes');
define('DB_NAME', 'enchantedescapes');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false) {
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>