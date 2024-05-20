<head>
    <link href="../styles/admin/sidebar.css" rel="stylesheet" />
</head>

<div class="custom-sidebar" align="left">
    <img src="../assets/logo.png" class="logo" height="64" />

    <!-- <h5 class=" fw-bold text-primary text-uppercase">Admin Panel</h5> -->
    <br />

    <div class="px-1">
        <a href="../admin/dashboard.php" class="btn btn-primary text-white w-100 fw-bold"
            style="border-radius: 8px;">Dashboard</a>
        <a href="../admin/new-bookings.php" class="btn btn-primary text-white w-100 fw-bold mt-2"
            style="border-radius: 8px">New Bookings</a>
        <a href="../admin/cancelled-bookings.php" class="btn btn-primary text-white w-100 fw-bold mt-2"
            style="border-radius: 8px">Cancelled Bookings</a>
        <a href="../admin/booking-records.php" class="btn btn-primary text-white w-100 fw-bold mt-2"
            style="border-radius: 8px">Booking Records</a>
        <a href="../admin/promos.php" class="btn btn-primary text-white w-100 fw-bold mt-2"
            style="border-radius: 8px">Promos</a>
        <a href="../admin/rooms.php" class="btn btn-primary text-white w-100 fw-bold mt-2"
            style="border-radius: 8px">Rooms</a>
        <a href="../admin/manage-accounts.php" class="btn btn-primary text-white w-100 fw-bold mt-2"
            style="border-radius: 8px">Employee</a>
        <a href="../admin/reports.php" class="btn btn-primary text-white w-100 fw-bold mt-2"
            style="border-radius: 8px">Reports</a>
        <br /><br />

        <button class="btn btn-primary text-white w-100 fw-bold mt-3" style="border-radius: 8px" data-bs-toggle="modal"
            data-bs-target="#logoutModal">Log-out</button>
    </div>

</div>
<br /><br />

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #FAEBD7">
            <div class="modal-body" align="center">
                <br /><br />

                <p>Are you sure you want to logout?</p>
                <br />
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="../logout.php" class="btn btn-danger">Log-out</a>
            </div>
        </div>
    </div>
</div>