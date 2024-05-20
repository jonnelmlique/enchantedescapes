<?php 
    include 'conixion.php';
    if(isset($_POST['submit'])){
        
        $image = $_FILES['img']['name'];
        $tempname = $_FILES['img']['tmp_name'];  
        $folder = "../assets/img/".$image;
        
        if(move_uploaded_file($tempname,$folder)){
            echo 'images est uplade';
        }

        $Name = $_POST['Name'];
        $Address = $_POST['Address'];
        $Age= $_POST['Age'];
        $Phone = $_POST['Phone'];
        $StartDate = $_POST['StartDate'];
        $tatus = $_POST['Status'];

        $requete = $con->prepare("INSERT INTO employee_info(img,Name,Address,Age,Phone,StartDate,Status) VALUES('$image','$Name','$Address','$Age','$Phone','$StartDate','$Status')");
        //$requete->execute(array($image,$Name,$Email,$Phone,$EnrollNumber,$DateOfAdmission));
        $requete->execute();
    }
    header('location:infoindex.php')
    ?>