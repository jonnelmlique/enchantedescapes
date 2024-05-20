<?php
session_start();
$id = null; 
include 'conixion.php';
if (isset($_POST['submit']))
    $Name = $_POST['Name'];
    $Address = $_POST['Address'];
    $Age = $_POST['Age'];
    $Phone = $_POST['Phone'];
    $StartDate = $_POST['StartDate'];
    $Status = $_POST['Status'];
    $sql = "UPDATE  `employee_info` SET `Name`='$Name',`Address`='$Address',`Age`='$Age',`Phone`=$Phone',`StartDate`='$StartDate',`Status`='$Status' WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      header("Location: infoindex.php?msg=Data updated successfully");
    } else {
      echo "Failed: " . mysqli_error($conn);
    }
  
?>