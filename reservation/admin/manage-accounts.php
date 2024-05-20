<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hotel Reservation System | Accounts</title>

    <link href="../styles/bootstrap.min.css" rel="stylesheet" />
    <link href="../styles/booking.css" rel="stylesheet" />
    <link href="../styles/scrollbar.css" rel="stylesheet" />
    <link href="../styles/admin/manageaccounts.css" rel="stylesheet" />

</head>

<body>
    <?php include ("components/header.php"); ?>

    <div class="row w-100">
        <div class="col-lg-1">
            <?php include ("components/sidebar.php"); ?>
        </div>

        <div class="col-lg-8 bg-white shadow-lg">
            <div class="px-4">
                <h4 class="fw-bold text-uppercase">&gt; Employee</h4>
                <hr>
                <br />

                <div align="right">
                    <input type="search" class="form-control w-100px" name="search" placeholder="Search"
                        style="border-radius: 8px" id="searchInput" />

                </div>
                <br>
                <!-- <button class="btn btn-primary text-uppercase px-4" data-bs-toggle="modal"
                    data-bs-target="#addModal">Add</button>
                <br> -->
                <br />

                <table class="table table-hover table-stripped border border-dark"
                    style="border-radius: 8px; table-layout: fixed center" id="hruser">
                    <thead>
                        <tr>
                            <td class="bg-dark text-white">Name</td>
                            <td class="bg-dark text-white">Gender</td>
                            <td class="bg-dark text-white">Position</td>
                            <td class="bg-dark text-white">Department</td>
                            <td class="bg-dark text-white">Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../src/config/config.php';

                        $sql = "SELECT * FROM employee_info";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";

                                echo "<td class='fw-bold'>" . $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] . "</td>";
                                echo "<td>" . $row['Gender'] . "</td>";
                                echo "<td>" . $row['position'] . "</td>";
                                echo "<td>" . $row['Department'] . "</td>";
                                echo "<td class='text-" . ($row['Status'] == 'Active' ? 'success' : 'danger') . " text-uppercase'>" . $row['Status'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No users found</td></tr>";
                        }
                        $conn->close();
                        ?>


                    </tbody>
                </table>


            </div>

            <br /><br />
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #FAEBD7">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit User</h5>
                </div>
                <div class="modal-body" align="center">
                    <input type="hidden" name="hruserid" value="<?php echo $row['hruserid']; ?>">

                    <div class="row">
                        <div class="col-4" align="right">
                            <p class="mt-2">Name</p>
                        </div>
                        <div class="col-8"><input type="text" class="form-control" name="edit-name"
                                style="border-radius: 8px" placeholder="Name" /></div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">User Role</p>
                        </div>
                        <div class="col-8"><input type="text" class="form-control" name="edit-user-role"
                                style="border-radius: 8px" placeholder="User Role" />
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4" align="right">
                            <p class="mt-2">Status</p>
                        </div>
                        <div class="col-8">
                            <select class="form-control" name="edit-status" style="border-radius: 8px">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn continue-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #FAEBD7">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add User</h5>
                </div>
                <div class="modal-body" align="center">
                    <form id="addUserForm">
                        <div class="row">
                            <div class="col-4" align="right">
                                <p class="mt-2">Name</p>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="name" style="border-radius: 8px"
                                    placeholder="Name" />
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-4" align="right">
                                <p class="mt-2">User Role</p>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="user_role" style="border-radius: 8px"
                                    placeholder="User Role" />
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-4" align="right">
                                <p class="mt-2">Status</p>
                            </div>
                            <div class="col-8">
                                <select class="form-control" name="status" style="border-radius: 8px">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="addUserBtn" type="button" class="btn continue-btn">Save</button>
                </div>
            </div>
        </div>
    </div>



    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script>
    $(document).ready(function() {
        $('#addUserBtn').click(function() {
            var formData = $('#addUserForm').serialize();
            $.ajax({
                url: 'addhruser.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Success!',
                        text: 'You have successfully added the user.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseText,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
    </script> -->
    <script>
        $(document).ready(function () {
            $('#searchInput').on('keyup', function () {
                var searchText = $(this).val().trim();
                if (searchText !== '') {
                    $.ajax({
                        url: 'searchaccount.php',
                        type: 'post',
                        data: {
                            search: searchText
                        },
                        success: function (response) {
                            $('#hruser tbody').html(response);
                        }
                    });
                }
            });
        });
    </script>

    <!-- <script>
    $(document).ready(function() {
        $('tbody').on('click', 'tr', function() {
            var rowData = $(this).children("td").map(function() {
                return $(this).text();
            }).get();

            $('[name="edit-name"]').val(rowData[1]);
            $('[name="edit-user-role"]').val(rowData[2]);
            $('[name="edit-status"]').val(rowData[3].toLowerCase());

            var hruserid = $(this).find("td:first").text();
            $('[name="hruserid"]').val(hruserid);

            $('#editModal').modal('show');
        });

        $('.continue-btn').click(function() {
            var name = $('[name="edit-name"]').val();
            var userRole = $('[name="edit-user-role"]').val();
            var status = $('[name="edit-status"]').val();
            var hruserid = $('[name="hruserid"]').val();

            $.ajax({
                url: 'updatehruser.php',
                type: 'POST',
                data: {
                    name: name,
                    userRole: userRole,
                    status: status,
                    hruserid: hruserid
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Success!',
                        text: 'User information updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseText,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

    });
    </script> -->


</body>

</html>