<?php

session_start();

$db_host = "localhost";
$db_username = "sbit3i";
$db_password = "!SIA102Escapes";
$db_name = "enchantedescapes";

$db = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}