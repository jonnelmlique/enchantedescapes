<?php
include "db_conn.php";


// Get the employee name from the URL parameter
if(isset($_GET['Name'])) {
    $name = $_GET["Name"];
    
    // Construct the file path
    $pdfPath = "./certificates/" .$name .".pdf";
    
    // Check if the file exists
    if(file_exists($pdfPath)) {
        // Set the appropriate content type header
        header('Content-type: application/pdf');
        // Output the PDF file
        readfile($pdfPath);
        exit(); // Stop further execution after outputting the file
    } else {
        echo "Certificate not found.";
    }
} else {
    echo "Employee name not provided.";
}
?>
