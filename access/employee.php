<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enchanted Escapes Hotel</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="employee.css">
</head>

<body>
    <div class="container">
        <div class="hoteltitle">
            <h1>Enchanted Escapes Hotel</h1>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="box" onclick="location.href='../HRM/employee/login.php';">
                    <div class="icon"><i class="fas fa-user"></i></div>
                    <div>Employee Time-In / Time-Out</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="box" onclick="location.href='../HRM/login_form.php';">
                    <div class="icon"><i class="fas fa-user-tie"></i></div>
                    <div>HRM</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="box" onclick="location.href='../reservation/auth/login.php';">
                    <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    <div>Reservation</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="box" onclick="location.href='../inventory/login.html';">
                    <div class="icon"><i class="fas fa-box-open"></i></div>
                    <div>Inventory</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="box" onclick="location.href='../payrolldepartment/loginform.php';">
                    <div class="icon"><i class="fas fa-money-bill"></i></div>
                    <div>Payroll</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="box" onclick="location.href='../billing/FrontDeskLogin.php';">
                    <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <div>Billing</div>
                </div>
            </div>
        </div>
    </div>
    <div id="bubblearea"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./bubble.js"></script>
</body>

</html>