<?php
include "db_conn.php";
include "sidebar.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <!--side bar-->
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    

    <!--Bootstrap 5 icons CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <title>Employee Information</title>
    <link rel="stylesheet" href="stylee.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="eistylee.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  </head>
  <body>
  
        <div class="main p-3">
            <div class="text-center">
            <div class="container">

            <body class="bg-content">
    <main class="dashboard d-flex">

        <!-- start content page -->
        <div class="container-fluid px-4">
        <?php 
            include "header.php";
        ?>
          
        
            <!-- start student list table -->
            <div class="student-list-header d-flex justify-content-between align-items-center py-2">
                <div class="title h6 fw-bold">Employee Information</div>
                <div class="btn-add d-flex gap-3 align-items-center">
                    <div class="short">
                        <i class="far fa-sort"></i>
                    </div>
                    <?php include 'infopopupadd.php'; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table student_list table-borderless">
                    <thead>
                        <tr class="align-middle">
                            <th class="opacity-0">vide</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Age</th>
                            <th>Phone</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th class="opacity-0">list</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          include 'conixion.php';
                          $result = $con -> query("SELECT * FROM employee_info");
                          foreach($result as $value):
                        ?>
                      <tr class="bg-white align-middle">
                        <td><img src="../assets/img/<?php echo $value['img'] ?>" alt="img" height="50" with="50"></td>
                                <td><?php echo $value['Name'] ?></td>
                                <td><?php echo $value['Address'] ?></td>
                                <td><?php echo $value['Age'] ?></td>
                                <td><?php echo $value['Phone'] ?></td>
                                <td><?php echo $value['StartDate'] ?></td>
                                <td><?php echo $value['Status'] ?></td>
                                <td class="d-md-flex gap-3 mt-3">
                                  <a href="modifier.php?Id=<?php echo $value['Id']?>"><i class="far fa-pen"></i></a>
                                  <a href="remove.php?Id=<?php echo $value['Id']?>"><i class="far fa-trash"></i></a>
                                </td>
                        </tr> 

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- end student list table -->
        </div>
        <!-- end content page -->
 
   

    <!--side bar-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <script src="scripts.js"></script>
    <script src="bootstrap.bundle.js"></script>
  </body>
</html>