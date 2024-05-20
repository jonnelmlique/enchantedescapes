

<!DOCTYPE html>
<html lang="en">
<head>
  
 
 
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">


  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   
</head>
<body>
    


        <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Admin</a>
                </div>
            </div>
            <ul class="sidebar-nav">

                <li class="sidebar-item">
                    <a href="attendance.php" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Attendance</span>
                    </a>
                </li>
<!--               
                <li class="sidebar-item">
    <a href="attendance.php" class="sidebar-link">
        <i class="fas fa-clock"></i>
        <span>Time-in and out</span>
    </a>
</li> -->

<!-- <li class="sidebar-item">
    <a href="" class="sidebar-link">
        <i class="fas fa-clock"></i>
        <span>Pending Attendance</span>
        <div class="dropdown-content">
            <a href="time_in.php">
            <a href="Timein.php"><i class="far fa-clock"></i><span>Time-in</span>
            </a>
            <a href="time_out.php">
                <i class="far fa-clock"></i><span>Time-out</span>
            </a>
        </div>
    </a>
</li> -->


<li class="sidebar-item">
    <a href="overtime.php" class="sidebar-link">
    <i class="far fa-clock"></i><!-- Use the existing icon class for Overtime -->
        <span>Overtime</span>
    </a>
</li>


                <li class="sidebar-item">
                    <a href="department.php" class="sidebar-link">
                        <i class="fas fa-building"></i>
                        <span>Department</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="employeeinfo.php" class="sidebar-link">
                        <i class="lni lni-folder"></i>
                        <span>Employee Info</span>
                    </a>
                </li>
                <li class="sidebar-item">
    <a href="admin-list.php" class="sidebar-link">
        <i class="fas fa-users"></i>
        <span>Admin List</span>
    </a>
</li>

                </li>
                <li class="sidebar-item">
                    <a href="" class="sidebar-link">
                        <i class="lni lni-notepad"></i>
                        <span>Document Processing</span>
                        <div class="dropdown-content">
                        <a href="id.php"> <i class="lni lni-postcard"></i><span>ID Request</i>
                        <a href="certificate.php"> <i class="lni lni-remove-file"></i><span>COE Request</i>
                    </a>

                </li>
                <li class="sidebar-item">
                    <a href="leave.php" class="sidebar-link">
                        <i class="lni lni-briefcase-alt"></i>
                        <span>Leave Management</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="schedule.php" class="sidebar-link">
                        <i class="lni lni-timer"></i>
                        <span>Schedule</span>
                    </a>
                </li>

                </li>
                <li class="sidebar-item">
    <a href="summary.php" class="sidebar-link">
        <i class="fas fa-file-alt"></i>
        <span>Summary Reports</span>
    </a>
</li>


                 <div class="sidebar-footer">
                <a href="logout.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
            </ul>
           
        </aside>
        <div class="main p-3">
            <div class="text-center">
            <div class="container">
</body>
</html>
